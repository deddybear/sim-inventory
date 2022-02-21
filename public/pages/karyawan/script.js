$(document).ready(function() {
    let method;
    let id;

    let column = [
        'name',
        'email',
        'roles'
    ];

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    let message = messageErrors => {
        var temp = '';
        if (messageErrors instanceof Array) {
                messageErrors.forEach(element => {
                    temp += `${element} <br>`
                });
                return temp;
        } else {
            return messageErrors ? `${messageErrors} <br>` : ' '
        }
       
    }

    function domModal(textTitle, textConfrim, textClose) {
        $('.modal-title').html(textTitle)
        $('#btn-confrim').html(textConfrim)
        $('#btn-cancel').html(textClose)
    }

    $(".date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
    });

    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/karyawan/data",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "name", name: "name" },
            { data: "email", name: "email"},
            { data: "roles", name: "roles"},
            { data: "created_at", name: "created_at" },
            { data: "updated_at", name: "updated_at" },
            {
                data: "Actions",
                name: "Actions",
                orderable: false,
                serachable: false,
                sClass: "text-center",
            },
        ],
        initComplete: function () {
            this.api()
                .columns()
                .every(function () {
                    var that = this;
                    $("input", this.footer()).on(
                        "keyup change clear",
                        function () {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        }
                    );
                });

            $('#loader-wrapper').hide();
        },
    });

    // DOM Search func
    $("#dataTable tfoot .search").each(function (i) {
        $(this).html(`<input 
                type="text" 
                data-column="${column[i]}" 
                class="autocomplete_f text-sm form-control" 
                placeholder="Search ${column[i].replace("_", " ").charAt(0).toUpperCase() + column[i].slice(1)}"
        />`);
    });

    // Search func
    $(document).on("focus", ".autocomplete_f", function () {
        let column = $(this).data("column")

        $(this).autocomplete({
            minLength:3,
            max: 13,
            scroll: true,
            source: function (request, response) {
                $.ajax({
                    url: `/karyawan/search`,
                    dataType: "JSON",
                    data: {
                        keyword: request.term,
                        column: column,
                    },
                    beforeSend : function () {
                        $('#loader-wrapper').show();
                    },
                    complete: function() {
                        $('#loader-wrapper').hide();
                    },
                    success: function (data) {
                        let array = [];
                        let index = 0;

                        $.map(data, function (item) {
                            array[index++] = item[column];
                        });

                        response(array);
                    },
                    error: function (err) {
                        response(["Tidak Ditemukan di Database"]);
                    },
                });
            }
        })
    });

    //DOM add data func
    $('#add').click(function() {
        $("#form")[0].reset();
        domModal('Menambahkan Data Karyawan', 'Tambah', 'Batalkan')
        method = "POST";

    });

    // DOM edit data func
    $('tbody').on('click', '.edit', function() {
        method = "PUT";
        $('#form')[0].reset()
        id = $(this).attr('data')
        domModal('Edit Data Karyawan', 'Simpan Perubahan', 'Batalkan')
        $('#modal_form').modal('show')
    });

    //add
    $("#form").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "/karyawan/create",
            method: "POST",
            dataType: "JSON",
            data: $("#form").serialize(),
            beforeSend : function () {
                $('#loader-wrapper').show();
            },
            complete: function() {
                $('#loader-wrapper').hide();
            },
            success: function (data) {
         
                if (data.success) {
                    Swal.fire("Sukses!", data.success, "success");
                    location.reload();
                }
            },
            error: function (res) {
                let text = '';      
                
                for (const key in res.responseJSON.errors) {
                    text += message(res.responseJSON.errors[key]); 
                }

                Swal.fire(
                    'Whoops ada Kesalahan',
                    `Error : <br> ${text}`,
                    'error'
                )
            },
        });
    });

    $("#form-update").on("submit", function (e) {
        let id = $(this).attr("data-id");
        console.log(id);
        e.preventDefault();

        $.ajax({
            url: `/karyawan/update/${id}`,
            method: "PUT",
            dataType: "JSON",
            data: $("#form-update").serialize(),
            beforeSend : function () {
                $('#loader-wrapper').show();
            },
            complete: function() {
                $('#loader-wrapper').hide();
            },
            success: function (data) {
         
                if (data.success) {
                    Swal.fire("Sukses!", data.success, "success");
                    location.reload();
                }
            },
            error: function (res) {
                let text = '';      
                
                for (const key in res.responseJSON.errors) {
                    text += message(res.responseJSON.errors[key]); 
                }

                Swal.fire(
                    'Whoops ada Kesalahan',
                    `Error : <br> ${text}`,
                    'error'
                )
            },
        });
    });

    $('tbody').on('click', '.delete', function() { 
        let id = $(this).attr('data')

        Swal.fire({
            title: "Apakah kamu yakin ??",
            text: "Setelah terhapus, ini tidak bisa dikembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Saya Setuju!",
            cancelButtonText: "Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/karyawan/delete/${id}`,
                    method: 'DELETE',
                    dataType: 'JSON',
                    beforeSend : function () {
                        $('#loader-wrapper').show();
                    },
                    complete: function() {
                        $('#loader-wrapper').hide();
                    },
                    success: function (res) {
                        Swal.fire("Deleted!", res.success, "success");
                        location.reload();
                    },
                    error: function (res) {
                        let text = '';
                        console.log(res.responseJSON.errors);
                        
                        for (const key in res.responseJSON.errors) {
                            text += message(res.responseJSON.errors[key]); 
                        }

                        Swal.fire(
                            'Whoops ada Kesalahan',
                            `Error : <br> ${text}`,
                            'error'
                        )
                    }
                })
            } else {
                Swal.fire("Batal !","Opreasi penghapusan dibatalkan", "warning")
            }
        });
    })
})
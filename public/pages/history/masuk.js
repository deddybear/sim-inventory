$(document).ready(function () {
    let id;

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

    function alert(title, text, timer) {
        let timerInterval;
        
        Swal.fire({
            title: 'Auto close alert!',
            html: 'I will close in <b></b> milliseconds.',
            timer: 2000,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log('I was closed by the timer')
            }
          })
    }

    let column = [ 
        'descr',
        'qty'
    ];

    $(".date").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
    });

    $('#tanggal').datetimepicker({
        viewMode: 'days',
        minViewMode: 'days',
        format: 'DD'
    });

    $('#bulan').datetimepicker({
        viewMode: 'months',
        minViewMode: 'months',
        format: 'MM'
    });

    $('#tahun').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });

    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/history/data/add",
        columns: [
            { data: "created_at", name: "created_at"},
            { 
                data: "item.name", 
                name: "item.name",  
            },
            { data: "descr", name: "descr"},
            { data: "qty", name: "qty" },
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
                    url: `/history/search`,
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

    //func rollback
    $('tbody').on('click', '.delete', function() {

        let id   = $(this).attr('data');
        let desc = $(this).data('desc');
        let name = $(this).data('name');
        let act  = $(this).data('act');
        let qty =  $(this).data('qty');

        Swal.fire({
            title: `Apakah Ingin Merollback <br> ${desc} ${name} ? `,
            text: "Setelah terollback, ini tidak bisa dikembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Saya Setuju!",
            cancelButtonText: "Batalkan"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/history/rollback/${id}`,
                    method: 'DELETE',
                    dataType: 'JSON',
                    data: {
                        act: act,
                        qty: qty
                    },
                    beforeSend : function () {
                        $('#loader-wrapper').show();
                    },
                    complete: function() {
                        $('#loader-wrapper').hide();
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire("Sukses!", data.success, "success");
                            location.reload();
                        } else {
                            Swal.fire("Peringatan!", data.info, "warning");
                        }
                        
                    },
                    error: function (response) {
                        console.log(response);
        
                        var text = '';
                    
                        for (key in response.responseJSON.errors) {
                            text += message(response.responseJSON.errors[key]);                    
                        }
                        
                        Swal.fire(
                            'Whoops ada Kesalahan',
                            `Error : <br> ${text}`,
                            'error'
                        )
                    }
                });
            } else {
                Swal.fire("Batal !","Operasi rollback dibatalkan", "warning")
            }
        });

    });

    //delete func
    $('#form').on('submit', function(e) {
        e.preventDefault();

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
                    url: '/history/delete/add',
                    method: 'DELETE',
                    dataType: 'JSON',
                    data: $('#form').serialize(),
                    beforeSend : function () {
                        $('#loader-wrapper').show();
                    },
                    complete: function() {
                        $('#loader-wrapper').hide();
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire("Sukses!", data.success, "success");
                            location.reload();
                        } else {
                            Swal.fire("Peringatan!", data.info, "warning");
                        }
                        
                    },
                    error: function (response) {
                        console.log(response);
        
                        var text = '';
                    
                        for (key in response.responseJSON.errors) {
                            text += message(response.responseJSON.errors[key]);                    
                        }
                        
                        Swal.fire(
                            'Whoops ada Kesalahan',
                            `Error : <br> ${text}`,
                            'error'
                        )
                    }
                });
            } else {
                Swal.fire("Batal !","Opreasi penghapusan dibatalkan", "warning")
            }
        });

       
    })
})
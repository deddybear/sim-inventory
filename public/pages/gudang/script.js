$(document).ready(function () {
    moment.locale("id");
    let method;
    let id;

    let column = [
        'name',
        'type.name',
        'qty'
    ];

    let validationQty = [];

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

    const idrFormatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });

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

    //read all data func
    $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/gudang/data",
        columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "item_code", name: "item_code" },
            { data: "name", name: "name" },
            { data: "type.name", name: "type.name" },            
            { 
                data: function (row) {
                    if (row.qty == 0) {
                        if (validationQty[row.DT_RowIndex] == null) {
                            toastr.warning(`Stock ${row.name} Kosong mohon untuk me-restock ulang`)
                        }
                        validationQty[row.DT_RowIndex] = row.id;
                    }
                    return row.qty; 
                }, 
                name: "qty" 
            },
            { data: "unit.name", name: "unit.name"},
            { 
                data: function (row) {
                    return idrFormatter.format(row.price);
                }, 
                name: "price"},
            { 
                data: function (row) {
                    return idrFormatter.format(row.total);
                }, 
                name: "total"},
            { data: "date_entry", name: "date_entry" },
            { data: "date_out", name: "date_out"},
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
                    url: `/gudang/search`,
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


    //adding stock func
    $("tbody").on("click", ".adding", function () {
        id = $(this).attr("data");
        
        Swal.fire({
            title: 'Berapa Stock anda tambahkan',
            input: 'number',
            inputAttributes: {
              autocapitalize: 'off'
            },
            confirmButtonText: 'Tambah',
            cancelButtonText: "Batalkan",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: (stock) => {
              return fetch(`/gudang/add/${stock}/${id}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json()
                })
                .catch(error => {
                  Swal.showValidationMessage(
                    `Request failed: ${error}`
                  )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
                
                Swal.fire("Sukses!", "Berhasil Ditambahkan", "success");
                location.reload();
            }
          })
    });

    $("tbody").on("click", ".reduce", function () {
        id = $(this).attr("data");
        
        Swal.fire({
            title: 'Berapa Stock anda kurangi',
            input: 'number',
            inputAttributes: {
              autocapitalize: 'off'
            },
            confirmButtonText: 'Kurangi',
            cancelButtonText: "Batalkan",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            preConfirm: (stock) => {
              return fetch(`/gudang/reduce/${stock}/${id}`)
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json()
                })
                .catch(error => {
                  Swal.showValidationMessage(
                    `Request failed: ${error}`
                  )
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
                
                Swal.fire("Sukses!", "Berhasil Dikurangi", "success");
                location.reload();
            }
          })
    });

    //DOM add data func
    $('#add').click(function() {
        $("#form")[0].reset();
        domModal('Menambahkan Gudang Bahan Baku', 'Tambah', 'Batalkan')
        method = "POST";

    })


    //add | edit func
    $("#form").on("submit", function (e) {
        e.preventDefault();
        var url;

        console.log(`submit ${method}`);
        if (method == "POST") {
            url = "/gudang/create";
        } else if (method == "PUT") {
            url = `/gudang/update/${id}`;
        }

        $.ajax({
            url: url,
            method: method,
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
            error: function (response) {
                var text = '';
                    
                for (key in response.responseJSON.errors) {
                    text += message(response.responseJSON.errors[key]);                    
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
                    url: `/gudang/delete/${id}`,
                    method: 'DELETE',
                    dataType: 'JSON',
                    beforeSend : function () {
                        $('#loader-wrapper').show();
                    },
                    complete: function() {
                        $('#loader-wrapper').hide();
                    },
                    success: function (response) {
                        Swal.fire("Deleted!", response.success, "success");
                        location.reload();
                    },
                    error: function (response) {
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
                })
            } else {
                Swal.fire("Batal !","Opreasi penghapusan dibatalkan", "warning")
            }
        });
    })
})
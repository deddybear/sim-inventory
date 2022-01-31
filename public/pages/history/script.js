$(document).ready(function () {
    let id;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    let column = [
        'name',
        'type',
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
        ajax: "/history/data",
        columns: [
            { data: "date_time", name: "date_time"},
            { data: "name", name: "name"},
            { data: "type", name: "type" },
            { data: "qty", name: "qty" },
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
    })

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
})
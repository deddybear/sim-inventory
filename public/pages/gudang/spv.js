$(document).ready(function () {
    
    let validationQty = [];

    const idrFormatter = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });

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
            { data: "type.code", name: "type.code" },
            { data: "name", name: "name" },
            { 
                data: "type.name", 
                name: "type.name" 
            },                 
            { 
                data: function (row) {
                    if (row.qty <= 5) {
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
            {data: "rack.name", name: "rack.name"},
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
})
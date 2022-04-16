$(document).ready(function () {

    $.ajax({
        url: '/stock-kosong',
        method: 'GET',
        dataType: 'JSON',
        success: function(data) {
            let html = '';
            $.each(data, function (index, row) {

                html += `<li>${row.name}</li>`
            })

            Swal.fire(
                'Peringatan Stock !',
                `Stock Bahan Baku ${html} <br> Mohon untuk Memesan Kembali`,
                'warning'
            )
            // data.forEach(announcement);
        },
        error: function() {
            Swal.fire(
                'Whoops ada Kesalahan Pada Fetch data Stock',
                `Error : Internal Server Error`,
                'error'
            )
        }
        
    })

    function announcement (item, index) {
        Swal.fire(
            'Peringatan Stock',
            `Stock Bahan Baku ${item[index].name} : ${item[index].qty} <br> Mohon untuk Memesan Kembali`,
            'warning'
        )
    }


})
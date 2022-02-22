$(document).ready(function() {
    $('.bulan').datetimepicker({
        viewMode: 'months',
        minViewMode: 'months',
        format: 'MM'
    });

    $('.tahun').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });

    $('#loader-wrapper').hide();
})
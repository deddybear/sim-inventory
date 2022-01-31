$(document).ready(function () {
    
    const MONTHS = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    ];

    const type = [
        'Material',
        'Paint',
        'Utils',
        'Technical',
        'Soft'
    ]

    const backgroundColor = () => [
        'rgba(255, 99, 132, 0.2)',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 205, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(201, 203, 207, 0.2)'
    ]
    const borderColor = () => [
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64)',
        'rgb(255, 205, 86)',
        'rgb(75, 192, 192)',
        'rgb(54, 162, 235)',
        'rgb(153, 102, 255)',
        'rgb(201, 203, 207)'
    ]
    function option(title) {
        return {
            options: {
                responsive: 'true',
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        };
    }


    const chartPemasukanBB = new Chart($('#pemasukanbb'), {
        type: 'bar',
        data : {
            labels: MONTHS,
            datasets: [
                {
                    label: 'Pemasukan Pada Gudang Bahan Baku',
                    data: [65, 59, 80, 81, 56, 55, 40, 80, 81, 56, 55, 40],
                    backgroundColor:  'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                }
            ]
        },
        options: option('Grafik Pemasukan Bahan Baku'),
    });

    const chartPengeluaranBB = new Chart($('#pengeluaranbb'), {
        type: 'bar',
        data: {
            labels: MONTHS,
            datasets: [{
                label: 'Pengeluaran Pada Gudang Bahan Baku',
                data: [65, 59, 80, 81, 56, 55, 40, 80, 81, 56, 55, 40],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
            }]
        },
        option: option('Grafik Pemasukan Bahan Baku'),
    })

    const chartPemasukanJenis = new Chart($('#pemasukanjenis'), {
        type: 'pie',
        data: {
            labels:type,
            datasets: [{
                label: 'Jenis Pemasukan Bahan Baku',
                data: [20, 59, 30, 81, 44],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
            }]
        },
        option: option('Grafik Pemasukan Jenis Bahan Baku'),
    });

    const chartPengeluaranJenis = new Chart($('#pengeluaranjenis'), {
        type: 'pie',
        data: {
            labels:type,
            datasets: [{
                label: 'Jenis Pengeluaran Bahan Baku',
                data: [20, 59, 30, 81, 44],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
            }]
        },
        option: option('Grafik Pengeluaran Jenis Bahan Baku'),
    });
})
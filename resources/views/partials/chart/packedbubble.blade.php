<div class="charts">
    <h4 class="chart_css">
        <b><i class="fa-regular fa-comments"></i>{{ $title }}</b>
    </h4>
    <p></p>
    <div id="PackedBubble"
        style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>
{{-- <meta name="viewport" content="width=device-width, initial-scale=1.0">  --}}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/module-name.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script>
    var seriesOptions = {!! json_encode($packedbubble_data) !!};
    var PackedBubble = Highcharts.chart('PackedBubble', {
        chart: {
            type: 'packedbubble',
            // height: '100%'
        },
        title: {
            text: '',
            align: 'left'
        },
        tooltip: {
            useHTML: true,
            pointFormat: '<b>{point.name}:</b> {point.value}'
        },
        plotOptions: {
            packedbubble: {
                minSize: '1%',
                maxSize: '100%',
                zMin: 0,
                zMax: 4000,
                layoutAlgorithm: {
                    splitSeries: false,
                    gravitationalConstant: 0.02
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    filter: {
                        property: 'y',
                        operator: '>',
                        value: 1000
                    },
                    style: {
                        color: 'black',
                        textOutline: 'none',
                        fontWeight: 'normal'
                    }
                }
            }
        },
        series: seriesOptions

        // series: [{
        //     name: 'Europe',
        //     data: [{
        //             name: 'Germany',
        //             value: 767.1
        //         },
        //         {
        //             name: 'Croatia',
        //             value: 20.7
        //         },
        //         // ... 插入其他數據
        //     ]
        // }, {
        //     name: 'Africa',
        //     data: [{
        //             name: 'Senegal',
        //             value: 8.2
        //         },
        //         {
        //             name: 'Cameroon',
        //             value: 9.2
        //         },
        //         // ... 插入其他數據
        //     ]
        // }, {
        //     name: 'Oceania',
        //     data: [{
        //             name: 'Australia',
        //             value: 409.4
        //         },
        //         {
        //             name: 'New Zealand',
        //             value: 34.1
        //         },
        //         // ... 插入其他數據
        //     ]
        // }, {
        //     name: 'North America',
        //     data: [{
        //             name: 'Costa Rica',
        //             value: 7.6
        //         },
        //         {
        //             name: 'Honduras',
        //             value: 8.4
        //         },
        //         // ... 插入其他數據
        //     ]
        // }, {
        //     name: 'South America',
        //     data: [{
        //             name: 'El Salvador',
        //             value: 7.2
        //         },
        //         {
        //             name: 'Uruguay',
        //             value: 8.1
        //         },
        //         // ... 插入其他數據
        //     ]
        // }, {
        //     name: 'Asia',
        //     data: [{
        //             name: 'Nepal',
        //             value: 6.5
        //         },
        //         {
        //             name: 'Georgia',
        //             value: 6.5
        //         },
        //         // ... 插入其他數據
        //     ]
        // }]
    });
</script>

</body>

</html>

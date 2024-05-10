<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UEFA Champions League Top Scorers</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
    <div id="container" style="width:100%; height:260px;"></div>
    <script>
        // Create the bar chart using Highcharts
        Highcharts.chart('container', {
            chart: {
                backgroundColor: '#3f3f3f',
                type: 'bar',
                height: 280,
            },
            title: {
                text: '熱門人物',
                style: {
                    color: '#ffffff'
                }
            },
            xAxis: {
                categories: ['柯文哲', '蔡英文', '侯友宜','韓國瑜'],
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            legend: {
                reversed: true,
                itemStyle: {
                    color: '#ffffff'
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    borderWidth: 0,
                    dataLabels: {
                        enabled: false
                    }
                }
            },
            series: [{
                name: '正面',
                data: [14, 4, 6 ,4],
                color: '#189cdf'
            }, 
            {
                name: '負面',
                data: [5, 10, 4 ,2],
                color: '#db2136'
            }]
        });
    </script>
</body>
</html>

<div class="charts">

    <p></p>
    <div id="BubbleChart" style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script>
    var seriesOptions = {!! json_encode($bubble_data) !!};
    var BubbleChart = Highcharts.chart('BubbleChart', {
    chart: {
        backgroundColor: 'rgba(63, 63, 63, 0)', 
        type: 'bubble',
        plotBorderWidth: 1,
        zoomType: 'xy'
    },
    
    title: {
        text: '定位圖',
        style: {
            color: '#ffffff'
        }
    },
    
    xAxis: {
        title: {
            text: '出現頻率',
            style: {
                color: '#ffffff'
            }
        },
        gridLineWidth: 1,
        accessibility: {
            rangeDescription: 'Range: 0 to 100.'
        },
        labels: {
            style: {
                color: '#ffffff'
            }
        }
    },
    yAxis: {
        title: {
            text: '正負面',
            style: {
                color: '#ffffff'
            }
        },
        startOnTick: false,
        endOnTick: false,
        accessibility: {
            rangeDescription: 'Range: 0 to 100.'
        },
        labels: {
            style: {
                color: '#ffffff'
            }
        }
    }, 
    plotOptions: {
        series: {
            dataLabels: {
                enabled: true,
                format: '{point.name}',
                style: {
                    color: '#ffffff',
                    textOutline: 'none',
                    fontWeight: 'bold',
                    fontSize: '14px'
                },
            },
            marker: {
                fillOpacity: 1
            }
        }
    },
    legend: {
        enabled: false // 禁用圖例
    },
    exporting: {
                enabled: false  
            },
    series: seriesOptions,
});

</script>

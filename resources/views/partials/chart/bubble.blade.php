<div class="charts">
    <h4 class="chart_css">
        <b><i class="fa-regular fa-comments"></i>{{ $title }}</b>
    </h4>
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
            type: 'bubble',
            plotBorderWidth: 1,
            zoomType: 'xy'
        },
        title: {
            text: '',
            align: 'left'
        },
        xAxis: {
            title: {
                text: '品牌出現頻率'
            },
            gridLineWidth: 1,
            accessibility: {
                rangeDescription: 'Range: 0 to 100.'
            }
        },
        yAxis: {
            title: {
                text: '正負面'
            },
            startOnTick: false,
            endOnTick: false,
            accessibility: {
                rangeDescription: 'Range: 0 to 100.'
            }
        },
        series: seriesOptions
        
    });
</script>

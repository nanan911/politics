<div class="charts">
    <h4 class="chart_css">
    </h4>
    <p></p>
    <div id="TrendCharts"
        style=" margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>

<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="js/highcharts.js"></script>

<script>
    var seriesOptions = {!! json_encode($trend_data) !!};
    var TrendCharts = Highcharts.stockChart('TrendCharts', {
        rangeSelector: {
            selected: 4
        },
        chart: {
                backgroundColor: 'rgba(63, 63, 63, 0)',
                borderRadius: 5, // 设置边框圆角
            }, 
            
            title: {
                text: '議題趨勢圖' ,
                style: {
                    fontFamily: '微軟正黑體, Microsoft JhengHei, Arial, sans-serif',
                    fontSize:'25px',         
                    color: '#ffffff'
                    }
            },
            subtitle: {
                text: '單位:(篇)',
                align: 'left',
                style: {
                        color: '#9fa3a0'
                    }
            },
            legend: {
                enabled: true,
                itemStyle: {
                color: '#ffffff', // 更改图例文本颜色
            } 
            },
           
        xAxis: {
            type: 'datetime',
            labels: {
                style: {
                    fontSize: '16px',
                    
                }
                
            },
            dateTimeLabelFormats: {
                day: '%Y-%m-%d',
                week: '%Y-%m-%d',
                month: '%Y-%m',
                year: '%Y'
            },
            labels: {
                    style: {
                        color: '#ffffff'
                    }
                }
        },
        yAxis: [{
        title: {
            text: '文章數量',
            style: {
                color: '#ffffff'
            }
        },
        labels: {
            style: {
                color: '#ffffff'
            }
        },
        gridLineColor: '#dddddd', // 更改网格线颜色
        gridLineWidth: 0.8, // 更改网格线宽度
    }],
        navigator: {
        enabled: false // 禁用导航器
    },
        plotOptions: {
            series: {
                
                // 设置线条宽度
                marker: {
                    enabled: true, // 启用数据点标记
                    radius: 3, // 设置数据点标记半径
                    symbol: 'circle', // 设置数据点标记形状
                },
            }
        },
        exporting: {
                enabled: false  
            },
        series: seriesOptions
    });
</script>

<style>
    /* 添加图表样式 */
    .chart-container {
        height: 500px; /* 设置图表容器高度 */
        max-width: 1000px; /* 设置图表容器最大宽度 */
        margin: auto; /* 设置图表容器水平居中 */
    }
    .chart-title {
        color: #333333; /* 设置标题颜色 */
        text-align: center; /* 设置标题居中 */
        font-size: 24px; /* 设置标题字体大小 */
        margin-bottom: 20px; /* 设置标题下边距 */
    }
</style>


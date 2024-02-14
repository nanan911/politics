<div class="charts">
    <h4 class="chart_css">
        <b><i class="fa-regular fa-comments"></i>{{ $title }}</b>
    </h4>
    <p></p>
    <div id="company_rank_chart"
        style="height: 50vh; max-width: 1200px; margin: auto; display: flex; align-items: center; justify-content: center;">
    </div>
</div>
<script>
    var seriesOptions = {!! json_encode($bar_data) !!};

    var companyRankChart = Highcharts.chart('company_rank_chart', {      
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            labels: {
                style: {
                    color: '#343838',
                    textOutline: 'none',
                    fontWeight: 'bold',
                    fontSize: '20px',
                }
            },
            categories: seriesOptions[0].data.map(point => point[0])
        },
        yAxis: {
            title: '',
            labels: {
                style: {
                    color: '#343838',
                    textOutline: 'none',
                    fontWeight: 'bold',
                    fontSize: '14px',
                }
            }
        },
        legend: {
            itemStyle: {
                color: '#343838',
                fontWeight: 'bold',
                fontSize: '16px'
            },
            legendType: 'point',
        },
        tooltip: {
            style: {
                fontSize: "16px",
            },
            headerFormat: '<span style="font-weight:bold;font-size: 16px;font-family:宋体;">{point.key}</span><br/>',
            pointFormat: '<span style="font-weight:bold;color:{point.color};font-size: 16px;">\u25CF</span> {series.name}: {point.y}<br/>',
        },
        plotOptions: {
            series: {
                style: {
                    color: '#343838',
                    textOutline: 'none',
                    fontWeight: 'bold',
                    fontSize: '30px',
                },
                events: {
                    click: function(e) {
                        window.open("/artical?ChannelSelect=" + ChannelSelect + "&company_form=" + e.point
                            .category);
                        // 或使用下面的方式改變 location
                        // location.href = "/artical?ChannelSelect=" + ChannelSelect + "&company_form=" + e.point.category;
                    }
                }
            }
        },
        series: seriesOptions
    });
</script>

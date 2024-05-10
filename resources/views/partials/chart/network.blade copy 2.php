<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Network Chart</title>
    <!-- 引入 Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/networkgraph.js"></script>
</head>
<body>
    <div id="networkCharts" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script>
    Highcharts.addEvent(
    Highcharts.Series,
    'afterSetOptions',
    function (e) {

        const colors = Highcharts.getOptions().colors,
            nodes = {};

        let i = 0;

        if (
            this instanceof Highcharts.Series.types.networkgraph &&
            e.options.id === 'lang-tree'
        ) {
            e.options.data.forEach(function (link) {

                if (link[0] === 'TheoEpstein') {
                    nodes['TheoEpstein'] = {
                        id: 'TheoEpstein',
                        marker: {
                            radius: 20
                        }
                    };
                    nodes[link[1]] = {
                        id: link[1],
                        marker: {
                            radius: 10
                        },
                        color: colors[i++]
                    };
                } else if (nodes[link[0]] && nodes[link[0]].color) {
                    nodes[link[1]] = {
                        id: link[1],
                        color: nodes[link[0]].color
                    };
                }
            });

            e.options.nodes = Object.keys(nodes).map(function (id) {
                return nodes[id];
            });
        }
    }
);
        var seriesOptions = <?php echo json_encode($network_data); ?>;
        var TrendCharts = Highcharts.chart('networkCharts', {
            chart: {
                backgroundColor: 'rgba(63, 63, 63, 0)', 
                type: 'networkgraph',
            },
            title: {
                text: '意見領袖社群網路分析圖',
                align: 'center',
                style: {
                color: '#ffffff',
               
        }
            },
            subtitle: {
                text: '',
                align: 'left'
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    }
                }
            },
            series: seriesOptions
        });

  

    </script>
</body>
</html>

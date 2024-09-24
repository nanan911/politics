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
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <script>
    // Example of network data (replace with your actual data)
    const rawData = <?php echo json_encode($network_data); ?>;

    // Process the data to find the node with the maximum connections
    const nodeConnections = {};
    rawData.forEach(link => {
        if (!nodeConnections[link[0]]) nodeConnections[link[0]] = 0;
        if (!nodeConnections[link[1]]) nodeConnections[link[1]] = 0;

        nodeConnections[link[0]]++;
        nodeConnections[link[1]]++;
    });

    let maxNode = '';
    let maxConnections = 0;
    for (const [node, count] of Object.entries(nodeConnections)) {
        if (count > maxConnections) {
            maxConnections = count;
            maxNode = node;
        }
    }

    Highcharts.addEvent(
        Highcharts.Series,
        'afterSetOptions',
        function (e) {
            const colors = Highcharts.getOptions().colors;
            const nodes = {};
            let i = 0;

            if (
                this instanceof Highcharts.Series.types.networkgraph &&
                e.options.id === 'lang-tree'
            ) {
                e.options.data.forEach(function (link) {
                    if (link[0] === maxNode) {
                        nodes[maxNode] = {
                            id: maxNode,
                            marker: {
                                radius: 30
                            },
                            color: '#FF0000' // Color for the largest node
                        };
                    } else {
                        if (!nodes[link[0]]) nodes[link[0]] = { id: link[0], marker: { radius: 10 } };
                        if (!nodes[link[1]]) nodes[link[1]] = { id: link[1], marker: { radius: 10 } };

                        if (link[0] === maxNode || link[1] === maxNode) {
                            nodes[link[1]] = {
                                id: link[1],
                                color: '#FF0000'
                            };
                        } else {
                            nodes[link[1]] = {
                                id: link[1],
                                color: colors[i++ % colors.length]
                            };
                        }
                    }
                });

                e.options.nodes = Object.keys(nodes).map(function (id) {
                    return nodes[id];
                });
            }
        }
    );

    Highcharts.chart('container', {
            chart: {
                backgroundColor: 'rgba(63, 63, 63, 0)', 
                type: 'networkgraph',
                
            },
            title: {
                text: '意見領袖社群網絡分析圖',
                align: 'center',
                style: {
                fontFamily: '微軟正黑體, Microsoft JhengHei, Arial, sans-serif',
                color: '#ffffff'
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
            series: [{
            accessibility: {
                enabled: false
            },
            dataLabels: {
                enabled: true,
                linkFormat: '',
                style: {
                    fontSize: '0.6em',
                    fontWeight: 'normal',
                    textOutline: 'none' // 移除陰影
                }
            },
            id: 'lang-tree',
            data: rawData
        }]
    });
    </script>
</body>
</html>

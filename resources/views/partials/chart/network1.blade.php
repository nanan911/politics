<!DOCTYPE html>
<html>
<head>
    <title>Highcharts Network Graph Example</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/networkgraph.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
    <div id="container" style="width: 100%; height: ;"></div>
    <script>
        // Add the nodes option through an event call.
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
                        if (link[0] === 'Proto Indo-European') {
                            nodes['Proto Indo-European'] = {
                                id: 'Proto Indo-European',
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

        Highcharts.chart('container', {
            chart: {
                backgroundColor: '#3f3f3f',
                type: 'networkgraph',
            },
            title: {
                text: '社群網路圖',
                align: 'center',
                style: {
                        color: '#ffffff'
                    }
            },
            exporting: {
                enabled: false  
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    },
                    marker: {
                        radius: 20 //bubble 大小
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
                        fontSize: '14px',
                        fontWeight: 'normal'
                    }
                },
                id: 'lang-tree',
                data: [
                    ['Proto Indo-European', 'Germanic'],
                    ['Proto Indo-European', 'Italic'],
                    ['Italic', 'Latin'],
                    ['Germanic', 'English'],
                    ['Iranian', 'Balochi'],
                    ['Iranian', 'Kurdish'],
                    ['Iranian', 'Pashto'],
                    ['Iranian', 'Sogdian'],
                    ['Proto Indo-European',"Iranian"],
                    ['Proto Indo-European',"Sanskrit"],
                    ['Sanskrit', 'Sindhi'],
                    ['Sanskrit', 'Romani'],
                    ['Sanskrit', 'Urdu'],
                    ['Sanskrit', 'Hindi'],
                    ['Sanskrit', 'Bihari'],
                ]
            }]
        });
    </script>
</body>
</html>

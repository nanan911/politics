import React, { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import Networkgraph from 'highcharts/modules/networkgraph';

// 初始化 Networkgraph 模組
Networkgraph(Highcharts);

const NetworkChart = () => {
    const [networkData, setNetworkData] = useState([]);

    useEffect(() => {
        // 從 API 獲取網絡數據
        fetch('http://127.0.0.1/api/network-data')
            .then(response => response.json())
            .then(data => {
                setNetworkData(data);
            })
            .catch(error => {
                console.error('Error fetching network data:', error);
            });
    }, []);

    useEffect(() => {
        if (networkData.length === 0) return; // 如果沒有數據，則不進行圖表初始化

        // 處理數據以找出連接數最多的節點
        const nodeConnections = {};
        networkData.forEach(link => {
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
                                color: '#FF0000' // 最大節點的顏色
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
            type: 'networkgraph',
            height: '70%',
          },
          title: {
            useHTML: true,
            text: `
                <span style="color: #006696; font-weight: bold; font-size: 18px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                </svg>意見領袖社群網路分析圖</span>`,
            align: 'left',
          },
          plotOptions: {
            networkgraph: {
              keys: ['from', 'to'],
              layoutAlgorithm: {
                enableSimulation: true,
                friction: -0.9,
              },
            },
          },
            series: [{
                accessibility: {
                    enabled: false
                },
                dataLabels: {
                    enabled: true,
                    linkFormat: '',
                    style: {
                        fontSize: '0.8em',
                        fontWeight: 'normal',
                        textOutline: 'none' // 移除陰影
                    }
                },
                id: 'lang-tree',
                data: networkData
            }]
        });
    }, [networkData]);

    return (
        <div id="container" style={{ minWidth: '810px', height: '800px', margin: '0 auto' }}></div>
    );
};

export default NetworkChart;

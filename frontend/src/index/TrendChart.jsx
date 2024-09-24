import React, { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';

const TrendChart = () => {
    const [options, setOptions] = useState({});

    useEffect(() => {
        // 從 API 獲取數據
        fetch('http://127.0.0.1/api/trend-data')
            .then(response => response.json())
            .then(data => {
                console.log('Data fetched:', data); // 確認數據格式

                // 構建圖表配置
                const chartOptions = {
                    title: {
                        useHTML: true,
                        text: `
                            <span style="color: #006696; font-weight: bold; font-size: 18px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                            </svg>議題趨勢圖</span>`,
                        align: 'left',
                    },
                    xAxis: {
                        type: 'datetime',
                        labels: {
                            style: {
                                fontSize: '13px',
                                
                            }
                            
                        },
                        dateTimeLabelFormats: {
                            day: '%Y-%m-%d',
                            week: '%Y-%m-%d',
                            month: '%Y-%m',
                            year: '%Y'
                        },
                     
                    },
                    yAxis: {
                        title: {
                            text: '文本篇數',
                            style: {
                                fontSize: '13px',
                                color:'#cbccc7',
                            },
                        },
                        labels: {
                            style: {
                                fontWeight: 'bold',
                                fontSize: '13px',
                            },
                        },
                    },
                   
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false,
                            },
                            pointStart: 1, // 確保這裡的起始點與數據匹配
                        },
                    },
                    series: data,
                    responsive: {
                        rules: [
                            {
                                condition: {
                                    maxWidth: 500,
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom',
                                    },
                                },
                            },
                        ],
                    },
                };

                // 更新圖表選項
                setOptions(chartOptions);
            })
            .catch(error => console.error('Error fetching data:', error));
    }, []);

    return (
        <div className='TrendChart'>
            <HighchartsReact highcharts={Highcharts} options={options} />
        </div>
    );
};

export default TrendChart;

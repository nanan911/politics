import React, { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import HighchartsMore from 'highcharts/highcharts-more';

// Initialize HighchartsMore
HighchartsMore(Highcharts);

const BubbleChart = () => {
    const [chartData, setChartData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch('http://127.0.0.1/api/bubble-data');
                const data = await response.json();
                console.log('Data fetched:', data);
                
                // Transform data into the format required by Highcharts
                const formattedData = data.map(item => ({
                    name: item.name,
                    data: item.data,
                    color: item.color,
                    marker: {
                        fillColor: {
                            radialGradient: { cx: 0.4, cy: 0.3, r: 0.7 },
                            stops: [
                                [0, 'rgba(255,255,255,0.5)'],
                                [
                                    1,
                                    Highcharts.color(
                                        Highcharts.getOptions().colors[1]
                                    ).setOpacity(0.5).get('rgba')
                                ]
                            ]
                        }
                    }
                }));
                
                setChartData(formattedData);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        fetchData();
    }, []);

    const options = {
        chart: {
            type: 'bubble',
            plotBorderWidth: 1,
            zooming: {
                type: 'xy'
            }
        },
        title: {
            useHTML: true,
            text: `
                <span style="color: #006696; font-weight: bold; font-size: 18px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-noise-reduction" viewBox="0 0 16 16">
                <path d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1 1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m.5-.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-5 7a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1.5-1.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1-1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1-1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1-1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m1-1a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-3 5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m.5-.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m1-1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M1 8a7 7 0 0 1 12.83-3.875.5.5 0 1 0 .15.235q.197.322.359.667a.5.5 0 1 0 .359.932q.201.658.27 1.364a.5.5 0 1 0 .021.282 7 7 0 0 1-.091 1.592.5.5 0 1 0-.172.75 7 7 0 0 1-.418 1.091.5.5 0 0 0-.3.555 7 7 0 0 1-.296.454.5.5 0 0 0-.712.453c0 .111.036.214.098.297a7 7 0 0 1-.3.3.5.5 0 0 0-.75.614 7 7 0 0 1-.455.298.5.5 0 0 0-.555.3 7 7 0 0 1-1.092.417.5.5 0 1 0-.749.172 7 7 0 0 1-1.592.091.5.5 0 1 0-.282-.021 7 7 0 0 1-1.364-.27A.498.498 0 0 0 5.5 14a.5.5 0 0 0-.473.339 7 7 0 0 1-.668-.36A.5.5 0 0 0 5 13.5a.5.5 0 1 0-.875.33A7 7 0 0 1 1 8"/>
                </svg>好感定位圖</span>`,
            align: 'left'
        },
        xAxis: {
            title: {
                text: '出現頻率',

            },
            gridLineWidth: 1,
            accessibility: {
                rangeDescription: 'Range: 0 to 100.'
            },

        },
        yAxis: {
            title: {
                text: '正負面',

            },
            startOnTick: false,
            endOnTick: false,
            accessibility: {
                rangeDescription: 'Range: 0 to 100.'
            },

        }, 
        series: chartData
    };

    return (
        <div className='BubbleChart'>
            <HighchartsReact highcharts={Highcharts} options={options} />
        </div>
    );
};

export default BubbleChart;

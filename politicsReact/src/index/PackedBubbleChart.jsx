import React, { useState, useEffect } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import HighchartsMore from 'highcharts/highcharts-more';

HighchartsMore(Highcharts);

const PackedBubbleChart = () => {
    const [chartData, setChartData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await 
                fetch('http://127.0.0.1/api/packedbubble-data')
                const data = await response.json();
                setChartData(data);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        };

        fetchData();
    }, []);

    const options = {
        chart: {
            type: 'packedbubble',
            height: 550
        },
        title: {
            useHTML: true,
            text: `
                <span style="color: #006696; font-weight: bold; font-size: 24px">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-ui-radios-grid" viewBox="0 0 16 16">
                <path d="M3.5 15a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m9-9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5m0 9a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5M16 3.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-9 9a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m5.5 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-9-11a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m0 2a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                </svg>熱門詞彙圖</span>`,
            align: 'left',
            style: {
                fontSize: '20px'  // Adjust font size for the title
            }
        },
        tooltip: {
            useHTML: true,
            pointFormat: '<b>{point.name}:</b> {point.value}</sub>',
            style: {
                fontSize: '16px'  // Adjust font size for the tooltip
            }
        },
        plotOptions: {
            packedbubble: {
                minSize: '1%',
                maxSize: '180%',
                zMin: 0,
                zMax: 2000,
                layoutAlgorithm: {
                    splitSeries: false,
                    gravitationalConstant: 0.02
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    filter: {
                        property: 'y',
                        operator: '>',
                        value: 400
                    },
                    style: {
                        color: 'black',
                        textOutline: 'none',
                        fontWeight: 'bold',
                        fontSize: '14px'  // Adjust font size for data labels
                    }
                }
            }
        },
        // series: chartData
        series: [{
            name: '政治',
            data: chartData
        }]
    };

    return (
        <div className='PackedBubbleChart'>
            <HighchartsReact highcharts={Highcharts} options={options} />
        </div>
    );
};

export default PackedBubbleChart;

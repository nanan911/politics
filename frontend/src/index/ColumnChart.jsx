import React, { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import HighchartsMore from 'highcharts/highcharts-more';

// Initialize HighchartsMore
HighchartsMore(Highcharts);

const ColumnChart = () => {
    const [chartData, setChartData] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch('http://127.0.0.1/api/column-data');
                const data = await response.json();
                console.log('Data fetched:', data);
                
                // Transform data into the format required by Highcharts
                const formattedData = data.map(item => ({
                    name: item.name,
                    data: item.data,
                    color: item.color,
                    lineWidth: item.lineWidth
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
            type: 'column'
        },
        title: {
            useHTML: true,
            text: `
                <span style="color: #006696; font-weight: bold; font-size: 18px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-reception-4" viewBox="0 0 16 16">
                <path d="M0 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5zm4-3a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v11a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5z"/>
                </svg>網路聲量圖</span>`,
            align: 'left'
        },
        xAxis: {
            crosshair: true,
            categories: chartData.length ? chartData[0].data.map((point => point[0])) : [], // Dynamically set categories
            accessibility: {
                description: 'Categories'
            }
        },
        yAxis: {
            title: {
                text: '正負面'
            },
            min: -4000, // Adjust min value if needed
            max: 3000    // Adjust max value if needed
        },
        tooltip: {
            valueSuffix: ' (文章)'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: chartData // Use the fetched data for series
    };

    return (
        <div className='ColumnChart'>
            <HighchartsReact highcharts={Highcharts} options={options} />
        </div>
    );
};

export default ColumnChart;

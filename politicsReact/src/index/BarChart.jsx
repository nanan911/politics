import React, { useState, useEffect } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import HighchartsMore from 'highcharts/highcharts-more';
import axios from 'axios';

HighchartsMore(Highcharts);

const BarChart = () => {
    const [chartData, setChartData] = useState({
        categories: [],
        positive_articles: [],
        negative_articles: []
    });
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get('http://127.0.0.1/api/politician-data');
                
                // 处理数据
                const categories = response.data.categories.map(cat => cat.replace(/"/g, ''));
                const positiveArticles = response.data.positive_articles.map(val => parseInt(val, 10));
                const negativeArticles = response.data.negative_articles.map(val => parseInt(val, 10));

                setChartData({
                    categories: categories,
                    positive_articles: positiveArticles,
                    negative_articles: negativeArticles
                });
                setLoading(false);
            } catch (err) {
                setError('Failed to fetch data');
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    const options = {
        chart: {
            type: 'bar', 
            height: 550,
        },
        title: {
            useHTML: true,
            text: `
                <span style="color: #006696; font-weight: bold; font-size: 18px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-text-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
                </svg>政治人物討論圖</span>`,
            align: 'left'
        },
        xAxis: {
            categories: chartData.categories
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        legend: {
            reversed: true
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true
                }
            }
        },
        series: [
            {
                name: 'Positive Articles',
                data: chartData.positive_articles
            }, 
            {
                name: 'Negative Articles',
                data: chartData.negative_articles
            }
        ]
    };

    if (loading) return <p>Loading...</p>;
    if (error) return <p>{error}</p>;

    return (
        <div className='BarChart'>
            <HighchartsReact highcharts={Highcharts} options={options} />
        </div>
    );
};

export default BarChart;

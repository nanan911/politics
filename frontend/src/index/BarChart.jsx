import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import HighchartsMore from 'highcharts/highcharts-more';

HighchartsMore(Highcharts);

const BarChart = () => {
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
            categories: [
                'January', 'February', 'March', 'April', 'May', 'January', 'February', 'March', 'April', 'May'
            ]
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
        series: [{
            name: 'Motorcycles',
            data: [74, 27, 52, 93, 1272,74, 27, 52, 93, 1272]
        }, {
            name: 'Null-emission vehicles',
            data: [2106, 2398, 3046, 3195, 4916,2106, 2398, 3046, 3195, 4916]
        }, {
            name: 'Conventional vehicles',
            data: [12213, 12721, 15242, 16518, 25037,]
        }]
    };
    return(
    <div className='BarChart'>
        <HighchartsReact highcharts={Highcharts} options={options}/>
    </div>
    );
};

export default BarChart;
// LanguageTree.js
import React, { useEffect } from 'react';
import Highcharts from 'highcharts';
import HighchartsMore from 'highcharts/highcharts-more';
import NetworkGraph from 'highcharts/modules/networkgraph';
import HighchartsReact from 'highcharts-react-official';

// Initialize the necessary modules
HighchartsMore(Highcharts);
NetworkGraph(Highcharts);

const NetworkChart = () => {
  useEffect(() => {
    Highcharts.addEvent(Highcharts.Series, 'afterSetOptions', function (e) {
      const colors = Highcharts.getOptions().colors;
      const nodes = {};
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
                radius: 20,
              },
            };
            nodes[link[1]] = {
              id: link[1],
              marker: {
                radius: 10,
              },
              color: colors[i++],
            };
          } else if (nodes[link[0]] && nodes[link[0]].color) {
            nodes[link[1]] = {
              id: link[1],
              color: nodes[link[0]].color,
            };
          }
        });

        e.options.nodes = Object.keys(nodes).map(function (id) {
          return nodes[id];
        });
      }
    });
  }, []);

  const options = {
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
    series: [
      {
        accessibility: {
          enabled: false,
        },
        dataLabels: {
          enabled: true,
          linkFormat: '',
          style: {
            fontSize: '0.8em',
            fontWeight: 'normal',
          },
        },
        id: 'lang-tree',
        data: [
          ['Proto Indo-European', 'Balto-Slavic'],
          ['Proto Indo-European', 'Germanic'],
          ['Proto Indo-European', 'Celtic'],
          ['Proto Indo-European', 'Italic'],
          ['Proto Indo-European', 'Hellenic'],
          ['Proto Indo-European', 'Anatolian'],
          ['Proto Indo-European', 'Indo-Iranian'],
          ['Proto Indo-European', 'Tocharian'],
          ['Indo-Iranian', 'Dardic'],
          ['Indo-Iranian', 'Indic'],
          ['Indo-Iranian', 'Iranian'],
          ['Iranian', 'Old Persian'],
          ['Old Persian', 'Middle Persian'],
          ['Indic', 'Sanskrit'],
          ['Italic', 'Osco-Umbrian'],
          ['Italic', 'Latino-Faliscan'],
          ['Latino-Faliscan', 'Latin'],
          ['Celtic', 'Brythonic'],
          ['Celtic', 'Goidelic'],
          ['Germanic', 'North Germanic'],
          ['Germanic', 'West Germanic'],
          ['Germanic', 'East Germanic'],
          ['North Germanic', 'Old Norse'],
          ['North Germanic', 'Old Swedish'],
          ['North Germanic', 'Old Danish'],
          ['West Germanic', 'Old English'],
          ['West Germanic', 'Old Frisian'],
          ['West Germanic', 'Old Dutch'],
          ['West Germanic', 'Old Low German'],
          ['West Germanic', 'Old High German'],
          ['Old Norse', 'Old Icelandic'],
          ['Old Norse', 'Old Norwegian'],
          ['Old Norwegian', 'Middle Norwegian'],
          ['Old Swedish', 'Middle Swedish'],
          ['Old Danish', 'Middle Danish'],
          ['Old English', 'Middle English'],
          ['Old Dutch', 'Middle Dutch'],
          ['Old Low German', 'Middle Low German'],
          ['Old High German', 'Middle High German'],
          ['Balto-Slavic', 'Baltic'],
          ['Balto-Slavic', 'Slavic'],
          ['Slavic', 'East Slavic'],
          ['Slavic', 'West Slavic'],
          ['Slavic', 'South Slavic'],
          ['Proto Indo-European', 'Phrygian'],
          ['Proto Indo-European', 'Armenian'],
          ['Proto Indo-European', 'Albanian'],
          ['Proto Indo-European', 'Thracian'],
          ['Tocharian', 'Tocharian A'],
          ['Tocharian', 'Tocharian B'],
          ['Anatolian', 'Hittite'],
          ['Anatolian', 'Palaic'],
          ['Anatolian', 'Luwic'],
          ['Anatolian', 'Lydian'],
          ['Iranian', 'Balochi'],
          ['Iranian', 'Kurdish'],
          ['Iranian', 'Pashto'],
          ['Iranian', 'Sogdian'],
          ['Old Persian', 'Pahlavi'],
          ['Middle Persian', 'Persian'],
          ['Hellenic', 'Greek'],
          ['Dardic', 'Dard'],
          ['Sanskrit', 'Sindhi'],
          ['Sanskrit', 'Romani'],
          ['Sanskrit', 'Urdu'],
          ['Sanskrit', 'Hindi'],
          ['Sanskrit', 'Bihari'],
          ['Sanskrit', 'Assamese'],
          ['Sanskrit', 'Bengali'],
          ['Sanskrit', 'Marathi'],
          ['Sanskrit', 'Gujarati'],
          ['Sanskrit', 'Punjabi'],
          ['Sanskrit', 'Sinhalese'],
          ['Osco-Umbrian', 'Umbrian'],
          ['Osco-Umbrian', 'Oscan'],
          ['Latino-Faliscan', 'Faliscan'],
          ['Latin', 'Portugese'],
          ['Latin', 'Spanish'],
          ['Latin', 'French'],
          ['Latin', 'Romanian'],
          ['Latin', 'Italian'],
          ['Latin', 'Catalan'],
          ['Latin', 'Franco-Provençal'],
          ['Latin', 'Rhaeto-Romance'],
          ['Brythonic', 'Welsh'],
          ['Brythonic', 'Breton'],
          ['Brythonic', 'Cornish'],
          ['Brythonic', 'Cuymbric'],
          ['Goidelic', 'Modern Irish'],
          ['Goidelic', 'Scottish Gaelic'],
          ['Goidelic', 'Manx'],
          ['East Germanic', 'Gothic'],
          ['Middle Low German', 'Low German'],
          ['Middle High German', '(High) German'],
          ['Middle High German', 'Yiddish'],
          ['Middle English', 'English'],
          ['Middle Dutch', 'Hollandic'],
          ['Middle Dutch', 'Flemish'],
          ['Middle Dutch', 'Dutch'],
          ['Middle Dutch', 'Limburgish'],
          ['Middle Dutch', 'Brabantian'],
          ['Middle Dutch', 'Rhinelandic'],
          ['Old Frisian', 'Frisian'],
          ['Middle Danish', 'Danish'],
          ['Middle Swedish', 'Swedish'],
          ['Middle Norwegian', 'Norwegian'],
          ['Old Norse', 'Faroese'],
          ['Old Icelandic', 'Icelandic'],
          ['Baltic', 'Old Prussian'],
          ['Baltic', 'Lithuanian'],
          ['Baltic', 'Latvian'],
          ['West Slavic', 'Polish'],
          ['West Slavic', 'Slovak'],
          ['West Slavic', 'Czech'],
          ['West Slavic', 'Wendish'],
          ['East Slavic', 'Bulgarian'],
          ['East Slavic', 'Old Church Slavonic'],
          ['East Slavic', 'Macedonian'],
          ['East Slavic', 'Serbo-Croatian'],
          ['East Slavic', 'Slovene'],
          ['South Slavic', 'Russian'],
          ['South Slavic', 'Ukrainian'],
          ['South Slavic', 'Belarusian'],
          ['South Slavic', 'Rusyn'],
        ],
      },
    ],
  };

  return (
    <div className='NetworkChart'>
      <HighchartsReact highcharts={Highcharts} options={options} />
    </div>
  )
};

export default NetworkChart;

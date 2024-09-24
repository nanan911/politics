import './App.css';
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Layout from './Layout'; // 引入新的 Layout 組件
import BubbleChart from './index/BubbleChart';
import TrendChart from './index/TrendChart';
import ColumnChart from './index/ColumnChart';
import BarChart from './index/BarChart';
import PackedBubbleChart from './index/PackedBubbleChart';
import NetworkChart from './index/NetworkChart';
import UserRank from './index/UserRank';
import BrowsePage from './function/BrowsePage';
import AnalyzePage from './function/AnalyzePage';

function App() {
  return (
    <Router>
      <Routes>
        {/* Dashboard 页面 */}
        <Route path="/dashboard" element={
          <Layout>
            <div className='row1'>
              <TrendChart />
            </div>
            <div className='row2'>
              <BubbleChart />
              <ColumnChart />
            </div>
            <div className='row3'>
              <BarChart />
              <PackedBubbleChart />
            </div>
            <div className='row4'>
              <NetworkChart />
              <UserRank />
            </div>
          </Layout>
        } />
        
        {/* Browse 和 Analyze 页面 */}
        <Route path="/browse" element={
          <Layout>
            <BrowsePage />
          </Layout>
        } />
        
        <Route path="/analyze" element={
          <Layout>
            <AnalyzePage />
          </Layout>
        } />
      </Routes>
    </Router>
  );
}

export default App;

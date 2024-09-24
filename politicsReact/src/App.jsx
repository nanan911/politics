import './App.css';
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import NavBar from './index/NavBar';
import BubbleChart from './index/BubbleChart';
import TrendChart from './index/TrendChart';
import ColumnChart from './index/ColumnChart';
import BarChart from './index/BarChart';
import PackedBubbleChart from './index/PackedBubbleChart';
import NetworkChart from './index/NetworkChart';
import UserRank from './index/UserRank';
import BrowsePage from './function/BrowsePage';
import AnalyzePage from './function/AnalyzePage';
import ArticleDetailPage from './function/ArticleDetailPage'; // 导入你的文章详情页面组件

function App() {
  return (
    <Router>
      <div>
        {/* NavBar is always on top */}
        <NavBar />
        <Routes>
          <Route path="/dashboard" element={
            <>
              <div className='row1'>
                <TrendChart/>
              </div>
              <div className='row2'>
                <BubbleChart />
                <ColumnChart/>
              </div>
              <div className='row3'>
                <BarChart/>
                <PackedBubbleChart/>
              </div>
              <div className='row4'>
                <NetworkChart/>
                <UserRank/>
              </div>
            </>
          }/>
          <Route path="/browse" element={<BrowsePage />} />
          <Route path="/analyze" element={<AnalyzePage />} />
          <Route path="/article/:id" element={<ArticleDetailPage />} /> {/* 添加这条路由 */}

        </Routes>
      </div>
    </Router>
  );
}

export default App;

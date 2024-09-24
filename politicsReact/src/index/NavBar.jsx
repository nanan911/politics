import React from 'react';
import { Link } from 'react-router-dom'; // 导入 Link
import SearchButton from './SearchButton';

function NavBar() {
  return (
    <div className="nb">
      <div className="search">
        <SearchButton/>
      </div>
      <div className="logo">
        <img src='logo.png' width={'300px'} alt="Logo"/>
      </div>
      <div className="menu">
        <Link className="item" to="/dashboard">首頁</Link>
        <Link className="item" to="/analyze">文章分析</Link> {/* 添加到 AnalyzePage 的链接 */}
        <Link className="item" to="/browse">文章瀏覽</Link> {/* 确保链接路径正确 */}
        <Link className="item" to="#">設定</Link>
      </div>
    </div>
  );
}

export default NavBar;

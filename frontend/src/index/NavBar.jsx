import React from 'react';
import { Link } from 'react-router-dom';
import SearchButton from './SearchButton';

function NavBar() {
  return (
    <div className="navbar">
      <div className="search">
        <SearchButton />
      </div>
      <div className="logo">
        <img src='logo.png' width={'300px'} alt="Logo"/>
      </div>
      <div className="menu">
        <Link className="menu-item" to="/">首頁</Link>
        <Link className="menu-item" to="/analyze">文章分析</Link>
        <Link className="menu-item" to="/browse">文章瀏覽</Link>
        <Link className="menu-item" to="#">設定</Link>
      </div>
    </div>
  );
}

export default NavBar;

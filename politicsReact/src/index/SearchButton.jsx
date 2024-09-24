import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min'; // Ensure you have Bootstrap's JavaScript included

const SearchButton = () => {
  return (
    <>
      <button
        className="btn btn-primary"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasExample"
        aria-controls="offcanvasExample"
        style={{ backgroundColor: '#007da5', borderColor: '#007da5', color: '#e8c350', fontWeight: 'bold', fontSize: '20px' }}
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" className="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
        </svg>&nbsp;搜尋
      </button>

      <div className="offcanvas offcanvas-start" tabIndex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div className="offcanvas-header">
          <div className="offcanvas-title" id="offcanvasExampleLabel" style={{ display: 'flex' }}>
            <img src='logo2.png' width='70px' alt='Logo'/>
            <h3 style={{ margin: '30px 10px', fontWeight: 'bold' }}>篩選條件</h3>
          </div>
          <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div className="offcanvas-body">
          <div className="form-group" style={{ marginBottom: '20px' }}>
            <input type="text" className="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="關鍵字搜尋"/>
          </div>
          <div className='Type' style={{ marginBottom: '20px' }}>
            <label>選擇板塊</label>
            <select className="form-select" aria-label="Default select example" defaultValue="all">
              <option value="all">全部</option>
              <option value="1">政治</option>
              <option value="2">時事</option>
            </select>
          </div>
          <div className='Source' style={{ marginBottom: '20px' }}>
            <label>選擇來源</label>
            <select className="form-select" aria-label="Default select example" defaultValue="all">
              <option value="all">全部</option>
              <option value="1">PTT</option>
              <option value="2">Instagram</option>
              <option value="3">Facebook</option>
              <option value="4">News</option>
            </select>
          </div>
          <div className='Topic'>
            <label>選擇政黨</label><br/>
            <div className="form-check">
              <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault1" style={{ marginTop: '10px' }}/>
              <label className="form-check-label" htmlFor="flexCheckDefault1">
                民進黨
              </label>
            </div>
            <div className="form-check">
              <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault2" style={{ marginTop: '10px' }}/>
              <label className="form-check-label" htmlFor="flexCheckDefault2">
                民眾黨
              </label>
            </div>
            <div className="form-check">
              <input className="form-check-input" type="checkbox" value="" id="flexCheckDefault3" style={{ marginTop: '10px' }}/>
              <label className="form-check-label" htmlFor="flexCheckDefault3">
                國民黨
              </label>
            </div>
          </div>
          <div className="form-group" style={{ marginTop: '20px' }}>
            <label>開始時間</label>
            <input type="date" className="form-control" id="startDate" aria-describedby="emailHelp"/>
            <label style={{ marginTop: '10px' }}>結束時間</label>
            <input type="date" className="form-control" id="endDate" aria-describedby="emailHelp"/>
          </div>
          <button type="button" className="btn btn-primary" style={{ marginTop: '20px' }}>確認</button>
        </div>
      </div>
    </>
  );
};

export default SearchButton;

import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import './function.css';

function BrowsePage() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    fetch('http://127.0.0.1/api/articles', {
      headers: {
        'Accept': 'application/json',
      },
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        setData(data.data); // 确保获取的数据结构正确
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        setError(error);
        setLoading(false);
      });
  }, []);

  const handleArticleClick = (article) => {
    navigate(`/article/${article.id}`); // 跳转到详细信息页面
  };

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>Error: {error.message}</div>;
  }

  return (
    <div className='browse'>
      <table className="table table-striped">
        <thead>
          <tr>
            <th scope="col">文章編號</th>
            <th scope="col">標題</th>
            <th scope="col">來源</th>
            <th scope="col">作者</th>
            <th scope="col">時間</th>
            <th scope="col">内容</th>
          </tr>
        </thead>
        <tbody>
          {data.length > 0 ? (
            data.map((row) => (
              <tr key={row.id} onClick={() => handleArticleClick(row)}>
                <th scope="row">{row.id}</th>
                <td>{row.title}</td>
                <td>{row.source ? row.source.name : '未知'}</td>
                <td>{row.author ? row.author : '未知'}</td>
                <td>{row.date}</td>
                <td>{row.content.substring(0, 100) + '...'}</td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="6">No data available</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default BrowsePage;

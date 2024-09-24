import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom'; // Import Link component
import './function.css';

function AnalyzePage() {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

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
        console.log('Fetched data:', data); // Debug output
        setData(data.data); // Update state with fetched data
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        setError(error);
        setLoading(false);
      });
  }, []);

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
            <th scope="col">內容</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {data.length > 0 ? (
            data.map((row, index) => (
              <tr key={index}>
                <th scope="row">{row.id}</th>
                <td>{row.title}</td>
                <td>{row.source ? row.source.name : 'Unknown'}</td>
                <td>{row.author ? row.author.name : 'Unknown'}</td>
                <td>{row.date}</td>
                <td>{row.content.substring(0, 100) + '...'}</td>
                <td>
                  <Link to={`/article/${row.id}`}>瀏覽</Link>
                </td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="7">No data available</td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
}

export default AnalyzePage;

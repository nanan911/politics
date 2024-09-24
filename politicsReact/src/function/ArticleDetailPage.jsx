import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import './ArticleDetailPage.css'; // 引入样式文件

function ArticleDetailPage() {
  const { id } = useParams();
  const [article, setArticle] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetch(`http://127.0.0.1/api/articles/${id}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        setArticle(data.article);
        setLoading(false);
      })
      .catch(error => {
        console.error('Error fetching article:', error);
        setError(error);
        setLoading(false);
      });
  }, [id]);

  if (loading) {
    return <div className="loading">Loading...</div>;
  }

  if (error) {
    return <div className="error">Error: {error.message}</div>;
  }

  return (
    <div className="article-detail">
      <h1 className="article-title">{article.title}</h1>
      <div className="article-meta">
        <p><strong>作者:</strong> {article.author}</p>
        <p><strong>來源:</strong> {article.source.name}</p>
        <p><strong>時間:</strong> {article.date}</p>
      </div>
      <div className="article-content">
        <p>{article.content}</p>
      </div>
      <h2 className="comments-title">評論</h2>
      {article.comments.length > 0 ? (
        <ul className="comments-list">
          {article.comments.map(comment => (
            <li key={comment.id} className="comment-item">
              <strong>{comment.state} {comment.author_id}:</strong> {comment.comment}
            </li>
          ))}
        </ul>
      ) : (
        <p className="no-comments">暫無評論</p>
      )}
    </div>
  );
  
}

export default ArticleDetailPage;

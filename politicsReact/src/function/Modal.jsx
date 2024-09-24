// Modal.jsx
import React from 'react';
import './Modal.css';

const Modal = ({ isOpen, onClose, article, comments }) => {
  if (!isOpen) return null;

  return (
    <div className="modal-overlay">
      <div className="modal-content">
        <button className="modal-close" onClick={onClose}>×</button>
        <h2>{article.title}</h2>
        <p><strong>來源:</strong> {article.source ? article.source.name : '未知'}</p>
        <p><strong>作者:</strong> {article.author ? article.author.name : '未知'}</p>
        <p><strong>時間:</strong> {article.date}</p>
        <p><strong>内容:</strong> {article.content}</p>

        <h3>評論</h3>
        {comments.length > 0 ? (
          <ul>
            {comments.map((comment, index) => (
              <li key={index}>
                <p><strong>{comment.author}:</strong> {comment.content}</p>
              </li>
            ))}
          </ul>
        ) : (
          <div>暫無評論</div>
        )}
        
        <button onClick={onClose}>關閉</button>
      </div>
    </div>
  );
};

export default Modal;

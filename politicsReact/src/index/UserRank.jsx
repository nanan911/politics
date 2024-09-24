import React, { useState, useEffect } from 'react';
import { Modal, Button } from 'react-bootstrap';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

const UserRank = () => {
  const [show, setShow] = useState(false);
  const [authorId, setAuthorId] = useState(null);
  const [authorName, setAuthorName] = useState('');
  const [comments, setComments] = useState('暫無評論');
  const [userData, setUserData] = useState([]);

  const fetchComments = (id) => {
    fetch(`http://127.0.0.1/api/comments/${id}`)
      .then(response => {
        console.log('Response status:', response.status); // 打印响应状态
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log('Fetched data:', data); // 打印获取到的数据
        if (data.length > 0) {
          setComments(data.map(comment => (
            <p key={comment.id}>{comment.comment}</p>
          )));
        } else {
          setComments("沒有留言可用");
        }
      })
      .catch(error => {
        console.error("獲取留言時發生錯誤:", error);
        setComments("無法獲取留言");
      });
  };

  const fetchUserData = async () => {
    try {
      const response = await axios.get('http://127.0.0.1/api/ranking-data');
      console.log("Fetched user data:", response.data); // 打印获取的数据
      setUserData(response.data);
    } catch (error) {
      console.error("Error fetching ranking data:", error);
    }
  };

  useEffect(() => {
    fetchUserData();
  }, []);

  const handleShow = (id, name) => {
    console.log("Handling show for ID:", id);
    if (!id) {
      console.error("Invalid author ID:", id);
      return;
    }

    setAuthorId(id);
    setAuthorName(name);
    fetchComments(id);
    setShow(true);
  };

  const handleClose = () => {
    setShow(false);
    setComments('暫無評論');
  };

  return (
    <>
      <table className="table table-striped">
        <thead>
          <tr>
            <th>預警排名</th>
            <th>使用者帳號</th>
            <th>互動次數</th>
            <th>最新的留言紀錄</th>
            <th>平台</th>
          </tr>
        </thead>
        <tbody>
          {userData.length > 0 ? (
            userData.map((user, index) => (
              <tr key={user.author_id} onClick={() => handleShow(user.author_id, user.author_name)}>
                <td>{index + 1}</td>
                <td>{user.author_name}</td>
                <td>{user.interaction_count}</td>
                <td>{user.latest_comment_date}</td>
                <td>{user.platform}</td>
              </tr>
            ))
          ) : (
            <tr>
              <td colSpan="5">載入中...</td>
            </tr>
          )}
        </tbody>
      </table>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>{authorName} 的評論</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {comments || "暫無評論"}
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            關閉
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  );
};

export default UserRank;

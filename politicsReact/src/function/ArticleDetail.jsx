import React from 'react';
import PropTypes from 'prop-types';

const ArticleDetail = ({ article, comments }) => {
    return (
        <div className="container mt-4">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">
                            {article.title}
                        </div>

                        <div className="card-body">
                            <p className="mb-1"><strong>來源：</strong> {article.source ? article.source.name : '未知'}</p>
                            <p className="mb-1"><strong>作者：</strong> {article.author ? article.author.name : '未知'}</p>
                            <p className="mb-1"><strong>時間：</strong> {article.date}</p>
                            <hr />
                            <p>{article.content}</p>

                            <h3>評論</h3>
                            {comments.length === 0 ? (
                                <p>暫無評論</p>
                            ) : (
                                <table className="article-table">
                                    <thead>
                                        <tr>
                                            <th>評論 ID</th>
                                            <th>作者姓名</th>
                                            <th>狀態</th>
                                            <th>評論內容</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {comments.map(comment => (
                                            <tr key={comment.id}>
                                                <td>{comment.id}</td>
                                                <td>{comment.author ? comment.author.name : '未知'}</td>
                                                <td>{comment.state}</td>
                                                <td>{comment.comment}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

ArticleDetail.propTypes = {
    article: PropTypes.shape({
        title: PropTypes.string.isRequired,
        source: PropTypes.shape({
            name: PropTypes.string
        }),
        author: PropTypes.shape({
            name: PropTypes.string
        }),
        date: PropTypes.string.isRequired,
        content: PropTypes.string.isRequired
    }).isRequired,
    comments: PropTypes.arrayOf(PropTypes.shape({
        id: PropTypes.number.isRequired,
        author: PropTypes.shape({
            name: PropTypes.string
        }),
        state: PropTypes.string,
        comment: PropTypes.string
    })).isRequired
};

export default ArticleDetail;

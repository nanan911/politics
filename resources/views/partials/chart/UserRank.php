<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>意見領袖排行榜</title>
    <style>
        /* 基本模態窗口樣式 */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            color: black;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        tr:hover {
            background-color: #f1f1f1;
            color: black;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th scope="col">預警排名</th>
                <th scope="col">使用者帳號</th>
                <th scope="col">互動次數</th>
                <th scope="col">最新的留言紀錄</th>
                <th scope="col">平台</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
    <?php $rank = 1; ?>
    <?php foreach ($ranking_data as $data): ?>
        <tr onclick="displayUserComments('<?php echo htmlspecialchars($data['author_id']); ?>', '<?php echo htmlspecialchars($data['author_name']); ?>')">
            <th scope="row"><?php echo $rank++; ?></th>
            <td><?php echo htmlspecialchars($data['author_name']); ?></td>
            <td><?php echo $data['interaction_count']; ?></td>
            <td><?php echo htmlspecialchars($data['latest_comment_date']); ?></td>
            <td><?php echo htmlspecialchars($data['platform']); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <!-- 模態窗口 -->
    <div id="commentsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCommentsModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <div id="userComments"></div>
        </div>
    </div>

    <script>
function displayUserComments(authorId, authorName) {
    const commentsModal = document.getElementById('commentsModal');
    const modalTitle = document.getElementById('modalTitle');
    const userComments = document.getElementById('userComments');

    // 確保這裡是正確的
    modalTitle.textContent = `${authorName}的評論`;

    // 發送 AJAX 請求以獲取留言
    fetch(`http://127.0.0.1/api/comments/${authorId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            userComments.innerHTML = data.length > 0
                ? data.map(comment => `<p>${comment.comment}</p>`).join('')
                : '<p>沒有留言可用</p>';
        })
        .catch(error => {
            console.error('獲取留言時發生錯誤:', error);
            userComments.innerHTML = '<p>無法獲取留言</p>';
        });

    commentsModal.style.display = 'block';
}


        function closeCommentsModal() {
            const commentsModal = document.getElementById('commentsModal');
            commentsModal.style.display = 'none';
        }
    </script>
</body>
</html>

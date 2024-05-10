<style>
    .container {
        display: flex;
        flex-direction: column; /* 將容器改為垂直排列 */
        align-items: center; /* 垂直居中 */
    }

    .row {
        width: 100%; /* 填滿父容器寬度 */
        display: flex;
        justify-content: center;
        align-items: center; /* 水平居中 */
       
    }

    .col-md-6 {
        width: 100%; /* 佔滿父容器寬度 */
        max-width: 600px; /* 限制最大寬度，避免過寬 */
    }

    /* 左側容器樣式 */
    .left-container {
        border-radius: 1px;
       
    }

    /* 右側容器樣式 */
    .right-container {
        border-radius: 1px;
       
    }

    /* 表格容器樣式 */
    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }

    /* 表格樣式 */
    table {
        font-family: Arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd; /* 加入底部邊框 */
    }

    th {
        background-color: #f5f5f5;
        font-weight: bold;
        color: #333; /* 調整表頭文字顏色 */
    }

    tr:hover {
        background-color: #f9f9f9;
    }

    /* Modal樣式 */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background-color: #fefefe;
        padding: 20px;
        border: 1px solid #888;
        width: 60%;
        max-height: 400px;
        overflow-y: auto;
        border-radius: 10px;
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
</style>
<div class="container">
    <!-- 上方放置 Highcharts 網路圖 -->
    <div class="row">
        <div class="col-md-6 left-container">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </div>

    <!-- 下方放置表格 -->
    <div class="row">
        <div class="col-md-6 right-container">
            <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>排行榜</th>
                                <th>名稱</th>
                                <th>文章篇數</th>
                                <th>正面</th>
                                <th>負面</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            <!-- JavaScript 會在這裡動態生成表格行 -->
                        </tbody>
                    </table>
                    <div id="commentsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeCommentsModal()">&times;</span>
            <h2>文章回覆</h2>
            <h4>[新聞] 質疑蕭美琴仍有美國籍　美國律師、前立委</h4>
            <p id="userComment">點擊排行榜上的用戶以查看留言。</p>
        </div>
    </div>

    <script>
        // Sample data for rankings (top 20)
        const rankings = [
            { id: 1, username: 'win8719', total_comments: 6901, likes: 764, dislikes: 1 },
        { id: 2, username: 'rronbang', total_comments: 6351, likes: 1120, dislikes: 28 },
        { id: 3, username: 'lolahjy', total_comments: 6342, likes: 224, dislikes: 5 },
        { id: 4, username: 'jganet', total_comments: 6099, likes: 1611, dislikes: 0 },
        { id: 5, username: 'remora', total_comments: 6005, likes: 1325, dislikes: 20 },
        { id: 6, username: 'Homura', total_comments: 5817, likes: 2, dislikes: 2 },
        { id: 7, username: 'crystal0100', total_comments: 5394, likes: 1481, dislikes: 11 },
        { id: 8, username: 'a10141013', total_comments: 5215, likes: 1376, dislikes: 3 },
        { id: 9, username: 'cycling', total_comments: 5082, likes: 1330, dislikes: 103 },
        { id: 10, username: 'hydra3179', total_comments: 4923, likes: 1902, dislikes: 160 },
        { id: 11, username: 'PunkGrass', total_comments: 4707, likes: 1316, dislikes: 205 },
        { id: 12, username: 'cake10414', total_comments: 4530, likes: 1248, dislikes: 55 },
        { id: 13, username: 'Ptalrasha', total_comments: 4410, likes: 2047, dislikes: 23 },
        { id: 14, username: 'cake10414', total_comments: 3978, likes: 356, dislikes: 0 },
        { id: 15, username: 'kaede0711', total_comments: 3951, likes: 765, dislikes: 1 },
        { id: 16, username: 'malisse74', total_comments: 3788, likes: 1588, dislikes: 108 },
        { id: 17, username: 'langeo', total_comments: 3690, likes: 1074, dislikes: 0 },
        { id: 18, username: 'amare1015', total_comments: 3503, likes: 1096, dislikes: 1 },
        { id: 19, username: 'piliwu', total_comments: 3369, likes: 1183, dislikes: 69 },
        { id: 20, username: 's81048112', total_comments: 3354, likes: 809, dislikes: 8 }
        ];
    
        // Sample data for comments
        const comments = {
            'win8719': [
        '推: 他有美國政府公告可信嗎?',
        '→: 還有八卦都說了snn不一定要美國移民才有',
        '→: 還有八卦說了駐美期間~蕭一樣要報稅',
        '→: 就這樣~先去把美國政府公告給他翻了吧',
        '噓: 他喔林獻堂. 民進黨中評會決議開除邱彰黨籍',
        '→: 簡稱 林文郎遞補不分區立委. 東森新聞報.',
        '→: 2002-04-01.',
        '→: 剛好蕭美琴當選的那年~所以蕭美琴啥狀況',
        '→: 應該很清楚',
        '→: 然後我不知道美國查人有沒有報稅好不好查',
        '→: 但是台灣很難查個人',
        '→: 他被開除黨籍的阿',
        '→: 我比較懷疑他不看美國政府公告~用一些不',
        '→: 能證明的萊懷疑~是來讓人上車的',
        '→: 你們想搞出另一個彭文正~就上車吧'
    ],
            'User2': ['Comment 1 from User2', 'Comment 2 from User2', /* Add more comments for User2 */],
            // Add more comments data
            'User3': ['Comment 1 from User3', 'Comment 2 from User3', /* Add more comments for User3 */],
            'User4': ['Comment 1 from User4', 'Comment 2 from User4', /* Add more comments for User4 */],
            'User5': ['Comment 1 from User5', 'Comment 2 from User5', /* Add more comments for User5 */],
            'User6': ['Comment 1 from User6', 'Comment 2 from User6', /* Add more comments for User6 */],
            'User7': ['Comment 1 from User7', 'Comment 2 from User7', /* Add more comments for User7 */],
            'User8': ['Comment 1 from User8', 'Comment 2 from User8', /* Add more comments for User8 */],
            'User9': ['Comment 1 from User9', 'Comment 2 from User9', /* Add more comments for User9 */],
            'User10': ['Comment 1 from User10', 'Comment 2 from User10', /* Add more comments for User10 */],
            'User11': ['Comment 1 from User11', 'Comment 2 from User11', /* Add more comments for User11 */],
            'User12': ['Comment 1 from User12', 'Comment 2 from User12', /* Add more comments for User12 */],
            'User13': ['Comment 1 from User13', 'Comment 2 from User13', /* Add more comments for User13 */],
            'User14': ['Comment 1 from User14', 'Comment 2 from User14', /* Add more comments for User14 */],
            'User15': ['Comment 1 from User15', 'Comment 2 from User15', /* Add more comments for User15 */],
            'User16': ['Comment 1 from User16', 'Comment 2 from User16', /* Add more comments for User16 */],
            'User17': ['Comment 1 from User17', 'Comment 2 from User17', /* Add more comments for User17 */],
            'User18': ['Comment 1 from User18', 'Comment 2 from User18', /* Add more comments for User18 */],
            'User19': ['Comment 1 from User19', 'Comment 2 from User19', /* Add more comments for User19 */],
            'User20': ['Comment 1 from User20', 'Comment 2 from User20', /* Add more comments for User20 */],
        };
    
        // Function to display table rows
        function displayTable() {
            const tableBody = document.getElementById('tableBody');
    
            rankings.forEach(user => {
                const row = document.createElement('tr');
            const rankCell = document.createElement('td');
            const nameCell = document.createElement('td');
            const totalCommentsCell = document.createElement('td');
            const likesCell = document.createElement('td');
            const dislikesCell = document.createElement('td');

                rankCell.textContent = user.id;
                    nameCell.textContent = user.username;
            totalCommentsCell.textContent = user.total_comments;
            likesCell.textContent = user.likes;
            dislikesCell.textContent = user.dislikes;
    
            row.appendChild(rankCell);
            row.appendChild(nameCell);
            row.appendChild(totalCommentsCell);
            row.appendChild(likesCell);
            row.appendChild(dislikesCell);
    
                // Add a click event listener to each row to display the comments modal
                row.addEventListener('click', () => displayUserComments(user.username));
    
                tableBody.appendChild(row);
            });
        }
    
        // Function to display user comments
        function displayUserComments(username) {
            const commentsModal = document.getElementById('commentsModal');
            const userCommentElement = document.getElementById('userComment');
            const userComments = comments[username] || ['No comments available'];
    
            // Generate HTML for all user comments
            const commentsHTML = userComments.map(comment => `<p>${comment}</p>`).join('');
    
            // Set the comments in the modal
            userCommentElement.innerHTML = `留言 from ${username}: ${commentsHTML}`;
    
            // Display the modal
            commentsModal.style.display = 'block';
        }
    
        // Function to close the comments modal
        function closeCommentsModal() {
            const commentsModal = document.getElementById('commentsModal');
            commentsModal.style.display = 'none';
        }
    
        // Call the displayTable function to initialize the table display
        displayTable();
    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Highcharts scripts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/networkgraph.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Include your custom styles for Highcharts -->
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 800px;
            
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;

            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }



        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>

    <!-- Include your custom script for Highcharts -->
    <script>
        Highcharts.addEvent(
            Highcharts.Series,
            'afterSetOptions',
            function (e) {
                const colors = Highcharts.getOptions().colors,
                    nodes = {};
                let i = 0;

                if (
                    this instanceof Highcharts.Series.types.networkgraph &&
                    e.options.id === 'lang-tree'
                ) {
                    e.options.data.forEach(function (link) {
                        if (link[0] === 'win8719') {
                            nodes['win8719'] = {
                                id: 'win8719',
                                marker: {
                                    radius: 30
                                }
                            };
                            nodes[link[1]] = {
                                id: link[1],
                                marker: {
                                    radius: 20
                                },
                                color: colors[i++]
                            };
                        } else if (nodes[link[0]] && nodes[link[0]].color) {
                            nodes[link[1]] = {
                                id: link[1],
                                color: nodes[link[0]].color
                            };
                        }
                    });

                    e.options.nodes = Object.keys(nodes).map(function (id) {
                        return nodes[id];
                    });
                }
            }
        );

        Highcharts.chart('container', {
            chart: {
                backgroundColor: '#3f3f3f',
                type: 'networkgraph',
                height: 410,
            },
            title: {
                text: '社群網路圖',
                align: 'center',
                style: {
                        color: '#ffffff'
                    }
            },
            exporting: {
                enabled: false  
            },
            plotOptions: {
                networkgraph: {
                    keys: ['from', 'to'],
                    layoutAlgorithm: {
                        enableSimulation: true,
                        friction: -0.9
                    },
                    marker: {
                        radius: 20 //bubble 大小
                    }
                }
            },
            series: [{
                accessibility: {
                    enabled: false
                },
                dataLabels: {
                    enabled: true,
                    linkFormat: '',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'normal'
                    }
                },
                id: 'lang-tree',
                data: [
                    ['win8719', 'rronbang'],
['win8719', 'remora'],
['win8719', 'jganet'],
['win8719', 'Homura'],
['win8719', 'crystal0100'],
['win8719', 'a10141013'],
['win8719', 'lolahjy'],
['win8719', 'cycling'],
['win8719', 'hydra3179'],
['rronbang', 'PunkGrass'],
['rronbang', 'cake10414'],
['rronbang', 'talrasha'],
['rronbang', 'rogudan'],
['remora', 'yichen1234'],
['remora', 'laSnake'],
['remora', 'panjanhon'],
['remora', 'rockocean'],
['remora', 'Movice'],
['remora', 'hoberg'],
['remora', 'talrasha'],
['jganet', 'jacklyl'],
['jganet', 'banmi'],
['jganet', 'zucca'],
['jganet', 'talrasha'],
['jganet', 'HideoNomo'],
['jganet', 'l861128'],
['jganet', 'sakula0616'],
['jganet', 'Movice'],
['Homura', 'talrasha'],
['Homura', 'nnkj'],
['Homura', 'cutbear123'],
['Homura', 'bread220'],
['Homura', 'geordie'],
['Homura', 'busman214'],
['Homura', 'Iamfeng'],
['Homura', 'd22426539'],
['Homura', 'greedypeople'],
['Homura', 'laSnake'],
['crystal0100', 'talrasha'],
['crystal0100', 'zingy'],
['crystal0100', 'sean0126'],
['crystal0100', 'Emper'],
['crystal0100', 'CavendishJr'],
['crystal0100', 'hyscout'],
['crystal0100', 'jorden'],
['crystal0100', 'qaz630210'],
['crystal0100', 'a10141013'],
['crystal0100', 'langeo'],
['crystal0100', 's13140709'],
['crystal0100', 'dicky503'],
['crystal0100', 'boxcar'],
['a10141013', 'a10141013'],
['a10141013', 'neverfly'],
['a10141013', 'wawaking1'],
['a10141013', 'crooked'],
['a10141013', 'JoeyChen'],
['a10141013', 'sd09090'],
['a10141013', 'orinsinal'],
['a10141013', 'Mazda6680'],
['lolahjy', 'Roderickey'],
['lolahjy', 'cutbear123'],
['lolahjy', 'dragon0'],
['lolahjy', 'AtDe'],
['lolahjy', 'gogobar'],
['lolahjy', 'angellll'],
['angellll', 'DDDDRR'],
['angellll', 's6031417'],
['angellll', 'ramirez'],
['angellll', 'INNBUG'],
['lolahjy', 'vincent0523'],
['lolahjy', 'spartaucs896'],
['lolahjy', 'tellmetruth'],
['hydra3179', 'StrKO'],
['hydra3179', 'thbygn98'],
['hydra3179', 'arceus'],
['cycling', 'hank81177'],
['cycling', 'holyhelm'],
['cycling', 'chunyun'],
['cycling', 'zxzzzzzzzzzz'],
['cycling', 'totenkopf001'],
['cycling', 'kterry01'],



                ]
            }]
        });
    </script>


    <script>

    </script>

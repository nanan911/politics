<style>
    /* 自定义表格样式 */
    .article-table {
        
        width: 100%; /* 表格宽度 */
        border-collapse: collapse; /* 合并表格边框 */
        border: 1px solid #ccc; /* 设置表格边框 */
        
        height: 700px; /* 设置表格的高度 */
    }

    .article-table th,
    .article-table td {
        padding: 8px; /* 单元格内边距 */
        border: 1px solid #ccc; /* 设置单元格边框 */
    }

    .article-table th {
        background-color: #808080; /* 表头背景颜色 */
        color: #fff; /* 表头文字颜色 */
        font-weight: bold; /* 表头文字加粗 */
    }

    .article-table tr:nth-child(even) {
        background-color: #f2f2f2; /* 偶数行背景颜色 */
    }

    .article-table tr:hover {
        background-color: #ddd; /* 悬停时背景颜色 */
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="article-table">
                <thead>
                    <tr>
                        <th>文章標題</th>
                        <th>來源</th>
                        <th>日期</th>
                        <th>情绪</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($articles as $article)
                        <tr>
                            <td>
                                <a href="{{ route('article.show', $article->id) }}"
                                    style="text-decoration: none; color: inherit; font-weight: bold;">
                                    {{ $article->title }}
                                </a>
                            </td>
                            <td>{{ $article->source->class }}</td>
                            <td>{{ $article->date }}</td>
                            <td style="color: {{ $article->sentiment === 'Positive' ? 'green' : ($article->sentiment === 'Negative' ? 'red' : 'gray') }}">
                                {{ $article->sentiment === 'Positive' ? 'Positive' : ($article->sentiment === 'Negative' ? 'Negative' : 'Negative') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">目前沒有任何文章。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="d-flex justify-content-center mt-3">
        {{ $articles->links('pagination::bootstrap-4') }}
    </div>
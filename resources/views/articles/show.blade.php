@extends('layouts.app')

<style>
    .card-header {
        background-color: #343a40; /* 深灰色背景 */
        color: #fff; /* 白色字体 */
        font-weight: bold; /* 粗体字 */
    }

    .article-table {
        width: 100%;
        border-collapse: collapse;
        height: 700px;
    }

    .article-table th,
    .article-table td {
        padding: 8px;
        color: #000; /* 黑色字体 */
    }

    .article-table th {
        background-color: #808080;
        font-weight: bold;
    }

    .article-table tr:hover {
        background-color: #ddd;
    }

    .comment {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        color: #000; /* 黑色字体 */
    }

    .comment-actions a {
        color: #007bff; /* 链接颜色 */
        text-decoration: none;
    }

    .comment-actions a:hover {
        text-decoration: underline;
    }
</style>

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $article->title }}</div>

                    <div class="card-body">
                        <p class="mb-1"><strong>來源：</strong> {{ $article->source ? $article->source->name : '未知' }}</p>
                        <p class="mb-1"><strong>作者：</strong> {{ $article->author}}</p>
                        <p class="mb-1"><strong>時間：</strong> {{ $article->date }}</p>
                        <hr>
                        <p>{{ $article->content }}</p>

                        <h3>評論</h3>
                        @if($comments->isEmpty())
                            <p>暫無評論</p>
                        @else
                            <table class="article-table">

                                <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td>{{ $comment->id }}</td>
                                            <td>{{ $comment->author ?? '未知' }}</td>
                                            <td>{{ $comment->state }}</td>
                                            <td>{{ $comment->comment }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

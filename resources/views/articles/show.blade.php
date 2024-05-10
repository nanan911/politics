@extends('layouts.app')
<style>
    .card-header {
        background-color: #343a40; /* Dark gray background color */
        color: #fff; /* White text color */
        font-weight: bold; /* Bold text */
    }

    /* Your existing table styles */
    .article-table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ccc;
        height: 700px;
    }

    .article-table th,
    .article-table td {
        padding: 8px;
        border: 1px solid #ccc;
    }

    .article-table th {
        background-color: #808080;
        color: #fff;
        font-weight: bold;
    }

    .article-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .article-table tr:hover {
        background-color: #ddd;
    }
</style>

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $article->title }}</div>

                    <div class="card-body">
                        <p class="mb-1"><strong>來源：</strong> {{ $article->source->class }}</p>
                        <p class="mb-1"><strong>日期：</strong> {{ $article->date }}</p>
                        <hr>
                        <p>{{ $article->content }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

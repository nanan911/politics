@extends('layouts.app')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
</head>
<body>
    <h1>Edit Article</h1>

    @if($article)
        <form action="{{ url('/save_article') }}" method="post">
            @csrf
            <input type="hidden" name="url" value="{{ $article->address }}">

            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="{{ $article->title }}" required><br>

            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="10" cols="50" required>{{ $article->content }}</textarea><br>

            <button type="submit">Save Changes</button>
        </form>

        <a href="{{ url('/results') }}">Back to Results</a>
    @else
        <p>Article not found.</p>
    @endif
</body>
</html>
@endsection
@extends('layouts.app')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
</head>
<body>
    <h1>Results</h1>
    <form action="{{ url('/search') }}" method="get">
        <label for="query">Search:</label>
        <input type="text" id="query" name="query" required>
        <button type="submit">Search</button>
    </form>
    @if(!empty($data_list) && count($data_list) > 0)
        <ul>
            @foreach($data_list as $item)
                <li>
                    <strong>Title:</strong> {{ $item['title'] ?? 'N/A' }}<br>
                    <strong>Author:</strong> {{ $item['author'] ?? 'N/A' }}<br>
                    <strong>Date:</strong> {{ $item['date'] ?? 'N/A' }}<br>
                    <strong>Link:</strong> <a href="{{ $item['address'] }}" target="_blank">{{ $item['address'] }}</a><br>
                    <strong>Content:</strong> <p>{{ $item['content'] ?? 'N/A' }}</p>
                    <form action="{{ url('/delete_article') }}" method="post">
                        @csrf
                        <input type="hidden" name="url" value="{{ $item['address'] }}">
                        <button type="submit">Delete</button>
                    </form>
                    <a href="{{ url('/edit_article') }}?url={{ $item['address'] }}">Edit</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
    <a href="{{ url('/') }}">Back to Home</a>
</body>
</html>
@endsection
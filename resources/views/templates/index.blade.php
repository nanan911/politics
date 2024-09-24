@extends('layouts.app')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTT Crawler</title>
</head>
<body>
    <h1>PTT Crawler</h1>
    <form action="{{ url('/scrape') }}" method="post">
        @csrf
        <label for="limit">Number of pages to scrape:</label>
        <input type="number" id="limit" name="limit" required>
        <button type="submit">Submit</button>
    </form>

</body>
</html>
@endsection
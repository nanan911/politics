@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home_page.css') }}">
<div class="container_main">
    <div class="item-8">
        <!-- Include the partial view for displaying articles -->
        @include('partials.article-1', ['articles' => $articles])
    </div>
    <div class="item-1">
        @include('partials.filter-sidebar-article')
    </div>
</div>
@endsection

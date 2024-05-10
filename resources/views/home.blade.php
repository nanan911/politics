@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/home_page.css') }}">
<script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>

<div class="container_main">
    <div class="item-1">
        @include('partials.filter-sidebar')
    </div>
    <div class="item-2">
        @include('partials.chart.trend', ['title' => '', 'trend_data' => $trend_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>
    <div class="item-3">
        <span class="item-3-text">各縣市政黨討論度</span>
        @include('partials.chart.twmap_modal', ['title' => '', 'trend_data' => $trend_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>
    <div class="item-4">
        @include('partials.chart.bubble', ['title' => '', 'bubble_data' => $bubble_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>

    <div class="item-5">
        @include('partials.chart.packedbubble', ['title' => '', 'packedbubble_data' => $packedbubble_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>
        <div class="item-6">
        @include('partials.chart.network', ['title' => '', 'network_data' => $column_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>
  <div class="item-7">
        @include('partials.chart.column', ['title' => '', 'column_data' => $column_data, 'width' => '100%', 'height' => '100%', 'style' => 'border:none'])
    </div>
</div>

<script>
    let menuList = document.getElementById("menuList");
    menuList.style.maxHeight = "0px";

    function toggleMenu() {
        if (menuList.style.maxHeight === "0px") {
            menuList.style.maxHeight = "300px";
        } else {
            menuList.style.maxHeight = "0px";
        }
    }
</script>
@endsection
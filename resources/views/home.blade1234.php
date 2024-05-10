

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Sidebar -->
<div class="col-md-2">
    @include('partials.filter-sidebar')
</div>

<!-- Main Content -->
<div class="col-md-10">
    <!-- First Set of Charts -->
    <div class="row">
        <div class="col-md-8">
            @include('partials.chart.trend', [
                'title' => '議題追蹤趨勢圖',
                'trend_data' => $trend_data,
            ])
        </div>
        <div class="col-md-4">
            @include('partials.chart.column', [
                'title' => '熱門候選人',
                'column_data' => $column_data,
            ])
        </div>
    </div>

    <!-- Second Set of Charts -->
    <div class="row">
        <div class="col-md-8">
            @include('partials.chart.bubble', [
                'title' => '熱門候選人定位',
                'bubble_data' => $bubble_data,
            ]) 
        </div>
        <div class="col-md-4">
            @include('partials.chart.packedbubble', [
                'title' => '熱門詞彙',
                'packedbubble_data' => $packedbubble_data,
            ])
        </div>
    </div>
</div>
        @endsection

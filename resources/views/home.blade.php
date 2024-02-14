@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <!-- Left Sidebar: Filter -->
            <div class="col-md-2">
                @include('partials.filter-sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-md-6">
                @include('partials.chart.trend', [
                    'title' => '議題追蹤趨勢圖',
                    'trend_data' => $trend_data,
                ])
            </div>

            <!-- Right Sidebar: Second Chart -->
            <div class="col-md-4">
                @include('partials.chart.bar', [
                    'title' => '熱門候選人',
                    'bar_data' => $bar_data,
                ])
            </div>
        </div>
    </div>
@endsection

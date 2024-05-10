
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home_page.css') }}">
<div class='item-1'>
<div class="container">
    <div class="row">
        <!-- 條件篩選 -->
        <div class="col-md-3">
            <form method="get" role='form' action="{{ route('article') }}" id="filterForm">
                <!-- 選擇板塊 -->
                <div class="form-group">
                    <label for="selected_industry">選擇板塊：</label>
                    <select class="form-control" id="selected_industry" name="selected_industry">
                        <!-- 选项内容，根据实际情况修改 -->
                        <option value="政治">政治</option>
                    </select>
                </div>

                <!-- 候選人 -->
                <div class="form-group">
                    <label>候選人：</label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word[]" value="侯友宜"> 侯友宜
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word[]" value="賴清德"> 賴清德
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word[]" value="柯文哲"> 柯文哲
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>政黨：</label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word_type[]" value="國民黨"> 國民黨
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word_type[]" value="民進黨"> 民進黨
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_word_type[]" value="民眾黨"> 民眾黨
                        </label>
                    </div>
                </div>
                <!-- 時間 -->
                <div class="form-group">
                    <label for="start_date">開始時間：</label>
                    <input type="date" class="form-control" name="start_date" id="start_date">
                </div>
                <div class="form-group">
                    <label for="end_date">結束時間：</label>
                    <input type="date" class="form-control" name="end_date" id="end_date">
                </div>

                <!-- 來源 -->
                <!-- <div class="form-group">
                    <label>來源：</label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_class[]" value="FB"> FB
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_class[]" value="Ptt"> PTT
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_class[]" value="dcard"> dcard
                        </label>
                    </div>
                </div> -->

                <!-- 情緒 -->
                <div class="form-group">
                    <label>情緒：</label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Positive"> 正面
                        </label>
                        <!-- <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Neutral"> 中性
                        </label> -->
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Negative"> 負面
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">送出</button>
            </form>
        </div></div>
<!-- 文章列表 -->
<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">文章列表</h5>
        </div>
        <div class="card-body">
            @forelse($articles as $article)
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-8"><!-- 左侧占据8列 -->
                            <h2 class="h4">
                                <a href="{{ route('article.show', $article->id) }}"
                                    style="text-decoration: none; color: inherit; font-weight: bold;">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            <h5 class="h5">{{ $article->source->class }}</h5>
                            <p class="text-muted">{{ $article->date }}</p>
                            <p class="text-muted">
                                {{ \Illuminate\Support\Str::limit($article->content, 100) }}...
                            </p>
                            @if(strlen($article->content) > 100)
                                <p><a href="{{ route('article.show', $article->id) }}">顯示更多...</a></p>
                            @endif
                        </div>
                        <div class="col-md-4 text-right"><!-- 右侧占据4列，并右对齐 -->
                            <p class="text-muted">
                                情緒: 
                                <span style="color: {{ $article->sentiment === 'Positive' ? 'green' : ($article->sentiment === 'Negative' ? 'red' : 'gray') }}">
                                    {{ $article->sentiment }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
            @empty
                <p class="text-muted">目前沒有任何文章。</p>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $articles->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>




    </div>
</div>
@endsection

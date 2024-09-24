<div class="sidebar_right">
    <div class="checkbox">
        <div id="check">
            <form method="post" role='form' action="{{ route('home') }}" id="filterForm">
                @csrf <!-- CSRF token -->

                <!-- 條件篩選內容 -->
                <div class="link">
                    <i class="fa-solid fa-chart-simple"></i>
                    <h3>條件篩選</h3>
                    <p></p>
                </div>

                <!-- 選擇板塊 -->
                <div class="form-group">
                    <label for="selected_industry">選擇板塊：</label>
                    <select class="form-control" id="selected_industry" name="selected_industry">
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
                <div class="form-group">
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
                </div>

                <!-- 情緒 -->
                <div class="form-group">
                    <label>情緒：</label>
                    <div>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Positive"> 正面
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Neutral"> 中性
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="selected_sentiment[]" value="Negative"> 負面
                        </label>
                    </div>
                </div>

                <!-- 新增默认搜索标志 -->
                <input type="hidden" name="default_search" value="1">


                <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
            </form>
        </div>
    </div>
</div>
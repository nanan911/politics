<style>
    .btn-primary {
    background-color: #8f8a8e; /* 將按鈕的背景顏色設置為黑色 */
    color: #ffffff; /* 將按鈕的文字顏色設置為白色 */
    border-color: #292421; /* 設置按鈕的邊框顏色為黑色 */
}

.btn-primary:hover {
    background-color: #333333; /* 滑鼠懸停時按鈕的背景顏色變暗 */
    border-color: #333333; /* 滑鼠懸停時按鈕的邊框顏色變暗 */
}

</style>
<div class="link">
                   
                   <h3>條件篩選</h3>
                   <p></p>
               </div>
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
                <!-- 添加jQuery库 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- 复选框 -->
<label>政黨：</label>
<div>
    <label class="checkbox-inline">
        <input type="checkbox" name="selected_word[]" value="國民黨"> 國民黨
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="selected_word[]" value="民進黨"> 民進黨
    </label>
    <label class="checkbox-inline">
        <input type="checkbox" name="selected_word[]" value="民眾黨"> 民眾黨
    </label>
</div>

<!-- JavaScript代码 -->
<script>
    $(document).ready(function() {
        // 当复选框变化时触发事件
        $('input[type=checkbox]').on('change', function() {
            var selectedParty = $(this).val(); // 获取选中的政党

            // 根据选中的政党设置相应的候选人
            if (selectedParty === '國民黨') {
                // 选中侯友宜
                $('input[value="侯友宜"]').prop('checked', $(this).prop('checked'));
            } else if (selectedParty === '民進黨') {
                // 选中賴清德
                $('input[value="賴清德"]').prop('checked', $(this).prop('checked'));
            } else if (selectedParty === '民眾黨') {
                // 选中柯文哲
                $('input[value="柯文哲"]').prop('checked', $(this).prop('checked'));
            }
        });
    });
</script>

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
        </div>
        </div>


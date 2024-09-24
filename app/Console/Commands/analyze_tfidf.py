from sqlalchemy.orm import Session

@app.post("/process_data/")
async def process_data(request: Request, db: Session):
    # 假設你的文章資料在資料庫中的 articles 表
    articles = db.query(Article).all()  # 從資料庫中讀取數據
    
    # 將文章內容提取出來
    MetaData = pd.DataFrame([{
        'date': article.date,
        'address': article.address,
        'content': article.content
    } for article in articles])

    # 過濾中文字符
    MetaData['content'] = MetaData.content.apply(lambda x: re.sub('[^\u4e00-\u9fa5]+', '', x))
    
    # 使用 jieba 進行分詞
    MetaData['word'] = MetaData.content.apply(getToken)
    
    # 接下來是 TF-IDF 計算部分，這與你現有邏輯一致
    MetaData_token = MetaData.explode('word')
    data = pd.concat([MetaData_token.loc[:, ["date", "address", "word"]], MetaData_token.loc[:, ["date", "address", "word"]]], axis=0)

    word_count = data.groupby(['address', 'word'], as_index=False).size()
    word_count.rename(columns={'size': 'count'}, inplace=True)

    total_words = data.groupby(['address'], as_index=False).size()
    total_words.rename(columns={'size': 'total'}, inplace=True)

    water_words = word_count.merge(total_words, on='address', how='left')
    water_words_tf_idf = water_words.assign(tf=water_words.iloc[:, 2] / water_words.iloc[:, 3])

    idf_df = water_words.groupby(['word'], as_index=False).size()
    water_words_tf_idf = water_words_tf_idf.merge(idf_df, on='word', how='left')
    water_words_tf_idf = water_words_tf_idf.assign(idf=water_words_tf_idf.iloc[:, 5].apply(lambda x: math.log((len(total_words) / x), 10)))
    water_words_tf_idf = water_words_tf_idf.drop(labels=['size'], axis=1)

    water_words_tf_idf = water_words_tf_idf.assign(tf_idf=water_words_tf_idf.iloc[:, 4] * water_words_tf_idf.iloc[:, 5])

    # 挑選出前 20 個熱門關鍵詞
    top_words = (water_words_tf_idf.groupby("address")
                 .apply(lambda x: x.nlargest(20, "tf_idf"))
                 .reset_index(drop=True)
                 .groupby(['word'], as_index=False)
                 .size()).sort_values('size', ascending=False).head(20)

    return templates.TemplateResponse("results.html", {"request": request, "top_words": top_words.to_dict(orient="records")})

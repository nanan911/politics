from fastapi import FastAPI, UploadFile, File, Form
from fastapi.responses import HTMLResponse
from pydantic import BaseModel
import pandas as pd
import re
import jieba
from io import StringIO
from fastapi.templating import Jinja2Templates
from fastapi import Request

app = FastAPI()
templates = Jinja2Templates(directory="templates")

# 初始化 jieba 分詞
jieba.set_dictionary('./dict/dict.txt.big')
jieba.load_userdict('./dict/user_dict.txt')
with open('./dict/stopwords.txt', encoding="utf-8") as f:
    stop_words = [line.strip() for line in f.readlines()]

def get_tokens(text: str):
    seg_list = jieba.lcut(text)
    seg_list = [w for w in seg_list if w not in stop_words and len(w) > 1]
    return seg_list

@app.get("/", response_class=HTMLResponse)
async def main_page(request: Request):
    return templates.TemplateResponse("upload.html", {"request": request})

@app.post("/process_csv/")
async def process_csv(request: Request, file: UploadFile = File(...)):
    content = await file.read()
    csv_data = StringIO(content.decode('utf-8'))
    df = pd.read_csv(csv_data, encoding='UTF-8')

    # 清洗文本
    df['content'] = df.content.apply(lambda x: re.sub('[^\u4e00-\u9fa5]+', '', x))
    
    # 分詞處理
    df['tokens'] = df.content.apply(get_tokens)
    df_tokens = df.explode('tokens')

    # 計算 TF-IDF
    word_count = df_tokens.groupby(['address', 'tokens'], as_index=False).size()
    word_count.rename(columns={'size': 'count'}, inplace=True)
    
    total_words = df_tokens.groupby(['address'], as_index=False).size()
    total_words.rename(columns={'size': 'total'}, inplace=True)
    
    water_words = word_count.merge(total_words, on='address', how='left')
    water_words['tf'] = water_words['count'] / water_words['total']

    idf_df = word_count.groupby(['tokens'], as_index=False).size()
    water_words = water_words.merge(idf_df, on='tokens', how='left')
    water_words['idf'] = water_words['size'].apply(lambda x: math.log(len(total_words) / x, 10))
    water_words.drop(columns=['size'], inplace=True)

    water_words['tf_idf'] = water_words['tf'] * water_words['idf']
    
    top_words = (water_words.groupby("address")
                 .apply(lambda x: x.nlargest(20, "tf_idf"))
                 .reset_index(drop=True)
                 .groupby(['tokens'], as_index=False)
                 .size()).sort_values('size', ascending=False).head(20)

    return templates.TemplateResponse("results.html", {"request": request, "top_words": top_words.to_dict(orient="records")})

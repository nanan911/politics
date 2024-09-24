<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\DB;
use App\Models\TemporaryArticle;

class CrawlerController extends Controller
{
    private function fetchPage($url)
    {
        $client = new Client();
        $response = $client->request('GET', $url);
        return (string) $response->getBody();
    }

    private function scrapeArticles($url)
{
    $htmlContent = $this->fetchPage($url);
    $crawler = new Crawler($htmlContent);
    $articles = $crawler->filter('div.r-ent');
    $dataList = [];

    $articles->each(function (Crawler $node) use (&$dataList) {
        $data = [];
        $titleNode = $node->filter('div.title');
        $href = "";
        if ($titleNode->count() > 0 && $titleNode->filter('a')->count() > 0) {
            $href = "https://www.ptt.cc" . $titleNode->filter('a')->attr('href');
            $data["title"] = $titleNode->filter('a')->text();
        } else {
            $data["title"] = "沒有標題";
            $href = "沒有網址";
        }
        $data["address"] = $href;

        $posterNode = $node->filter('div.author');
        $data["author"] = $posterNode->count() > 0 ? $posterNode->text() : "N/A";

        $popularNode = $node->filter('div.nrec');
        // $data["popular"] = $popularNode->count() > 0 ? $popularNode->filter('span')->text() : "N/A";

        $dateNode = $node->filter('div.date');
        $rawDate = $dateNode->count() > 0 ? $dateNode->text() : "N/A";

        // 格式化日期
        $formattedDate = $this->formatDate($rawDate);
        $data["date"] = $formattedDate;

        if ($data["title"] != "沒有標題") {
            $articleHtmlContent = $this->fetchPage($href);
            $articleCrawler = new Crawler($articleHtmlContent);
        
            // 移除不需要的元素
            $articleCrawler->filter('div.article-metaline, div.article-metaline-right, div.push, span.article-meta-value, span.article-meta-tag, span.f2')->each(function (Crawler $tag) {
                $tag->getNode(0)->parentNode->removeChild($tag->getNode(0));
            });
        
            // 获取清理后的文章内容
            $text = $articleCrawler->filter('div#main-content')->text();
            
            // 使用正则表达式清理内容中的多余字符
            $pattern = '/[\x{2500}-\x{257F}\x{3000}\x{FEFF}\x{200B}-\x{200D}\x{2060}\x{00A0}\x{000D}\x{000A}\x{0009}\p{Z}]+/u'; 
            $filteredText = preg_replace($pattern, ' ', $text);
            $filteredText = trim($filteredText); // 去除首尾多余的空格
        
            // 搜索特定字符串并截取内容
            $searchStr = "返回看板";
            if (strpos($filteredText, $searchStr) !== false) {
                $filteredText = explode($searchStr, $filteredText, 2)[0]; // 取出返回看板前的内容
            }
        
            // 将清理后的内容保存到数据数组中
            $data["content"] = $filteredText;
        } else {
            return;
        }
        $dataList[] = $data;
        
    });

    return $dataList;
}

private function formatDate($rawDate)
{
    // 假設日期格式為 '9/04'，且我們需要將其轉換為 '2024-09-04'
    // 以下假設是日期格式 'm/d'，年份需要補全，例如 2024
    $currentYear = date('Y'); // 獲取當前年份
    $dateParts = explode('/', $rawDate);
    
    if (count($dateParts) == 2) {
        $month = $dateParts[0];
        $day = $dateParts[1];
        return "{$currentYear}-" . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
    }
    
    return 'N/A'; // 如果日期格式不符合預期，返回 'N/A'
}

public function search(Request $request)
{
    $query = $request->input('query');

    $dataList = TemporaryArticle::where('title', 'LIKE', "%{$query}%")
                                ->orWhere('content', 'LIKE', "%{$query}%")
                                ->orWhere('Author', 'LIKE', "%{$query}%")
                                ->get();

    return view('templates.results', ['data_list' => $dataList]);
}

public function deleteArticle(Request $request)
{
    $url = $request->input('url');

    TemporaryArticle::where('address', $url)->delete();

    $dataList = TemporaryArticle::all();

    return view('templates.results', ['data_list' => $dataList]);
}

    public function index()
    {
        return view('templates.index');
    }

    public function storeTemporaryArticles(Request $request)
    {
        $data = $request->input('data_list'); // 假設爬取的資料以 'data_list' 傳遞

        DB::transaction(function () use ($data) {
            foreach ($data as $item) {
                TemporaryArticle::updateOrCreate(
                    ['address' => $item['address']], // 確保唯一性
                    [
                        'source_id' => $item['source_id'] ?? null,
                        'title' => $item['title'],
                        'address' => $item['address'],
                        'author' => $item['author'] ?? null,
                        'popular' => $item['popular'] ?? null,
                        'sentiment_id' => $item['sentiment_id'] ?? null,
                        'content' => $item['content'],
                        'date' => $item['date'],
                        'is_analyzed' => false,
                    ]
                );
            }
        });

        return response()->json(['status' => 'success']);
    }

    public function scrape(Request $request)
    {
        $limit = $request->input('limit');
        $url = 'https://www.ptt.cc/bbs/HatePolitics/index.html';

        $pageHtml = $this->fetchPage($url);
        $crawler = new Crawler($pageHtml);
        $pageLink = $crawler->filter('a:contains("‹ 上頁")');
        $page = 0;
        if ($pageLink->count() > 0) {
            $href = $pageLink->attr('href');
            $page = intval(explode('index', explode('.html', $href)[0])[1]) + 1;
        }

        $dataList = [];
        for ($z = 0; $z < $limit; $z++) {
            $pageUrl = "https://www.ptt.cc/bbs/HatePolitics/index{$page}.html";
            $dataList = array_merge($dataList, $this->scrapeArticles($pageUrl));
            $page--;
        }

        // 直接存入 temporary_articles 資料表
        $this->storeTemporaryArticles(new Request(['data_list' => $dataList]));

        return view('templates.results', ['data_list' => $dataList]);
    }

    public function editArticle(Request $request)
    {
        $url = $request->input('url');
        $article = TemporaryArticle::where('address', $url)->first();
    
        if (!$article) {
            abort(404, "Article not found");
        }
    
        return view('templates.edit', ['article' => $article]);
    }
    public function saveArticle(Request $request)
    {
        $url = $request->input('url');
        $title = $request->input('title');
        $content = $request->input('content');
    
        $article = TemporaryArticle::where('address', $url)->first();
    
        if (!$article) {
            abort(404, "Article not found");
        }
    
        $article->title = $title;
        $article->content = $content;
        $article->save();
    
        return redirect()->route('results'); // 確保這裡的路由名稱與你的路由設定一致
    }
    

}

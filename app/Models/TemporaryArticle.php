<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryArticle extends Model
{
    use HasFactory;

    // 指定可以批量賦值的屬性
    protected $fillable = [
        'source_id',
        'title',
        'address',
        'author',
        'popular',
        'sentiment_id',
        'content',
        'date',
        'is_analyzed',
    ];
   // 指定表名和其他模型屬性
   protected $table = 'temporary_articles';

   // 定義與 Author 模型的關聯
   public function author()
   {
       return $this->belongsTo(Author::class, 'author_id');
   }
    // 可選：定義表名稱，如果表名稱不同於模型名稱的複數形式
    // protected $table = 'temporary_articles';
}

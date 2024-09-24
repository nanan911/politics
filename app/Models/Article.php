<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Article
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $source_id
 * @property string $title
 * @property string $content
 * @property string $date
 * @property-read \App\Models\Source $source
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\KeywordSet> $keywordSets
 * @property-read int|null $keyword_sets_count
 * @property-read \App\Models\Sentiment|null $sentiment
 * @mixin \Eloquent
 */

class Article extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'title', 
        'content', 
        'date', 
        'source_id', 
        'author', 
        'popular', 
        'sentimen_id',
        'address',
    ];
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function sentiment()
    {
        return $this->belongsTo(Sentiment::class, 'sentimen_id', 'id');
    }

    // Article.php
    public function keywords()
    {
        return $this->belongsToMany(KeywordSet::class, 'article_keywords');
    }

    // Keyword.php
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_keywords');
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    protected $table = 'articles';
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    

    public function politicians()
{
    return $this->belongsToMany(Politician::class, 'article_politician');
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\KeywordSet
 *
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $word
 * @property array $set
 * @method static \Database\Factories\KeywordSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereWord($value)
 * @property string|null $word_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|KeywordSet whereWordType($value)
 * @mixin \Eloquent
 */
class KeywordSet extends Model
{
    use HasFactory;

    protected $table = 'keyword_sets';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'set' => 'array'
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_keywords', 'keyword_set_id', 'article_id');
    }
}

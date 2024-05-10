<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArticleKeyword
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $article_id
 * @property int $keyword_set_id
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword whereKeywordSetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArticleKeyword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ArticleKeyword extends Model
{
    use HasFactory;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sentiment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $artical_id
 * @property mixed $sentence
 * @property mixed $aspect
 * @property mixed $aspect_sentiment
 * @property mixed $aspect_num
 * @property string $sentiment
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereArticalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereAspect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereAspectNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereAspectSentiment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereSentence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereSentiment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereUpdatedAt($value)
 * @property int $article_id
 * @method static \Illuminate\Database\Eloquent\Builder|Sentiment whereArticleId($value)
 * @mixin \Eloquent
 */
class Sentiment extends Model
{
    use HasFactory;
}

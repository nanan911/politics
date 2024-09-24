<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\message
 *
 * @property int $id
 * @property int $article_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $poster
 * @property string $state
 * @property string $content
 * @method static \Illuminate\Database\Eloquent\Builder|message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message query()
 * @method static \Illuminate\Database\Eloquent\Builder|message whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    use HasFactory;
}

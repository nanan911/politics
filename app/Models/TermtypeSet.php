<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TermtypeSet
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $termType
 * @property mixed $termType_set
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet whereTermType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet whereTermTypeSet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TermtypeSet whereUpdatedAt($value)
 * @method static \Database\Factories\TermtypeSetFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class TermtypeSet extends Model
{
    use HasFactory;

    protected $table = 'term_types';
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $casts = [
        'set' => 'array'
    ];
}

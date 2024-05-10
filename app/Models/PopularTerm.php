<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PopularTerm
 *
 * @method static \Illuminate\Database\Eloquent\Builder|PopularTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PopularTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PopularTerm query()
 * @mixin \Eloquent
 */
class PopularTerm extends Model
{
    use HasFactory;

    protected $table = 'popular_taerms';
}

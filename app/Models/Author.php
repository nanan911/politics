<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model {
    protected $table = 'authors';
    public function articles() {
        return $this->hasMany(Article::class);
    }
}

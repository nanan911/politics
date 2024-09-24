<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $table = 'comments';
    public function article() {
        return $this->belongsTo(Article::class);
    }
    public function author() {
        return $this->belongsTo(Author::class);
    }
}

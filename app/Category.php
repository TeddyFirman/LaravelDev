<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = ['name', 'is_publish'];

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', '%'.$keyword.'%')->orWhere('is_publish', 'LIKE', '%'.$keyword.'%');
    }

    public function scopePaginate($query, $perPage = 10)
    {
        return $query->paginate($perPage);
    }
}

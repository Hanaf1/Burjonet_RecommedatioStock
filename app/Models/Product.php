<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'nama',
        'deskripsi',
        'stok_minimum'
    ];

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }
}

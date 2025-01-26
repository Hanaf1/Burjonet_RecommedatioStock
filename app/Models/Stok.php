<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = 'stok';

    protected $fillable = [
        'product_id',
        'jumlah',
        'jumlah_beli',
        'jumlah_terjual',
        'tanggal'
    ];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

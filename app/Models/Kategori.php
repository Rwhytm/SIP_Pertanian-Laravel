<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori'];

    public function products()
    {
        return $this->belongsToMany('App\Models\Produk', 'table_kategori_produk', 'kategori_id', 'produk_id');
    }
}

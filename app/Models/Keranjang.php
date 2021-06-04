<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $fillable = [
        'user_id',
        'produk_id',
        'total',
        'jumlah'];

    // public function produk()
    // {
    //     return $this->hasMany('App\Models\Produk', 'id', 'produk_id');
    // }
    public function produk()
    {
        return $this->belongsTo('App\Models\Produk', 'produk_id');
    }
    public function user()
    {
        return $this->belongsToMany('App\User');
    }
}

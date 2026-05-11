<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';


    protected $fillable = [
        'user_id',
        'nama_produk',
        'kode_produk',
        'stok',
        'harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
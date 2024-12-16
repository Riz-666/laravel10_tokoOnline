<?php

namespace App\Models;

use App\Models\FotoProduk;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama_produk',
        'detail',
        'harga',
        'berat',
        'stok',
        'foto',
        'status'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function fotoProduk()
    {
        return $this->hasMany(FotoProduk::class);
    }
}

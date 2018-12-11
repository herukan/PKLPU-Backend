<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $fillable = ['nama', 'instansi', 'alamat', 'perihal','tgl_mulai','tgl_kembali','jenis','plat','harga'];
}

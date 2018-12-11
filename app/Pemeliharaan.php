<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    protected $fillable = ['plat', 'jenis', 'odometer', 'keterangan','jenis_bb','harga_bb','jumlah_bb','tipe_service','harga_service','tgl_mulai','tgl_selesai','suku_cadang','harga_suku'];
}

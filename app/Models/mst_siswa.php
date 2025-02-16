<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mst_siswa extends Model
{
    protected $table = 'mst_siswas';
    protected $guarded = [];

    public function ranking()
    {
        return $this->belongsTo(nilai_akhir::class, 'nis', 'nis');
    }
}

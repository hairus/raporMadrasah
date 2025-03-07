<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class nilai_akhir extends Model
{
    public function siswas()
    {
        return $this->belongsTo(mst_siswa::class, 'nis', 'nis');
    }

    public function tas()
    {
        return $this->belongsTo(ta::class, 'tas_id', );
    }
}

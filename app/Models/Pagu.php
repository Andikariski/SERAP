<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pagu extends Model
{
    protected $table = 'tbl_pagu_opd';

    protected $fillable = [
        'fkid_opd',
        'pagu_SG',
        'pagu_BG',
        'pagu_DTI',
        'tahun_pagu',
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'fkid_opd');
    }

}

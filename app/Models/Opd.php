<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Opd extends Model
{
    use HasFactory;
    protected $table = 'tbl_opd';
    protected $fillable = [
        'nama_opd',
        'kode_opd',
        'alamat_opd',

    ];

     public function users()
    {
        return $this->hasMany(User::class,'opd_id', 'id');
    }

     public function pagu()
    {
        return $this->hasOne(Pagu::class, 'fkid_opd');
    }

    public function rap()
    {
        return $this->hasMany(Rap::class, 'fkid_opd');
    }

}

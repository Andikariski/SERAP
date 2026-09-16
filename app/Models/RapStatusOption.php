<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RapStatusOption extends Model
{
    protected $table = 'tbl_rap_status_options';
    protected $fillable = ['nama', 'urutan'];
}
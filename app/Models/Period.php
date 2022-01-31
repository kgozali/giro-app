<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = "master_period";
}

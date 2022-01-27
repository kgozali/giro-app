<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiroTransaction extends Model
{
    protected $table = "giro_transaction";
    protected $fillable = ['giro_date','giro_number', 'customer_name', 'amount'];
}

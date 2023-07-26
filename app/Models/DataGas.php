<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataGas extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'gas_amonia',
        'gas_metana',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}

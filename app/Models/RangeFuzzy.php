<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RangeFuzzy extends Model
{
    use HasFactory;

    protected $table = 'tbl_range_fuzzy';

    protected $fillable = [
        'id_variabel',
        'a',
        'b',
        'c',
        'd'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jam extends Model
{
    /** @use HasFactory<\Database\Factories\WikulinerFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'name',
        'serialNumber',
        'imageUrl'
    ];

    protected $primaryKey = "id_jam";
}

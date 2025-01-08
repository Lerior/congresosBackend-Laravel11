<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congreso extends Model
{
    use Authenticatable, HasFactory;

    protected $table = 'congresos';

    protected $fillable = [
        'congress_title', 'congress_description', 'congress_date'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}

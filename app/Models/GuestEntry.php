<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'organization', 'met_with', 'purpose', 'message',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifiaction extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status'
    ];
    use HasFactory;
}

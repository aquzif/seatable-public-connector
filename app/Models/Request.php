<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'opis',
        'kwota_brutto',
        'ocr_result',
        'images',
    ];

    protected $casts = [
        'kwota_brutto' => 'decimal:2',
        'images' => 'array',
    ];
}

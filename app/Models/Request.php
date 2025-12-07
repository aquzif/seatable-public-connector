<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'images' => 'array',
    ];

    protected function kwotaBrutto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format((float) $value, 2, '.', '')
        );
    }
}

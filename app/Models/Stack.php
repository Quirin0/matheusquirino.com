<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'icon_url', 'category', 'color', 'order', 'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'order'   => 'integer',
    ];

    public static function categories(): array
    {
        return [
            'frontend' => 'Frontend',
            'backend'  => 'Backend',
            'database' => 'Banco de dados',
            'devops'   => 'DevOps',
            'mobile'   => 'Mobile',
            'other'    => 'Outros',
        ];
    }
}

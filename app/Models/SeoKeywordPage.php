<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKeywordPage extends Model
{
    protected $fillable = [
        'keyword',
        'cluster',
        'used_for',
        'frequency',
        'title',
        'h1',
        'h2',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_fields',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'frequency' => 'integer',
            'meta_fields' => 'array',
            'is_active' => 'boolean',
        ];
    }
}

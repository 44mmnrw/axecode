<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoKeywordPage extends Model
{
    protected $fillable = [
        'keyword',
        'cluster',
        'used_for',
        'target_url',
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
        'coverage_status',
        'has_landing_page',
        'has_meta',
        'has_content',
        'priority_score',
        'last_audit_at',
    ];

    protected function casts(): array
    {
        return [
            'frequency' => 'integer',
            'meta_fields' => 'array',
            'is_active' => 'boolean',
            'has_landing_page' => 'boolean',
            'has_meta' => 'boolean',
            'has_content' => 'boolean',
            'priority_score' => 'integer',
            'last_audit_at' => 'datetime',
        ];
    }
}

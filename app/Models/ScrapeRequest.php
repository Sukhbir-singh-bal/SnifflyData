<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScrapeRequest extends Model
{
    public const UPDATED_AT = null;

    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';

    protected $table = 'requests';

    protected $fillable = [
        'user_id',
        'api_key_id',
        'url',
        'status',
        'response_time',
        'credits_used',
    ];

    protected function casts(): array
    {
        return [
            'api_key_id' => 'integer',
            'response_time' => 'integer',
            'credits_used' => 'integer',
            'created_at' => 'datetime',
        ];
    }

    public function apiKey(): BelongsTo
    {
        return $this->belongsTo(ApiKey::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function usageLogs(): HasMany
    {
        return $this->hasMany(UsageLog::class, 'request_id');
    }
}

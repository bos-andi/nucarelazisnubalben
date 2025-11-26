<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'version',
        'commit_hash',
        'branch',
        'description',
        'changes',
        'status',
        'log',
        'error_message',
        'updated_by',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'changes' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user who initiated the update
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the latest successful update
     */
    public static function getLatestSuccessful(): ?self
    {
        return self::where('status', 'completed')
            ->orderByDesc('completed_at')
            ->first();
    }

    /**
     * Get pending updates
     */
    public static function getPending(): \Illuminate\Database\Eloquent\Collection
    {
        return self::where('status', 'pending')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Check if system is currently updating
     */
    public static function isUpdating(): bool
    {
        return self::where('status', 'in_progress')->exists();
    }

    /**
     * Get update history
     */
    public static function getHistory(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return self::with('updatedBy')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }
}
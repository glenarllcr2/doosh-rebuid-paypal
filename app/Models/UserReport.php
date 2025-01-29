<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_id',
        'report',
        'answer',
        'status',
        'page_url',
        'user_agent',
        'review_date',
    ];

    protected $appends = ['reporter_name', 'target_name'];
    protected $casts = [
        'status' => 'string',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    // Accessor برای نام گزارش‌دهنده
    public function getReporterNameAttribute()
    {
        return $this->reporter ? "{$this->reporter->first_name} {$this->reporter->last_name}" : null;
    }

    // Accessor برای نام هدف گزارش
    public function getTargetNameAttribute()
    {
        return $this->target ? "{$this->target->first_name} {$this->target->last_name}" : null;
    }

    // Scope برای جستجو
    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->whereHas('reporter', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            })->orWhereHas('target', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }
    }

    // Scope برای مرتب‌سازی
    public function scopeSortBy($query, $column, $direction)
    {
        if (in_array($column, ['reporter_name', 'target_name'])) {
            $relation = $column === 'reporter_name' ? 'reporter' : 'target';
            $query->whereHas($relation, function ($q) use ($direction) {
                $q->orderBy('first_name', $direction)->orderBy('last_name', $direction);
            });
        } else {
            $query->orderBy($column, $direction);
        }
    }
}

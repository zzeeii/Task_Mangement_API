<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'priority', 'due_date', 'status', 'assigned_to','created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to'); 
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function scopePriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

  
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y H:i', $value);
    }
}

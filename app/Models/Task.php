<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'assigned_to', 'created_by'];

    /**
     * The user that the task created
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The user that the task assigned
     *
     * @return BelongsTo
     */
    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

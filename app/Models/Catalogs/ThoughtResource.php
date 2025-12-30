<?php

namespace App\Models\Catalogs;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ThoughtResource extends Model
{
    protected $table = "thought_resources";
    protected $fillable = [
        'id',
        'name',
        'status',
        'adder',
        'editor',
    ];

    protected $hidden = [
        'adder',
        'editor',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function attachmentFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'id', 'model_id')
            ->where('type', 'thought_resource_image')
            ->where('model', ThoughtResource::class)
            ->orderByDesc('id');
    }

    public function adderInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adder');
    }

    public function editorInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor');
    }
}

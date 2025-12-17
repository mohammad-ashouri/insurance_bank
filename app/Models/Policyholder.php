<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Policyholder extends Model
{
    use SoftDeletes;
    protected $table = "policyholders";
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'father_name',
        'national_code',
        'birthdate',
        'mobile',
        'email',
        'address',
        'postal_code',
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

    public function adderInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adder');
    }

    public function editorInfo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor');
    }
}

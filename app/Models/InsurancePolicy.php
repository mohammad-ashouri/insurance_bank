<?php

namespace App\Models;

use App\Models\Catalogs\InsuranceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsurancePolicy extends Model
{
    use SoftDeletes;
    protected $table = "insurance_policies";
    protected $fillable = [
        'id',
        'policyholder_id',
        'owner_id',
        'insurance_type_id',
        'starts_at',
        'ends_at',
        'insurance_policy_number',
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

    public function policyholderInfo(): BelongsTo
    {
        return $this->belongsTo(policyholder::class);
    }

    public function ownerInfo(): BelongsTo
    {
        return $this->belongsTo(policyholder::class);
    }

    public function insuranceTypeInfo(): BelongsTo
    {
        return $this->belongsTo(InsuranceType::class);
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

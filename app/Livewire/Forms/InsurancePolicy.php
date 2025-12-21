<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class InsurancePolicy extends Form
{
    public $policy_holder_id;

    public $owner_id;

    public $insurance_type;

    #[Validate('nullable|date')]
    public $starts_at;

    #[Validate('required|date')]
    public $ends_at;

    #[Validate('nullable|string|max:40')]
    public $insurance_policy_number;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $insurance_policy_photo;
    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $attachment_insurance_photo;
    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $vehicle_card_up;
    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $vehicle_card_down;
}

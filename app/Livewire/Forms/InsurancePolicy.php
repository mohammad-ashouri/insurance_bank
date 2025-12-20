<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class InsurancePolicy extends Form
{
    public $policy_holder_id;
    public $owner_id;


    public $insurance_policy_photo;
    public $vehicle_registration_card_up;
    public $vehicle_registration_card_down;
}

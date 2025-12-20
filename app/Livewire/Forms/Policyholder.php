<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class Policyholder extends Form
{
    #[Validate('required|string|max:100')]
    public $first_name;

    #[Validate('required|string|max:100')]
    public $last_name;

    #[Validate('nullable|string|max:100')]
    public $father_name;

    #[Validate('nullable|integer|max_digits:10')]
    public $national_code;

    #[Validate('nullable|date')]
    public $birthdate;

    #[Validate('required|regex:/^09[0-9]{9}$/')]
    public $mobile;

    #[Validate('nullable|email')]
    public $email;

    #[Validate('nullable|string|max:1024')]
    public $address;

    #[Validate('nullable|integer|max_digits:10')]
    public $postal_code;

    #[Validate('nullable|boolean:0,1')]
    public $status;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $national_photo_file_up;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $national_photo_file_down;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $vehicle_registration_card_up;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $vehicle_registration_card_down;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $id_card_photo;

    #[Validate('nullable|file|mimes:jpeg,jpg,png,bmp|max:5120')]
    public $personal_photo;
}

<?php

use App\Models\Catalogs\Field;

if (!function_exists('processValidationMessageForDynamicFields')) {
    function processValidationMessageForDynamicFields($message, $model_name = null)
    {
        if (!$model_name || !str_contains($message, 'entered field')) {
            return $message;
        }

        $field = Field::where('model_name', $model_name)->firstOrFail();
        $model_name_without_underscore = str_replace('_', ' ', $model_name);

        return str_replace([
            'entered field',
            $model_name_without_underscore,
            "entered_field.{$model_name}"
        ], [
            'entered_field',
            $field->model_name,
            $field->name
        ], $message);
    }
}
if (!function_exists('convertNumbersToPersianWords')) {
    function convertNumbersToPersianWords($num): false|string
    {
        if (!is_numeric($num)) {
            return 'ورودی معتبر نیست';
        }

        $f = new \NumberFormatter("fa", \NumberFormatter::SPELLOUT);
        return $f->format($num);
    }
}

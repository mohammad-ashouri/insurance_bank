<?php

use Morilog\Jalali\Jalalian;

if (!function_exists('getColumnsForServicesIndex')) {
    function getColumnsForServicesIndex($services): array
    {
        $columns = [];
        foreach ($services as $fields) {
            foreach ($fields->serviceFieldValues as $column) {
                $columns[] = $column->field_name;
            }
        }
        return array_unique($columns);
    }
}
if (!function_exists('getRowsForServicesIndex')) {
    function getRowsForServicesIndex($services): array
    {
        $rows_s = [];
        foreach ($services as $fields) {
            $rows = [];
            foreach ($fields->serviceFieldValues as $row) {
                $row_value = json_decode($row->value, true);
                if (is_array($row_value)) {
                    $exported_keys = [];
                    if ($row->id == 46) {
                        $row_value = array_flip($row_value);
                    }
                    foreach ($row_value as $index => $value) {
                        if (!$value and !$index) continue;

                        $exported_keys[] = $index;
                    }
                    $rows[$row->field_name] = implode(",", $exported_keys);

                } else {
                    $rows[$row->field_name] = $row_value;
                }
            }
            $rows_s[] = $rows;
        }
        return $rows_s;
    }
}
if (!function_exists('checkExpiredService')) {
    function checkExpiredService($date): bool
    {
        $expiresAt = Jalalian::fromFormat('Y-m-d H:i:s', $date);
        $threshold = $expiresAt->subDays(2);   // دو روز قبل از تاریخ انقضا

        return Jalalian::now()->greaterThanOrEqualsTo($threshold);
    }
}

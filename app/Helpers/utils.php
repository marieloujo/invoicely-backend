<?php

use Illuminate\Foundation\Http\FormRequest;

if (!function_exists('calculate_taxe_amount')) {

    function calculate_taxe_amount(float $amount) : float {
        return $amount * 0.18;
    }
}

if (!function_exists('get_include_taxe_amount')) {

    function get_include_taxe_amount(float $amount) : float {
        return $amount + calculate_taxe_amount($amount);
    }
}

if (!function_exists('format_amount')) {

    function format_amount($amount) {
        $formattedAmount = number_format($amount, 0, '.', ',');
        return str_replace(',', ' ', $formattedAmount);
    }
}


if (!function_exists('generate_unique_reference')) {

    function generate_unique_reference() {
        $timestamp = microtime(true);
        $uniqueId = uniqid();

        $uniqueReference = 'REF-' . $uniqueId . '-' . $timestamp;
        $uniqueReference = 'REF-' . substr(hash('sha256', $uniqueReference), 0, 16);

        return $uniqueReference;
    }
}

if (!function_exists('generate_unique_invoice_number')) {

    function generate_unique_invoice_number() {
        $dateTime = new DateTime();
        $dateString = $dateTime->format('YmdHis'); // Format: YYYYMMDDHHMMSS

        $uniqueId = uniqid();

        $factureNumber = 'INV-' . $dateString . '-' . $uniqueId;
        $factureNumber = 'INV-' . substr(hash('sha256', $factureNumber), 0, 16);

        return $factureNumber;
    }
}

if (!function_exists('path_build')) {

    function path_build(string $basePath, string $param) {
        return $basePath . '/' . $param;
    }
}

if (!function_exists('sluglify')) {

    function sluglify(string $name) {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        return preg_replace('/-+/', '-', $slug);
    }
}

if (!function_exists('mock_request')) {

    function mock_request(array $data) {
        return new FormRequest([], [], [], [], [], [], json_encode($productData));
    }
}

<?php

return [
    /*
    |--------------------------------------------------------------------------
    | QrCode Default Settings
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default settings for the QR code generator.
    |
    */

    'format' => env('QRCODE_FORMAT', 'svg'),
    'size' => env('QRCODE_SIZE', 100),
    'margin' => env('QRCODE_MARGIN', 0),
    'error_correction' => env('QRCODE_ERROR_CORRECTION', 'M'),
    'encoding' => env('QRCODE_ENCODING', 'UTF-8'),
];
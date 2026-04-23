<?php

use Manoar\QrCode\DataTypes\OTP;

test('it generates a totp uri with label and secret', function () {
    $otp = new OTP();
    $otp->create([['label' => 'user@example.com', 'secret' => 'JBSWY3DPEHPK3PXP']]);
    $output = strval($otp);
    expect($output)->toStartWith('otpauth://totp/user%40example.com')
        ->and($output)->toContain('secret=JBSWY3DPEHPK3PXP')
        ->and($output)->toContain('digits=6')
        ->and($output)->toContain('period=30');
});

test('it generates a hotp uri', function () {
    $otp = new OTP();
    $otp->create([['label' => 'user@example.com', 'secret' => 'JBSWY3DPEHPK3PXP', 'type' => 'hotp', 'counter' => 5]]);
    $output = strval($otp);
    expect($output)->toStartWith('otpauth://hotp/')
        ->and($output)->toContain('counter=5');
});

test('it includes the issuer in the uri', function () {
    $otp = new OTP();
    $otp->create([['label' => 'alice', 'secret' => 'JBSWY3DPEHPK3PXP', 'issuer' => 'MyApp']]);
    expect(strval($otp))->toContain('issuer=MyApp');
});

test('it throws an exception when label is missing', function () {
    $otp = new OTP();
    $otp->create([['secret' => 'JBSWY3DPEHPK3PXP']]);
})->throws(InvalidArgumentException::class);

test('it throws an exception when secret is missing', function () {
    $otp = new OTP();
    $otp->create([['label' => 'user@example.com']]);
})->throws(InvalidArgumentException::class);

test('it throws an exception for an invalid otp type', function () {
    $otp = new OTP();
    $otp->create([['label' => 'user@example.com', 'secret' => 'JBSWY3DPEHPK3PXP', 'type' => 'invalid']]);
})->throws(InvalidArgumentException::class);

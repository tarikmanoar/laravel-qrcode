<?php

use Manoar\QrCode\DataTypes\PhoneNumber;

test('it generates the proper format for calling a phone number', function () {
    $phoneNumber = new PhoneNumber();
    $phoneNumber->create(['555-555-5555']);
    expect(strval($phoneNumber))->toEqual('tel:555-555-5555');
});

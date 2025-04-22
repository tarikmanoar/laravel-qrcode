<?php

use Manoar\QrCode\DataTypes\SMS;

beforeEach(function () {
    $this->sms = new SMS();
});

test('it generates a proper format with a phone number', function () {
    $this->sms->create(['555-555-5555']);
    expect(strval($this->sms))->toEqual('sms:555-555-5555');
});

test('it generate a proper format with a message', function () {
    $this->sms->create([null, 'foo']);
    expect(strval($this->sms))->toEqual('sms:&body=foo');
});

test('it generates a proper format with a phone number and message', function () {
    $this->sms->create(['555-555-5555', 'foo']);
    expect(strval($this->sms))->toEqual('sms:555-555-5555&body=foo');
});

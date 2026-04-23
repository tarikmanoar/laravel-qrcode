<?php

use Manoar\QrCode\DataTypes\WhatsApp;

beforeEach(function () {
    $this->whatsapp = new WhatsApp();
});

test('it generates a whatsapp link with phone only', function () {
    $this->whatsapp->create(['+1234567890']);
    expect(strval($this->whatsapp))->toEqual('https://wa.me/1234567890');
});

test('it generates a whatsapp link with phone and message', function () {
    $this->whatsapp->create(['+1234567890', 'Hello there!']);
    expect(strval($this->whatsapp))->toEqual('https://wa.me/1234567890?text=Hello%20there%21');
});

test('it strips non-numeric characters from the phone number', function () {
    $this->whatsapp->create(['(123) 456-7890']);
    expect(strval($this->whatsapp))->toEqual('https://wa.me/1234567890');
});

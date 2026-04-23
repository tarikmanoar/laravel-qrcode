<?php

use Manoar\QrCode\DataTypes\MeCard;

beforeEach(function () {
    $this->mecard = new MeCard();
});

test('it generates a mecard with name and phone', function () {
    $this->mecard->create([['first_name' => 'John', 'last_name' => 'Doe', 'phone' => '+1234567890']]);
    $output = strval($this->mecard);
    expect($output)->toContain('MECARD:N:Doe,John')
        ->and($output)->toContain('TEL:+1234567890');
});

test('it generates a mecard with all fields', function () {
    $this->mecard->create([[
        'first_name' => 'Jane',
        'last_name'  => 'Smith',
        'phone'      => '+9876543210',
        'email'      => 'jane@example.com',
        'address'    => '123 Main St',
        'url'        => 'https://example.com',
        'note'       => 'Hello',
        'birthday'   => '19900101',
    ]]);
    $output = strval($this->mecard);
    expect($output)->toContain('EMAIL:jane@example.com')
        ->and($output)->toContain('URL:https://example.com')
        ->and($output)->toContain('NOTE:Hello')
        ->and($output)->toContain('BDAY:19900101');
});

test('it generates a mecard using the name alias', function () {
    $this->mecard->create([['name' => 'Bob Builder']]);
    expect(strval($this->mecard))->toContain('MECARD:N:Builder,Bob');
});

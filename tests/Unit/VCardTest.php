<?php

use Manoar\QrCode\DataTypes\VCard;

beforeEach(function () {
    $this->vcard = new VCard();
});

test('it generates a vcard with full name and phone', function () {
    $this->vcard->create([['first_name' => 'John', 'last_name' => 'Doe', 'phone' => '+1234567890']]);
    $output = strval($this->vcard);
    expect($output)->toContain('BEGIN:VCARD')
        ->and($output)->toContain('VERSION:3.0')
        ->and($output)->toContain('N:Doe;John;;;')
        ->and($output)->toContain('FN:John Doe')
        ->and($output)->toContain('TEL;TYPE=CELL:+1234567890')
        ->and($output)->toContain('END:VCARD');
});

test('it generates a vcard with all fields', function () {
    $this->vcard->create([[
        'first_name' => 'Jane',
        'last_name'  => 'Smith',
        'phone'      => '+9876543210',
        'email'      => 'jane@example.com',
        'company'    => 'Acme Corp',
        'title'      => 'Engineer',
        'address'    => '123 Main St',
        'url'        => 'https://example.com',
        'note'       => 'Test note',
    ]]);
    $output = strval($this->vcard);
    expect($output)->toContain('FN:Jane Smith')
        ->and($output)->toContain('ORG:Acme Corp')
        ->and($output)->toContain('TITLE:Engineer')
        ->and($output)->toContain('EMAIL:jane@example.com')
        ->and($output)->toContain('URL:https://example.com')
        ->and($output)->toContain('NOTE:Test note');
});

test('it generates a vcard using the name alias', function () {
    $this->vcard->create([['name' => 'Alice Wonderland']]);
    expect(strval($this->vcard))->toContain('FN:Alice Wonderland');
});

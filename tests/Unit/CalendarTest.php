<?php

use Manoar\QrCode\DataTypes\Calendar;

test('it generates a valid ical event string', function () {
    $calendar = new Calendar();
    $calendar->create([[
        'summary'  => 'Team Meeting',
        'start'    => '20240601T100000Z',
        'end'      => '20240601T110000Z',
        'location' => 'Conference Room',
    ]]);
    $output = strval($calendar);
    expect($output)->toContain('BEGIN:VCALENDAR')
        ->and($output)->toContain('BEGIN:VEVENT')
        ->and($output)->toContain('SUMMARY:Team Meeting')
        ->and($output)->toContain('DTSTART:20240601T100000Z')
        ->and($output)->toContain('DTEND:20240601T110000Z')
        ->and($output)->toContain('LOCATION:Conference Room')
        ->and($output)->toContain('END:VEVENT')
        ->and($output)->toContain('END:VCALENDAR');
});

test('it parses an iso 8601 date string', function () {
    $calendar = new Calendar();
    $calendar->create([[
        'summary' => 'Launch',
        'start'   => '2024-06-01 10:00:00',
        'end'     => '2024-06-01 11:00:00',
    ]]);
    $output = strval($calendar);
    expect($output)->toContain('DTSTART:');
});

test('it throws an exception when summary is missing', function () {
    $calendar = new Calendar();
    $calendar->create([['start' => '20240601T100000Z', 'end' => '20240601T110000Z']]);
})->throws(InvalidArgumentException::class);

test('it throws an exception when start is missing', function () {
    $calendar = new Calendar();
    $calendar->create([['summary' => 'Foo', 'end' => '20240601T110000Z']]);
})->throws(InvalidArgumentException::class);

test('it throws an exception when end is missing', function () {
    $calendar = new Calendar();
    $calendar->create([['summary' => 'Foo', 'start' => '20240601T100000Z']]);
})->throws(InvalidArgumentException::class);

<?php

use Manoar\QrCode\DataTypes\WiFi;

beforeEach(function () {
    $this->wifi = new WiFi();
});

test('it generates a proper format with just the ssid', function () {
    $this->wifi->create([
        ['ssid' => 'foo'],
    ]);
    expect(strval($this->wifi))->toEqual('WIFI:S:foo;');
});

test('it generates a proper format for a ssid that is hidden', function () {
    $this->wifi->create([
        ['ssid' => 'foo', 'hidden' => 'true'],
    ]);
    expect(strval($this->wifi))->toEqual('WIFI:S:foo;H:true;');
});

test('it generates a proper format for a ssid encryption and password', function () {
    $this->wifi->create([
        ['ssid' => 'foo', 'encryption' => 'WPA', 'password' => 'bar'],
    ]);
    expect(strval($this->wifi))->toEqual('WIFI:T:WPA;S:foo;P:bar;');
});

test('it generates a proper format for a ssid encryption password and is hidden', function () {
    $this->wifi->create([
        ['ssid' => 'foo', 'encryption' => 'WPA', 'password' => 'bar', 'hidden' => 'true'],
    ]);
    expect(strval($this->wifi))->toEqual('WIFI:T:WPA;S:foo;P:bar;H:true;');
});

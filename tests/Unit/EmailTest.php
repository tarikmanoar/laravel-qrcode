<?php

use Manoar\QrCode\DataTypes\Email;

beforeEach(function () {
    $this->email = new Email();
});

test('it generates the proper format when only an email address is supplied', function () {
    $this->email->create(['foo@bar.com']);
    expect(strval($this->email))->toEqual('mailto:foo@bar.com');
});

test('it generates the proper format when an email subject and body are supplied', function () {
    $this->email->create(['foo@bar.com', 'foo', 'bar']);
    expect(strval($this->email))->toEqual('mailto:foo@bar.com?subject=foo&body=bar');
});

test('it generates the proper format when an email and subject are supplied', function () {
    $this->email->create(['foo@bar.com', 'foo']);
    expect(strval($this->email))->toEqual('mailto:foo@bar.com?subject=foo');
});

test('it generates the proper format when only a subject is provided', function () {
    $this->email->create([null, 'foo']);
    expect(strval($this->email))->toEqual('mailto:?subject=foo');
});

test('it throws an exception when an invalid email is given', function () {
    $this->email->create(['foo']);
})->throws(InvalidArgumentException::class);

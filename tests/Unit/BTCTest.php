<?php

use Manoar\QrCode\DataTypes\BTC;

beforeEach(function () {
    $this->btc = new BTC();
});

test('it generates a valid btc qrcode with an address and amount', function () {
    $this->btc->create(['btcaddress', 0.0034]);
    expect(strval($this->btc))->toEqual('bitcoin:btcaddress?amount=0.0034');
});

test('it generates a valid btc qrcode with an address, amount and label', function () {
    $this->btc->create(['btcaddress', 0.0034, ['label' => 'label']]);
    expect(strval($this->btc))->toEqual('bitcoin:btcaddress?amount=0.0034&label=label');
});

test('it generates a valid btc qrcode with address, amount, label, message and return address', function () {
    $this->btc->create([
        'btcaddress',
        0.0034,
        [
            'label' => 'label',
            'message' => 'message',
            'returnAddress' => 'https://www.returnaddress.com',
        ],
    ]);
    $expected = 'bitcoin:btcaddress?amount=0.0034&label=label&message=message&r=' . urlencode('https://www.returnaddress.com');
    expect(strval($this->btc))->toEqual($expected);
});

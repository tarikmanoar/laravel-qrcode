<?php

use Manoar\QrCode\DataTypes\Geo;

test('it generates the proper format for a geo coordinate', function () {
    $geo = new Geo();
    $geo->create([10.254, -30.254]);

    expect(strval($geo))->toEqual('geo:10.254,-30.254');
});

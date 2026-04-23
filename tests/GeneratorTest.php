<?php

use Manoar\QrCode\Generator;
use BaconQrCode\Renderer\Eye\SimpleCircleEye;
use BaconQrCode\Renderer\Eye\SquareEye;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Module\DotsModule;
use BaconQrCode\Renderer\Module\RoundnessModule;
use BaconQrCode\Renderer\Module\SquareModule;
use BaconQrCode\Renderer\RendererStyle\Gradient;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

beforeEach(function () {
    $this->generator = new Generator();
});

test('chaining is possible', function () {
    expect($this->generator->size(100))->toBeInstanceOf(Generator::class)
        ->and($this->generator->format('eps'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->color(255, 255, 255))->toBeInstanceOf(Generator::class)
        ->and($this->generator->backgroundColor(255, 255, 255))->toBeInstanceOf(Generator::class)
        ->and($this->generator->eyeColor(0, 255, 255, 255, 0, 0, 0))->toBeInstanceOf(Generator::class)
        ->and($this->generator->gradient(255, 255, 255, 0, 0, 0, 'vertical'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->eye('circle'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->style('round'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->encoding('UTF-8'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->errorCorrection('H'))->toBeInstanceOf(Generator::class)
        ->and($this->generator->margin(2))->toBeInstanceOf(Generator::class);
});

test('size is passed to the renderer', function () {
    $gen = $this->generator->size(100);
    expect($gen->getRendererStyle()->getSize())->toEqual(100);
});

test('format sets the image format', function () {
    $svg = $this->generator->format('svg');
    expect($svg->getFormatter())->toBeInstanceOf(SvgImageBackEnd::class);

    $eps = $this->generator->format('eps');
    expect($eps->getFormatter())->toBeInstanceOf(EpsImageBackEnd::class);
});

test('an exception is thrown if an unsupported format is used', function () {
    $this->generator->format('foo');
})->throws(InvalidArgumentException::class);

test('color is set', function () {
    $gen = $this->generator->color(50, 75, 100);
    $fg = $gen->getFill()->getForegroundColor()->toRgb();
    expect($fg->getRed())->toEqual(50)
        ->and($fg->getGreen())->toEqual(75)
        ->and($fg->getBlue())->toEqual(100);

    $genAlpha = $this->generator->color(50, 75, 100, 25);
    $fgA = $genAlpha->getFill()->getForegroundColor();
    expect($fgA->getAlpha())->toEqual(25)
        ->and($fgA->toRgb()->getRed())->toEqual(50)
        ->and($fgA->toRgb()->getGreen())->toEqual(75)
        ->and($fgA->toRgb()->getBlue())->toEqual(100);
});

test('background color is set', function () {
    $gen = $this->generator->backgroundColor(50, 75, 100);
    $bg = $gen->getFill()->getBackgroundColor()->toRgb();
    expect($bg->getRed())->toEqual(50)
        ->and($bg->getGreen())->toEqual(75)
        ->and($bg->getBlue())->toEqual(100);

    $genAlpha = $this->generator->backgroundColor(50, 75, 100, 25);
    $bgA = $genAlpha->getFill()->getBackgroundColor();
    expect($bgA->getAlpha())->toEqual(25)
        ->and($bgA->toRgb()->getRed())->toEqual(50)
        ->and($bgA->toRgb()->getGreen())->toEqual(75)
        ->and($bgA->toRgb()->getBlue())->toEqual(100);
});

test('eye color is set', function () {
    $this->generator->eyeColor(0, 0, 0, 0, 255, 255, 255)
        ->eyeColor(1, 0, 0, 0, 255, 255, 255)
        ->eyeColor(2, 0, 0, 0, 255, 255, 255);

    $fill = $this->generator->getFill();
    expect($fill->getTopLeftEyeFill()->getExternalColor()->getRed())->toEqual(0)
        ->and($fill->getTopLeftEyeFill()->getInternalColor()->getRed())->toEqual(255);
});

test('eye color throws exception for invalid index', function () {
    $this->generator->eyeColor(3, 0, 0, 0, 255, 255, 255);
})->throws(InvalidArgumentException::class);

test('gradient is set', function () {
    $gen = $this->generator->gradient(0, 0, 0, 255, 255, 255, 'vertical');
    expect($gen->getFill()->getForegroundGradient())->toBeInstanceOf(Gradient::class);
});

test('eye style is set', function () {
    expect($this->generator->eye('circle')->getEye())->toBeInstanceOf(SimpleCircleEye::class)
        ->and($this->generator->eye('square')->getEye())->toBeInstanceOf(SquareEye::class);
});

test('invalid eye throws an exception', function () {
    $this->generator->eye('foo');
})->throws(InvalidArgumentException::class);

test('style is set', function () {
    expect($this->generator->style('square')->getModule())->toBeInstanceOf(SquareModule::class)
        ->and($this->generator->style('dot', .1)->getModule())->toBeInstanceOf(DotsModule::class)
        ->and($this->generator->style('round', .3)->getModule())->toBeInstanceOf(RoundnessModule::class);
});

test('invalid style throws exception', function () {
    $this->generator->style('foo');
})->throws(InvalidArgumentException::class);

test('an exception is thrown for a number over 1', function () {
    $this->generator->style('round', 1.1);
})->throws(InvalidArgumentException::class);

test('an exception is thrown for a number under 0', function () {
    $this->generator->style('round', -.1);
})->throws(InvalidArgumentException::class);

test('an exception is thrown for 1', function () {
    $this->generator->style('round', 1);
})->throws(InvalidArgumentException::class);

test('get renderer returns renderer', function () {
    expect($this->generator->getRendererStyle())->toBeInstanceOf(RendererStyle::class);
});

test('it calls a valid dynamic method and generates a qrcode', function () {
    $result = $this->generator->btc('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa');
    expect($result)->toBeInstanceOf(\Illuminate\Support\HtmlString::class);
    $html = $result->toHtml();
    expect($html)->toContain('<svg')
        ->and($html)->toContain('</svg>');
});

test('it throws an exception if datatype is not found', function () {
    $this->generator->notReal('fooBar');
})->throws(BadMethodCallException::class);

test('generator can return illuminate support htmlstring', function () {
    $this->getMockBuilder(\Illuminate\Support\HtmlString::class)->getMock();
    expect($this->generator->generate('fooBar'))->toBeInstanceOf(\Illuminate\Support\HtmlString::class);
});

test('colorHex sets the foreground color from a hex string', function () {
    $gen = $this->generator->colorHex('#FF0000');
    $fg = $gen->getFill()->getForegroundColor()->toRgb();
    expect($fg->getRed())->toEqual(255)
        ->and($fg->getGreen())->toEqual(0)
        ->and($fg->getBlue())->toEqual(0);
});

test('colorHex accepts shorthand hex notation', function () {
    $gen = $this->generator->colorHex('#FFF');
    $fg = $gen->getFill()->getForegroundColor()->toRgb();
    expect($fg->getRed())->toEqual(255)
        ->and($fg->getGreen())->toEqual(255)
        ->and($fg->getBlue())->toEqual(255);
});

test('colorHex throws an exception for an invalid hex string', function () {
    $this->generator->colorHex('#ZZZZZZ');
})->throws(InvalidArgumentException::class);

test('backgroundColorHex sets the background color from a hex string', function () {
    $gen = $this->generator->backgroundColorHex('#0000FF');
    $bg = $gen->getFill()->getBackgroundColor()->toRgb();
    expect($bg->getRed())->toEqual(0)
        ->and($bg->getGreen())->toEqual(0)
        ->and($bg->getBlue())->toEqual(255);
});

test('eyeColorHex sets eye color from hex strings', function () {
    $this->generator->eyeColorHex(0, '#FF0000', '#0000FF');
    $fill = $this->generator->getFill();
    expect($fill->getTopLeftEyeFill()->getExternalColor()->toRgb()->getRed())->toEqual(255)
        ->and($fill->getTopLeftEyeFill()->getInternalColor()->toRgb()->getBlue())->toEqual(255);
});

test('eyeColorHex throws an exception for an invalid eye index', function () {
    $this->generator->eyeColorHex(3, '#FF0000');
})->throws(InvalidArgumentException::class);

test('generateBase64 returns a base64 string', function () {
    $result = $this->generator->generateBase64('hello');
    expect(base64_decode($result, true))->not->toBeFalse();
});

test('generateDataUri returns a data uri string', function () {
    $result = $this->generator->generateDataUri('hello');
    expect($result)->toStartWith('data:image/svg+xml;base64,');
});

test('generateDataUri returns correct mime for eps format', function () {
    $result = $this->generator->format('eps')->generateDataUri('hello');
    expect($result)->toStartWith('data:application/postscript;base64,');
});

test('reset restores the generator to its default state', function () {
    $this->generator
        ->size(500)
        ->format('eps')
        ->margin(10)
        ->colorHex('#FF0000');

    $this->generator->reset();

    expect($this->generator->getRendererStyle()->getSize())->toEqual(100)
        ->and($this->generator->getFormatter())->toBeInstanceOf(\BaconQrCode\Renderer\Image\SvgImageBackEnd::class);
});


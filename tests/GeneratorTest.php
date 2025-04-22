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
    expect($result)->toEqual("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"100\" height=\"100\" viewBox=\"0 0 100 100\"><rect x=\"0\" y=\"0\" width=\"100\" height=\"100\" fill=\"#ffffff\"/><g transform=\"scale(3.448)\"><g transform=\"translate(0,0)\"><path fill-rule=\"evenodd\" d=\"M8 0L8 1L10 1L10 0ZM15 0L15 1L16 1L16 2L15 2L15 3L14 3L14 2L11 2L11 4L10 4L10 3L9 3L9 2L8 2L8 5L9 5L9 6L8 6L8 7L9 7L9 8L8 8L8 10L6 10L6 9L7 9L7 8L6 8L6 9L5 9L5 10L6 10L6 11L7 11L7 12L6 12L6 13L7 13L7 14L6 14L6 15L5 15L5 14L4 14L4 13L5 13L5 12L4 12L4 13L3 13L3 11L4 11L4 10L3 10L3 9L4 9L4 8L0 8L0 11L1 11L1 12L0 12L0 14L2 14L2 15L1 15L1 16L2 16L2 17L1 17L1 18L0 18L0 19L1 19L1 18L2 18L2 19L3 19L3 20L5 20L5 16L6 16L6 17L7 17L7 18L6 18L6 19L7 19L7 20L6 20L6 21L8 21L8 22L9 22L9 21L10 21L10 23L13 23L13 24L12 24L12 25L11 25L11 24L10 24L10 27L9 27L9 25L8 25L8 29L9 29L9 28L10 28L10 29L11 29L11 28L12 28L12 26L14 26L14 29L16 29L16 28L17 28L17 29L19 29L19 28L20 28L20 29L21 29L21 28L22 28L22 27L23 27L23 29L24 29L24 28L25 28L25 29L26 29L26 28L25 28L25 27L27 27L27 29L28 29L28 27L29 27L29 24L28 24L28 22L29 22L29 19L28 19L28 21L27 21L27 19L26 19L26 18L27 18L27 17L25 17L25 16L26 16L26 15L29 15L29 13L27 13L27 12L26 12L26 13L25 13L25 14L26 14L26 15L24 15L24 14L23 14L23 13L24 13L24 12L25 12L25 11L26 11L26 10L25 10L25 9L27 9L27 11L28 11L28 12L29 12L29 11L28 11L28 10L29 10L29 8L28 8L28 9L27 9L27 8L24 8L24 9L23 9L23 11L22 11L22 12L21 12L21 11L19 11L19 10L21 10L21 9L22 9L22 8L21 8L21 9L20 9L20 7L21 7L21 6L20 6L20 2L19 2L19 5L18 5L18 4L17 4L17 3L16 3L16 2L17 2L17 0ZM19 0L19 1L20 1L20 0ZM12 3L12 5L10 5L10 6L9 6L9 7L10 7L10 8L9 8L9 9L10 9L10 10L8 10L8 12L7 12L7 13L9 13L9 12L10 12L10 13L11 13L11 11L13 11L13 10L14 10L14 12L15 12L15 13L20 13L20 14L21 14L21 16L22 16L22 17L21 17L21 19L22 19L22 20L23 20L23 18L25 18L25 17L24 17L24 15L22 15L22 14L21 14L21 12L18 12L18 11L16 11L16 9L18 9L18 8L19 8L19 7L20 7L20 6L19 6L19 7L18 7L18 5L17 5L17 4L16 4L16 5L14 5L14 6L13 6L13 7L12 7L12 5L13 5L13 3ZM16 5L16 7L15 7L15 6L14 6L14 7L15 7L15 8L14 8L14 10L15 10L15 8L18 8L18 7L17 7L17 5ZM10 6L10 7L11 7L11 8L12 8L12 7L11 7L11 6ZM23 11L23 12L22 12L22 13L23 13L23 12L24 12L24 11ZM1 12L1 13L2 13L2 14L3 14L3 13L2 13L2 12ZM12 12L12 14L8 14L8 15L6 15L6 16L8 16L8 18L7 18L7 19L8 19L8 21L9 21L9 20L10 20L10 21L11 21L11 22L12 22L12 21L11 21L11 20L12 20L12 19L11 19L11 18L12 18L12 17L13 17L13 18L17 18L17 19L16 19L16 20L15 20L15 21L14 21L14 19L13 19L13 23L14 23L14 22L15 22L15 24L14 24L14 26L15 26L15 27L16 27L16 26L17 26L17 28L18 28L18 26L17 26L17 25L20 25L20 22L19 22L19 23L18 23L18 21L17 21L17 19L18 19L18 20L20 20L20 18L18 18L18 17L17 17L17 16L18 16L18 15L19 15L19 14L17 14L17 16L16 16L16 17L15 17L15 15L16 15L16 14L15 14L15 15L14 15L14 13L13 13L13 12ZM26 13L26 14L27 14L27 13ZM12 14L12 16L11 16L11 15L9 15L9 18L8 18L8 19L9 19L9 18L10 18L10 17L12 17L12 16L13 16L13 14ZM3 15L3 17L2 17L2 18L3 18L3 17L4 17L4 15ZM19 16L19 17L20 17L20 16ZM28 16L28 17L29 17L29 16ZM24 19L24 20L25 20L25 19ZM1 20L1 21L2 21L2 20ZM15 21L15 22L16 22L16 23L17 23L17 21ZM21 21L21 24L24 24L24 21ZM22 22L22 23L23 23L23 22ZM25 22L25 23L26 23L26 24L27 24L27 22ZM15 24L15 26L16 26L16 25L17 25L17 24ZM22 25L22 26L23 26L23 25ZM24 25L24 27L25 27L25 26L27 26L27 27L28 27L28 25ZM19 26L19 27L21 27L21 26ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM22 0L22 7L29 7L29 0ZM23 1L23 6L28 6L28 1ZM24 2L24 5L27 5L27 2ZM0 22L0 29L7 29L7 22ZM1 23L1 28L6 28L6 23ZM2 24L2 27L5 27L5 24Z\" fill=\"#000000\"/></g></g></svg>\n");
});

test('it throws an exception if datatype is not found', function () {
    $this->generator->notReal('fooBar');
})->throws(BadMethodCallException::class);

test('generator can return illuminate support htmlstring', function () {
    $this->getMockBuilder(\Illuminate\Support\HtmlString::class)->getMock();
    expect($this->generator->generate('fooBar'))->toBeInstanceOf(\Illuminate\Support\HtmlString::class);
});

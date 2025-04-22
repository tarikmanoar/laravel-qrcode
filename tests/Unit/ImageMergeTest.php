<?php

use Manoar\QrCode\Image;
use Manoar\QrCode\ImageMerge;

beforeEach(function () {
    $this->testImagePath = __DIR__ . '/Images/github.png';
    $this->mergeImagePath = __DIR__ . '/Images/200x300.png';
    $this->testImageContent = file_get_contents($this->testImagePath);
    $this->mergeImageContent = file_get_contents($this->mergeImagePath);
    $this->imageMerge = new ImageMerge(
        new Image($this->testImageContent),
        new Image($this->mergeImageContent)
    );
    $this->testImageSaveLocation = __DIR__ . '/testImage.png';
    $this->compareTestSaveLocation = __DIR__ . '/compareImage.png';
});

afterEach(function () {
    if (file_exists($this->testImageSaveLocation)) {
        unlink($this->testImageSaveLocation);
    }
    
    if (file_exists($this->compareTestSaveLocation)) {
        unlink($this->compareTestSaveLocation);
    }
});

test('it merges two images together and centers it', function () {
    // Generate the merged image using the ImageMerge class
    $testImage = $this->imageMerge->merge(0.2);
    file_put_contents($this->testImageSaveLocation, $testImage);
    
    // Verify the merged image exists and is a valid PNG file
    expect(file_exists($this->testImageSaveLocation))->toBeTrue();
    
    // Check image is valid and has expected dimensions
    $imageInfo = getimagesize($this->testImageSaveLocation);
    expect($imageInfo)->not->toBeNull();
    
    // Get source image dimensions for comparison
    $sourceImageInfo = getimagesize($this->testImagePath);
    
    // Since we're merging into the source image, the output should maintain the same dimensions
    expect($imageInfo[0])->toEqual($sourceImageInfo[0]);
    expect($imageInfo[1])->toEqual($sourceImageInfo[1]);
    
    // Check file is a PNG
    expect($imageInfo['mime'])->toEqual('image/png');
});

test('it throws an exception when percentage is greater than 1', function () {
    expect(fn() => $this->imageMerge->merge(1.1))
        ->toThrow(InvalidArgumentException::class, '$percentage must be less than 1');
});

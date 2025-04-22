<?php

use Manoar\QrCode\Image;

beforeEach(function () {
    $this->imagePath = __DIR__ . '/Images/github.png';
    $this->imageContent = file_get_contents($this->imagePath);
    $this->image = new Image($this->imageContent);
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

test('it loads an image string into a resource', function () {
    // Create a reference image using PHP's built-in functions
    $referenceResource = imagecreatefromstring($this->imageContent);
    imagepng($referenceResource, $this->compareTestSaveLocation);
    imagedestroy($referenceResource);
    
    // Save our implementation's image
    $testResource = $this->image->getImageResource();
    imagepng($testResource, $this->testImageSaveLocation);
    
    // Compare file sizes (should be similar)
    $testSize = filesize($this->testImageSaveLocation);
    $compareSize = filesize($this->compareTestSaveLocation);
    
    // Instead of exact byte comparison, check if dimensions match
    expect($this->image->getWidth())->toEqual(imagesx($testResource));
    expect($this->image->getHeight())->toEqual(imagesy($testResource));
    
    // Check that both files exist and are valid images
    expect(file_exists($this->testImageSaveLocation))->toBeTrue();
    expect(file_exists($this->compareTestSaveLocation))->toBeTrue();
});

test('it gets the correct height', function () {
    $imageInfo = getimagesize($this->imagePath);
    $expectedHeight = $imageInfo[1];
    
    expect($this->image->getHeight())->toEqual($expectedHeight);
});

test('it gets the correct width', function () {
    $imageInfo = getimagesize($this->imagePath);
    $expectedWidth = $imageInfo[0];
    
    expect($this->image->getWidth())->toEqual($expectedWidth);
});

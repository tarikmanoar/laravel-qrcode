<?php

use Tests\TestCase;

// Feature tests will use Laravel's base TestCase
uses(TestCase::class)->in('tests/Feature');

// All other tests (unit, data types, image, generator) can run without Laravel context
uses()->in([
    'tests/Unit',
    'tests/DataTypes',
    'tests/ImageTest.php',
    'tests/ImageMergeTest.php',
    'tests/GeneratorTest.php',
]);
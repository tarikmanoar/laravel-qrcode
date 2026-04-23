[![Tests](https://github.com/tarikmanoar/laravel-qrcode/actions/workflows/run-tests.yml/badge.svg)](https://github.com/tarikmanoar/laravel-qrcode/actions) [![Latest Stable Version](https://poser.pugx.org/tarikmanoar/laravel-qrcode/v/stable.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode) [![License](https://poser.pugx.org/tarikmanoar/laravel-qrcode/license.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode) [![Total Downloads](https://poser.pugx.org/tarikmanoar/laravel-qrcode/downloads.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode)

### [Bangla](https://tarikmanoar.github.io/laravel-qrcode/docs/bn) | [Deutsch](https://tarikmanoar.github.io/laravel-qrcode/docs/de) | [Español](https://tarikmanoar.github.io/laravel-qrcode/docs/es) | [Français](https://tarikmanoar.github.io/laravel-qrcode/docs/fr) | [Italiano](https://tarikmanoar.github.io/laravel-qrcode/docs/it) | [Português](https://tarikmanoar.github.io/laravel-qrcode/docs/pt-br) | [Русский](https://tarikmanoar.github.io/laravel-qrcode/docs/ru) | [日本語](https://tarikmanoar.github.io/laravel-qrcode/docs/ja) | [한국어](https://tarikmanoar.github.io/laravel-qrcode/docs/kr) | [हिंदी](https://tarikmanoar.github.io/laravel-qrcode/docs/hi) | [简体中文](https://tarikmanoar.github.io/laravel-qrcode/docs/zh-cn) | [العربية](https://tarikmanoar.github.io/laravel-qrcode/docs/ar)

<a id="docs-introduction"></a>

## Introduction

Laravel QrCode is an easy to use wrapper for the popular Laravel framework based on the great work provided by [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode). We created an interface that is familiar and easy to install for Laravel users.

**Compatible with Laravel 8 – 13 and PHP 8.0 – 8.5.**

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Upgrade Guide](#upgrade-guide)
- [Simple Ideas](#simple-ideas)
- [Usage](#usage)
  - [generate](#generate)
  - [format](#format)
  - [size](#size)
  - [color / colorHex](#color)
  - [backgroundColor / backgroundColorHex](#backgroundcolor)
  - [eyeColor / eyeColorHex](#eyecolor)
  - [gradient](#gradient)
  - [style](#style)
  - [eye](#eye-style)
  - [margin](#margin)
  - [errorCorrection](#error-correction)
  - [encoding](#encoding)
  - [merge / mergeString](#merge)
  - [generateBase64 / generateDataUri](#base64--data-uri-output)
  - [reset](#reset)
- [Helpers (Data Types)](#helpers)
  - [BitCoin](#bitcoin)
  - [E-Mail](#e-mail)
  - [Geo](#geo)
  - [Phone Number](#phone-number)
  - [SMS](#sms-text-messages)
  - [WiFi](#wifi)
  - [VCard](#vcard)
  - [MeCard](#mecard)
  - [Calendar](#calendar)
  - [WhatsApp](#whatsapp)
  - [OTP (2FA)](#otp-2fa)
- [Common QrCode Usage](#common-qrcode-usage)
- [Usage Outside of Laravel](#usage-outside-of-laravel)

---

## Installation

Run the following command to install the package via Composer:

```bash
composer require tarikmanoar/laravel-qrcode
```

The service provider and facade are auto-discovered by Laravel. Optionally publish the config file:

```bash
php artisan vendor:publish --provider="Manoar\QrCode\QrCodeServiceProvider" --tag=config
```

---

## Configuration

The config file `config/laravel-qrcode.php` defines defaults for `format`, `size`, `margin`, `error_correction`, and `encoding`. Override any of them in your `.env` file:

```
QRCODE_FORMAT=svg
QRCODE_SIZE=100
QRCODE_MARGIN=0
QRCODE_ERROR_CORRECTION=M
QRCODE_ENCODING=UTF-8
```

---

<a id="upgrade-guide"></a>
## Upgrade Guide

Upgrade from v2 or v3 by changing your `composer.json` requirement to `~4`.

You **must** install the `imagick` PHP extension if you plan to use the `png` image format.

#### v4

> The `generate` method now returns an instance of `Illuminate\Support\HtmlString` when running inside Laravel. See [#205](https://github.com/tarikmanoar/laravel-qrcode/issues/205) for more information.

All references to the `QrCode` facade need to be updated to:

```php
use Manoar\QrCode\Facades\QrCode;
```

---

<a id="simple-ideas"></a>
## Simple Ideas

#### Print View

Add QrCodes to your print views so customers can return to the original page after printing:

```html
<div class="visible-print text-center">
    {!! QrCode::size(100)->generate(Request::url()) !!}
    <p>Scan me to return to the original page.</p>
</div>
```

#### Embed a QrCode in an Email

```html
{{-- Inside a Blade template --}}
<img src="{!! $message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png') !!}">
```

#### Inline Data URI (no file save needed)

```html
<img src="{{ QrCode::generateDataUri('https://example.com') }}">
```

---

<a id="usage"></a>
## Usage

All examples assume you have imported the facade:

```php
use Manoar\QrCode\Facades\QrCode;
```

All methods support **chaining**. `generate()` must always be called last.

---

### generate

`generate(string $text, string $filename = null)`

Generates the QrCode. Returns an `Illuminate\Support\HtmlString` inside Laravel (safe for `{!! !!}` output) or a plain string outside Laravel.

```php
// Render SVG directly in a Blade view
{!! QrCode::generate('Make me into a QrCode!') !!}

// Save to file
QrCode::generate('Save this!', storage_path('app/qrcode.svg'));
```

---

### format

`format(string $format)`

Supported formats: `svg` (default), `eps`, `png`.

```php
QrCode::format('png')->generate('Hello!');
QrCode::format('eps')->generate('Hello!');
QrCode::format('svg')->generate('Hello!');
```

> `imagick` PHP extension is required for `png` output.

---

### size

`size(int $pixels)`

```php
QrCode::size(200)->generate('Hello!');
```

---

<a id="color"></a>
### color

`color(int $red, int $green, int $blue, int $alpha = null)`

Change the foreground (module) color of the QrCode. All values are 0–255.

```php
QrCode::color(255, 0, 0)->generate('Red QrCode');
QrCode::color(255, 0, 0, 25)->generate('Red with 25% transparency');
```

> Be careful — some readers struggle with colored QrCodes.

#### colorHex *(new)*

`colorHex(string $hex)`

Shorthand for `color()` using a CSS hex string. Supports both `#RRGGBB` and `#RGB` notation.

```php
QrCode::colorHex('#FF0000')->generate('Red QrCode');
QrCode::colorHex('#f00')->generate('Also red');
```

---

<a id="backgroundcolor"></a>
### backgroundColor

`backgroundColor(int $red, int $green, int $blue, int $alpha = null)`

```php
QrCode::backgroundColor(255, 255, 0)->generate('Yellow background');
```

#### backgroundColorHex *(new)*

`backgroundColorHex(string $hex)`

```php
QrCode::backgroundColorHex('#FFFF00')->generate('Yellow background');
```

---

<a id="eyecolor"></a>
### eyeColor

`eyeColor(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outerRed = 0, int $outerGreen = 0, int $outerBlue = 0)`

Change the color of one of the three finder-pattern eyes (0, 1, 2).

```php
QrCode::eyeColor(0, 255, 0, 0, 0, 0, 255)->generate('Custom eye 0');
```

| Eye Number | Position |
| --- | --- |
| `0` | Top-left |
| `1` | Top-right |
| `2` | Bottom-left |

#### eyeColorHex *(new)*

`eyeColorHex(int $eyeNumber, string $innerHex, string $outerHex = '#000000')`

```php
QrCode::eyeColorHex(0, '#FF0000', '#0000FF')->generate('Custom eye 0 via hex');
```

---

### gradient

`gradient(int $startRed, int $startGreen, int $startBlue, int $endRed, int $endGreen, int $endBlue, string $type)`

Apply a color gradient to the QrCode modules.

```php
QrCode::gradient(0, 0, 255, 0, 255, 0, 'vertical')->generate('Gradient');
```

Supported gradient types:

| Type | Description |
| --- | --- |
| `vertical` | Top to bottom |
| `horizontal` | Left to right |
| `diagonal` | Top-left to bottom-right |
| `inverse_diagonal` | Top-right to bottom-left |
| `radial` | Center outward |

---

### style

`style(string $style, float $size = 0.5)`

Change the appearance of the QrCode modules.

```php
QrCode::style('dot')->generate('Dot style');
QrCode::style('round', 0.4)->generate('Rounded style');
```

| Style | Description |
| --- | --- |
| `square` | Default square modules |
| `dot` | Circular dots |
| `round` | Rounded squares |

---

### eye style

`eye(string $style)`

Change the finder-pattern eye style.

```php
QrCode::eye('circle')->generate('Circle eyes');
```

Supported: `square`, `circle`.

---

### margin

`margin(int $margin)`

```php
QrCode::margin(10)->generate('With margin');
```

---

### error correction

`errorCorrection(string $level)`

```php
QrCode::errorCorrection('H')->generate('High correction');
```

| Level | Data Recovery |
| --- | --- |
| `L` | ~7% |
| `M` | ~15% (default) |
| `Q` | ~25% |
| `H` | ~30% |

> Higher correction = larger QrCode, less data capacity.

---

### encoding

`encoding(string $encoding)`

Default: `ISO-8859-1`. Use `UTF-8` for non-Latin characters.

```php
QrCode::encoding('UTF-8')->generate('Special symbols ♠♥!!');
```

Supported encodings: `ISO-8859-1` through `ISO-8859-16`, `SHIFT-JIS`, `WINDOWS-1250` through `WINDOWS-1256`, `UTF-16BE`, `UTF-8`, `ASCII`, `GBK`, `EUC-KR`.

---

### merge

`merge(string $filepath, float $percentage = .2, bool $absolute = false)`

Overlay a PNG image (e.g. a logo) on top of the QrCode.

```php
// Relative to app base path
QrCode::format('png')->merge('/images/logo.png')->generate('With logo');

// 30% of QrCode size
QrCode::format('png')->merge('/images/logo.png', .3)->generate('With logo');

// Absolute path
QrCode::format('png')->merge('/absolute/path/logo.png', .3, true)->generate('With logo');
```

#### mergeString

`mergeString(string $content, float $percentage = .2)`

Same as `merge()` but accepts raw binary content (useful with the `Storage` facade).

```php
QrCode::format('png')->mergeString(Storage::get('images/logo.png'))->generate('With logo');
```

> Only PNG is supported for merge. Use `errorCorrection('H')` to keep the QrCode scannable.

---

<a id="base64--data-uri-output"></a>
### generateBase64 *(new)*

`generateBase64(string $text): string`

Returns the QrCode as a base64-encoded string.

```php
$b64 = QrCode::generateBase64('https://example.com');
// → "PHN2ZyB4bWxucz0i..."
```

### generateDataUri *(new)*

`generateDataUri(string $text): string`

Returns the QrCode as a complete `data:` URI, ready for use in an `<img>` tag without saving a file.

```php
// SVG (default)
<img src="{{ QrCode::generateDataUri('https://example.com') }}">

// PNG
<img src="{{ QrCode::format('png')->generateDataUri('https://example.com') }}">
```

---

### reset *(new)*

`reset(): self`

Resets all generator settings to their defaults. Useful when the `Generator` instance is reused across multiple QrCodes.

```php
$qr = new \Manoar\QrCode\Generator();
$qr->size(300)->colorHex('#FF0000')->generate('First');
$qr->reset()->generate('Back to defaults');
```

---

<a id="helpers"></a>
## Helpers (Data Types)

Helpers are magic methods that format the QrCode data string for you. They cause a reader to perform a specific action when scanned.

---

### BitCoin

```php
QrCode::BTC($address, $amount);

// Send 0.334 BTC
QrCode::BTC('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', 0.334);

// With optional metadata
QrCode::size(500)->BTC('1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', 0.0034, [
    'label'         => 'My Donation',
    'message'       => 'Thank you!',
    'returnAddress' => 'https://www.example.com/callback',
]);
```

---

### E-Mail

```php
QrCode::email($to, $subject, $body);

QrCode::email('foo@bar.com');
QrCode::email('foo@bar.com', 'Subject here', 'Body here');
QrCode::email(null, 'Just the subject', 'And body');
```

---

### Geo

Opens a map application with the specified coordinates.

```php
QrCode::geo($latitude, $longitude);
QrCode::geo(37.822214, -122.481769);
```

---

### Phone Number

Dials the specified phone number.

```php
QrCode::phoneNumber($phoneNumber);
QrCode::phoneNumber('555-555-5555');
```

---

### SMS (Text Messages)

```php
QrCode::SMS($phoneNumber, $message);

QrCode::SMS('555-555-5555');
QrCode::SMS('555-555-5555', 'Pre-filled body');
```

---

### WiFi

Connect to a WiFi network by scanning.

```php
QrCode::wiFi([
    'encryption' => 'WPA',   // WPA, WEP, or omit for open
    'ssid'       => 'MyNetwork',
    'password'   => 'secret',
    'hidden'     => 'true',  // optional
]);

// Open network
QrCode::wiFi(['ssid' => 'OpenNet']);

// WPA network
QrCode::wiFi(['ssid' => 'MyNet', 'encryption' => 'WPA', 'password' => 'pass']);
```

> WiFi scanning is not supported on Apple devices.

---

### VCard *(new)*

Generate a vCard 3.0 contact card that adds a contact to the device address book when scanned.

```php
QrCode::vCard([
    'first_name' => 'Jane',
    'last_name'  => 'Doe',
    'phone'      => '+1234567890',
    'email'      => 'jane@example.com',
    'company'    => 'Acme Corp',
    'title'      => 'Engineer',
    'address'    => '123 Main St, Springfield',
    'url'        => 'https://example.com',
    'note'       => 'Met at conference',
]);

// Shorthand using full name
QrCode::vCard(['name' => 'John Smith', 'phone' => '+9876543210']);
```

Supported keys: `first_name`, `last_name`, `name` (splits on first space), `phone`, `email`, `company`, `title`, `address`, `url`, `note`.

---

### MeCard *(new)*

Generate a MeCard contact (simpler format, wide Android/iOS scanner support).

```php
QrCode::meCard([
    'first_name' => 'Jane',
    'last_name'  => 'Doe',
    'phone'      => '+1234567890',
    'email'      => 'jane@example.com',
    'address'    => '123 Main St',
    'url'        => 'https://example.com',
    'birthday'   => '19900101',   // YYYYMMDD
    'note'       => 'Hello!',
]);
```

Supported keys: `first_name`, `last_name`, `name`, `phone`, `email`, `address`, `url`, `birthday`, `note`.

---

### Calendar *(new)*

Generate an iCalendar (VCALENDAR/VEVENT) QrCode that adds a calendar event when scanned.

```php
QrCode::calendar([
    'summary'     => 'Team Meeting',
    'start'       => '20240601T100000Z',   // or ISO 8601 string
    'end'         => '20240601T110000Z',
    'location'    => 'Conference Room B',
    'description' => 'Weekly sync',
    'url'         => 'https://meet.example.com/abc',
]);
```

Required keys: `summary`, `start`, `end`. Optional: `location`, `description`, `url`.

Date formats accepted: iCal (`20240101T120000Z`) or any string parseable by PHP's `strtotime()`.

---

### WhatsApp *(new)*

Generate a WhatsApp deep-link QrCode that opens a pre-filled chat when scanned.

```php
QrCode::whatsApp('+1234567890', 'Hello there!');

// Phone only (no pre-filled message)
QrCode::whatsApp('+1234567890');
```

The phone number is normalised automatically (non-numeric characters removed).

---

### OTP (2FA) *(new)*

Generate an `otpauth://` URI for TOTP/HOTP authenticator apps (Google Authenticator, Authy, etc.).

```php
// TOTP (time-based, default)
QrCode::otp([
    'label'     => 'user@example.com',
    'secret'    => 'JBSWY3DPEHPK3PXP',   // Base32-encoded secret
    'issuer'    => 'MyApp',
    'digits'    => 6,                      // default
    'period'    => 30,                     // seconds, default
    'algorithm' => 'SHA1',                 // SHA1, SHA256, or SHA512
]);

// HOTP (counter-based)
QrCode::otp([
    'type'    => 'hotp',
    'label'   => 'user@example.com',
    'secret'  => 'JBSWY3DPEHPK3PXP',
    'issuer'  => 'MyApp',
    'counter' => 0,
]);
```

Required keys: `label`, `secret`. All other keys are optional.

---

<a id="common-qrcode-usage"></a>
## Common QrCode Usage

You can also pass raw-format strings directly to `generate()`:

| Usage | Prefix | Example |
| --- | --- | --- |
| Website URL | `http://` | `http://www.example.com` |
| Secured URL | `https://` | `https://www.example.com` |
| E-mail Address | `mailto:` | `mailto:support@example.com` |
| Phone Number | `tel:` | `tel:555-555-5555` |
| Text (SMS) | `sms:` | `sms:555-555-5555` |
| SMS with message | `sms:` | `sms:555-555-5555&body=Hello` |
| Geo Address | `geo:` | `geo:-78.400364,-85.916993` |
| MeCard | `MECARD:` | `MECARD:N:Doe,John;TEL:555-555-5555;;` |
| VCard | `BEGIN:VCARD` | See [Wikipedia](https://en.wikipedia.org/wiki/VCard) |
| WiFi | `WIFI:` | `WIFI:T:WPA;S:MyNet;P:password;;` |
| OTP | `otpauth://` | `otpauth://totp/user%40app.com?secret=ABC` |

---

<a id="usage-outside-of-laravel"></a>
## Usage Outside of Laravel

You may use this package outside of Laravel by instantiating a `Generator` directly:

```php
use Manoar\QrCode\Generator;

$qr = new Generator();
$qr->size(300)->generate('Hello without Laravel!');

// With all new features
$qr->colorHex('#1a1a2e')
   ->backgroundColorHex('#ffffff')
   ->size(400)
   ->errorCorrection('H')
   ->generateDataUri('https://example.com');
```

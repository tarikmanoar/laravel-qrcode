[![Tests](https://github.com/tarikmanoar/laravel-qrcode/actions/workflows/run-tests.yml/badge.svg)](https://github.com/tarikmanoar/laravel-qrcode/actions) [![Latest Stable Version](https://poser.pugx.org/tarikmanoar/laravel-qrcode/v/stable.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode) [![License](https://poser.pugx.org/tarikmanoar/laravel-qrcode/license.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode) [![Total Downloads](https://poser.pugx.org/tarikmanoar/laravel-qrcode/downloads.svg)](https://packagist.org/packages/tarikmanoar/laravel-qrcode)

#### [English](https://tarikmanoar.github.io/laravel-qrcode/docs/en) | [Deutsch](https://tarikmanoar.github.io/laravel-qrcode/docs/de) | [Español](https://tarikmanoar.github.io/laravel-qrcode/docs/es) | [Français](https://tarikmanoar.github.io/laravel-qrcode/docs/fr) | [Italiano](https://tarikmanoar.github.io/laravel-qrcode/docs/it) | [Português](https://tarikmanoar.github.io/laravel-qrcode/docs/pt-br) | [Русский](https://tarikmanoar.github.io/laravel-qrcode/docs/ru) | [日本語](https://tarikmanoar.github.io/laravel-qrcode/docs/ja) | [한국어](https://tarikmanoar.github.io/laravel-qrcode/docs/kr) | [हिंदी](https://tarikmanoar.github.io/laravel-qrcode/docs/hi) | [简体中文](https://tarikmanoar.github.io/laravel-qrcode/docs/zh-cn) | [العربية](https://tarikmanoar.github.io/laravel-qrcode/docs/ar)

# Laravel QrCode — বাংলা ডকুমেন্টেশন

- [ভূমিকা](#ভূমিকা)
- [ইনস্টলেশন](#ইনস্টলেশন)
- [কনফিগারেশন](#কনফিগারেশন)
- [আপগ্রেড গাইড](#আপগ্রেড-গাইড)
- [সহজ ধারণা](#সহজ-ধারণা)
- [ব্যবহার](#ব্যবহার)
- [হেল্পার (ডেটা টাইপ)](#হেল্পার-ডেটা-টাইপ)
- [প্রিফিক্স ব্যবহার](#প্রিফিক্স-ব্যবহার)
- [Laravel ছাড়া ব্যবহার](#laravel-ছাড়া-ব্যবহার)

---

<a id="ভূমিকা"></a>
## ভূমিকা

Laravel QrCode হলো জনপ্রিয় Laravel ফ্রেমওয়ার্কের জন্য একটি সহজে ব্যবহারযোগ্য র‍্যাপার, যা [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode)-এর উপর ভিত্তি করে তৈরি।

**Laravel 8 – 13 এবং PHP 8.0 – 8.5 সমর্থিত।**

---

<a id="ইনস্টলেশন"></a>
## ইনস্টলেশন

Composer-এর মাধ্যমে প্যাকেজটি ইনস্টল করুন:

```bash
composer require tarikmanoar/laravel-qrcode
```

Service Provider এবং Facade স্বয়ংক্রিয়ভাবে লোড হবে। ঐচ্ছিকভাবে কনফিগ ফাইল পাবলিশ করুন:

```bash
php artisan vendor:publish --provider="Manoar\QrCode\QrCodeServiceProvider" --tag=config
```

---

<a id="কনফিগারেশন"></a>
## কনফিগারেশন

`config/laravel-qrcode.php` ফাইলে ডিফল্ট সেটিং রয়েছে। আপনার `.env` ফাইলে ওভাররাইড করুন:

```
QRCODE_FORMAT=svg
QRCODE_SIZE=100
QRCODE_MARGIN=0
QRCODE_ERROR_CORRECTION=M
QRCODE_ENCODING=UTF-8
```

---

<a id="আপগ্রেড-গাইড"></a>
## আপগ্রেড গাইড

v2 বা v3 থেকে আপগ্রেড করতে `composer.json`-এ `~4` ব্যবহার করুন।

`png` ফরম্যাট ব্যবহার করতে হলে `imagick` PHP এক্সটেনশন ইনস্টল করতে হবে।

`QrCode` Facade-এর সমস্ত রেফারেন্স পরিবর্তন করুন:

```php
use Manoar\QrCode\Facades\QrCode;
```

---

<a id="সহজ-ধারণা"></a>
## সহজ ধারণা

#### প্রিন্ট ভিউ

```html
<div class="visible-print text-center">
    {!! QrCode::size(100)->generate(Request::url()) !!}
    <p>মূল পৃষ্ঠায় ফিরতে স্ক্যান করুন।</p>
</div>
```

#### ইমেইলে QrCode যুক্ত করুন

```html
<img src="{!! $message->embedData(QrCode::format('png')->generate('ইমেইলে যুক্ত করুন!'), 'QrCode.png', 'image/png') !!}">
```

#### ইনলাইন Data URI (ফাইল সংরক্ষণ ছাড়া)

```html
<img src="{{ QrCode::generateDataUri('https://example.com') }}">
```

---

<a id="ব্যবহার"></a>
## ব্যবহার

```php
use Manoar\QrCode\Facades\QrCode;
```

সব মেথড **চেইনযোগ্য**। `generate()` সবসময় শেষে ডাকতে হবে।

### generate

```php
// SVG আউটপুট (ডিফল্ট)
{!! QrCode::generate('আমাকে QrCode বানাও!') !!}

// ফাইলে সংরক্ষণ
QrCode::generate('সেভ করো!', storage_path('app/qrcode.svg'));
```

### format

```php
QrCode::format('png')->generate('PNG ছবি');
QrCode::format('eps')->generate('EPS ছবি');
QrCode::format('svg')->generate('SVG ছবি');
```

> `png` আউটপুটের জন্য `imagick` এক্সটেনশন প্রয়োজন।

### size

```php
QrCode::size(300)->generate('বড় QrCode');
```

### color / colorHex

```php
// RGB
QrCode::color(255, 0, 0)->generate('লাল QrCode');

// Hex রং (নতুন)
QrCode::colorHex('#FF0000')->generate('লাল QrCode (হেক্স)');
QrCode::colorHex('#f00')->generate('সংক্ষিপ্ত হেক্স');
```

### backgroundColor / backgroundColorHex

```php
QrCode::backgroundColor(255, 255, 0)->generate('হলুদ পটভূমি');

// Hex রং (নতুন)
QrCode::backgroundColorHex('#FFFF00')->generate('হলুদ পটভূমি (হেক্স)');
```

### eyeColor / eyeColorHex

```php
// RGB
QrCode::eyeColor(0, 255, 0, 0, 0, 0, 255)->generate('কাস্টম চোখের রং');

// Hex (নতুন)
QrCode::eyeColorHex(0, '#FF0000', '#0000FF')->generate('হেক্স চোখের রং');
```

চোখের নম্বর: `0` = উপর-বাম, `1` = উপর-ডান, `2` = নিচ-বাম।

### gradient

```php
QrCode::gradient(0, 0, 255, 0, 255, 0, 'vertical')->generate('গ্রেডিয়েন্ট');
```

সমর্থিত টাইপ: `vertical`, `horizontal`, `diagonal`, `inverse_diagonal`, `radial`।

### style

```php
QrCode::style('dot')->generate('বিন্দু স্টাইল');
QrCode::style('round', 0.4)->generate('গোলাকার স্টাইল');
```

সমর্থিত স্টাইল: `square` (ডিফল্ট), `dot`, `round`।

### eye

```php
QrCode::eye('circle')->generate('বৃত্তাকার চোখ');
```

সমর্থিত: `square`, `circle`।

### margin

```php
QrCode::margin(10)->generate('মার্জিন সহ');
```

### errorCorrection

```php
QrCode::errorCorrection('H')->generate('উচ্চ সংশোধন');
```

| স্তর | ডেটা পুনরুদ্ধার |
| --- | --- |
| `L` | ~৭% |
| `M` | ~১৫% (ডিফল্ট) |
| `Q` | ~২৫% |
| `H` | ~৩০% |

### encoding

```php
QrCode::encoding('UTF-8')->generate('বিশেষ চিহ্ন ♠♥!!');
```

### merge / mergeString

```php
// লোগো যুক্ত QrCode
QrCode::format('png')->merge('/images/logo.png', .3)->generate('লোগো সহ');

// Storage facade ব্যবহার করে
QrCode::format('png')->mergeString(Storage::get('images/logo.png'))->generate('লোগো সহ');
```

> `merge` শুধুমাত্র PNG সমর্থন করে। `errorCorrection('H')` ব্যবহার করুন।

### generateBase64 *(নতুন)*

QrCode-কে base64 স্ট্রিং হিসেবে ফেরত দেয়।

```php
$b64 = QrCode::generateBase64('https://example.com');
```

### generateDataUri *(নতুন)*

QrCode-কে `data:` URI হিসেবে ফেরত দেয় — ফাইল সংরক্ষণ ছাড়াই `<img>` ট্যাগে ব্যবহারযোগ্য।

```html
<img src="{{ QrCode::generateDataUri('https://example.com') }}">
<img src="{{ QrCode::format('png')->generateDataUri('https://example.com') }}">
```

### reset *(নতুন)*

Generator-কে ডিফল্ট অবস্থায় ফিরিয়ে দেয়।

```php
$qr = new \Manoar\QrCode\Generator();
$qr->size(300)->colorHex('#FF0000')->generate('প্রথম');
$qr->reset()->generate('ডিফল্টে ফিরে');
```

---

<a id="হেল্পার-ডেটা-টাইপ"></a>
## হেল্পার (ডেটা টাইপ)

হেল্পার মেথডগুলো স্বয়ংক্রিয়ভাবে QrCode ডেটা স্ট্রিং তৈরি করে।

### BitCoin

```php
QrCode::BTC('bitcoin-address', 0.334);

QrCode::size(500)->BTC('address', 0.0034, [
    'label'         => 'আমার লেবেল',
    'message'       => 'ধন্যবাদ!',
    'returnAddress' => 'https://example.com/callback',
]);
```

### E-Mail

```php
QrCode::email('foo@bar.com');
QrCode::email('foo@bar.com', 'বিষয়', 'বার্তা');
QrCode::email(null, 'শুধু বিষয়', 'এবং বার্তা');
```

### Geo

```php
QrCode::geo(37.822214, -122.481769);
```

### Phone Number

```php
QrCode::phoneNumber('555-555-5555');
```

### SMS

```php
QrCode::SMS('555-555-5555');
QrCode::SMS('555-555-5555', 'পূর্ব-লিখিত বার্তা');
```

### WiFi

```php
QrCode::wiFi([
    'ssid'       => 'আমার নেটওয়ার্ক',
    'encryption' => 'WPA',
    'password'   => 'পাসওয়ার্ড',
]);
```

> Apple ডিভাইসে WiFi স্ক্যানিং সমর্থিত নয়।

### VCard *(নতুন)*

ডিভাইসের অ্যাড্রেস বুকে কন্টাক্ট যোগ করার জন্য vCard 3.0 QrCode।

```php
QrCode::vCard([
    'first_name' => 'জেন',
    'last_name'  => 'ডো',
    'phone'      => '+8801234567890',
    'email'      => 'jane@example.com',
    'company'    => 'আমার কোম্পানি',
    'title'      => 'ইঞ্জিনিয়ার',
    'address'    => '১২৩ মেইন স্ট্রিট, ঢাকা',
    'url'        => 'https://example.com',
    'note'       => 'সম্মেলনে দেখা হয়েছে',
]);

// সংক্ষিপ্ত নাম
QrCode::vCard(['name' => 'জন স্মিথ', 'phone' => '+8801234567890']);
```

### MeCard *(নতুন)*

সহজ কন্টাক্ট ফরম্যাট — Android/iOS-এ ব্যাপকভাবে সমর্থিত।

```php
QrCode::meCard([
    'first_name' => 'জেন',
    'last_name'  => 'ডো',
    'phone'      => '+8801234567890',
    'email'      => 'jane@example.com',
    'birthday'   => '19900101',   // YYYYMMDD
    'note'       => 'হ্যালো!',
]);
```

### Calendar *(নতুন)*

iCalendar ইভেন্ট QrCode — স্ক্যান করলে ক্যালেন্ডারে ইভেন্ট যোগ হবে।

```php
QrCode::calendar([
    'summary'     => 'টিম মিটিং',
    'start'       => '20240601T100000Z',
    'end'         => '20240601T110000Z',
    'location'    => 'কনফারেন্স রুম',
    'description' => 'সাপ্তাহিক সিঙ্ক',
]);
```

আবশ্যক: `summary`, `start`, `end`। ঐচ্ছিক: `location`, `description`, `url`।

### WhatsApp *(নতুন)*

পূর্ব-লিখিত বার্তাসহ WhatsApp চ্যাট খোলার জন্য QrCode।

```php
QrCode::whatsApp('+8801234567890', 'হ্যালো!');
QrCode::whatsApp('+8801234567890'); // শুধু নম্বর
```

### OTP (2FA) *(নতুন)*

TOTP/HOTP অথেন্টিকেটর অ্যাপের জন্য `otpauth://` URI।

```php
// TOTP (সময়-ভিত্তিক, ডিফল্ট)
QrCode::otp([
    'label'  => 'user@example.com',
    'secret' => 'JBSWY3DPEHPK3PXP',
    'issuer' => 'আমার অ্যাপ',
]);

// HOTP (কাউন্টার-ভিত্তিক)
QrCode::otp([
    'type'    => 'hotp',
    'label'   => 'user@example.com',
    'secret'  => 'JBSWY3DPEHPK3PXP',
    'counter' => 0,
]);
```

আবশ্যক: `label`, `secret`।

---

<a id="প্রিফিক্স-ব্যবহার"></a>
## প্রিফিক্স ব্যবহার

`generate()` মেথডে সরাসরি ফরম্যাট স্ট্রিং পাস করতে পারেন:

| ব্যবহার | প্রিফিক্স | উদাহরণ |
| --- | --- | --- |
| ওয়েবসাইট URL | `http://` | `http://www.example.com` |
| নিরাপদ URL | `https://` | `https://www.example.com` |
| ইমেইল | `mailto:` | `mailto:support@example.com` |
| ফোন নম্বর | `tel:` | `tel:555-555-5555` |
| SMS | `sms:` | `sms:555-555-5555` |
| জিও অ্যাড্রেস | `geo:` | `geo:-78.400364,-85.916993` |
| MeCard | `MECARD:` | `MECARD:N:Doe,John;TEL:555-555-5555;;` |
| VCard | `BEGIN:VCARD` | [উদাহরণ দেখুন](https://en.wikipedia.org/wiki/VCard) |
| WiFi | `WIFI:` | `WIFI:T:WPA;S:MyNet;P:password;;` |
| OTP | `otpauth://` | `otpauth://totp/user?secret=ABC` |

---

<a id="laravel-ছাড়া-ব্যবহার"></a>
## Laravel ছাড়া ব্যবহার

```php
use Manoar\QrCode\Generator;

$qr = new Generator();
$qr->size(300)->generate('Laravel ছাড়া QrCode!');

// নতুন ফিচার সহ
$qr->colorHex('#1a1a2e')
   ->backgroundColorHex('#ffffff')
   ->size(400)
   ->errorCorrection('H')
   ->generateDataUri('https://example.com');
```

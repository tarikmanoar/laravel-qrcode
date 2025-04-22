[![Build Status](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode.svg?branch=master)](https://travis-ci.org/SimpleSoftwareIO/simple-qrcode) [![Latest Stable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/stable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Latest Unstable Version](https://poser.pugx.org/simplesoftwareio/simple-qrcode/v/unstable.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![License](https://poser.pugx.org/simplesoftwareio/simple-qrcode/license.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode) [![Total Downloads](https://poser.pugx.org/simplesoftwareio/simple-qrcode/downloads.svg)](https://packagist.org/packages/simplesoftwareio/simple-qrcode)

#### [English](https://tarikmanoar.github.io/laravel-qrcode/docs/en) | [Deutsch](https://tarikmanoar.github.io/laravel-qrcode/docs/de) | [Español](https://tarikmanoar.github.io/laravel-qrcode/docs/es) | [Français](https://tarikmanoar.github.io/laravel-qrcode/docs/fr) | [Italiano](https://tarikmanoar.github.io/laravel-qrcode/docs/it) | [Português](https://tarikmanoar.github.io/laravel-qrcode/docs/pt-br) | [Русский](https://tarikmanoar.github.io/laravel-qrcode/docs/ru) | [日本語](https://tarikmanoar.github.io/laravel-qrcode/docs/ja) | [한국어](https://tarikmanoar.github.io/laravel-qrcode/docs/kr) | [हिंदी](https://tarikmanoar.github.io/laravel-qrcode/docs/hi) | [简体中文](https://tarikmanoar.github.io/laravel-qrcode/docs/zh-cn)

# Laravel QrCode

- [ভূমিকা](#docs-introduction)
- [অনুবাদ](#docs-translations)
- [কনফিগারেশন](#docs-configuration)
- [সহজ ধারণা](#docs-ideas)
- [ব্যবহার](#docs-usage)
- [হেল্পার](#docs-helpers)
- [প্রিফিক্স](#docs-common-usage)
- [Laravel ছাড়া ব্যবহার](#docs-outside-laravel)

## ব্যবহারের ক্ষেত্র
<a id="docs-introduction"></a>
## ভূমিকা
Laravel QrCode হলো জনপ্রিয় Laravel ফ্রেমওয়ার্কের (10, 11, 12) জন্য একটি সহজে ব্যবহারযোগ্য র‍্যাপার, যা [Bacon/BaconQrCode](https://github.com/Bacon/BaconQrCode) এর উপর ভিত্তি করে তৈরি। আপনি Pest ব্যবহার করে টেস্টিংয়ের জন্য ডিফল্ট ইনস্টল, কনফিগার এবং পাবলিশ করতে পারেন।

## ইনস্টলেশন

- Composer এর মাধ্যমে প্যাকেজটি রিকোয়ার করুন:

```bash
composer require tarikmanoar/laravel-qrcode
```

- (ঐচ্ছিক) কনফিগ ফাইল পাবলিশ করুন:

```bash
php artisan vendor:publish --provider="Manoar\\QrCode\\QrCodeServiceProvider" --tag=config
```

## ব্যবহার

- আপনার কোডে Facade অথবা হেল্পার ফাংশন ব্যবহার করুন:

```php
use Manoar\\QrCode\\Facades\\QrCode;

// একটি SVG তৈরি করুন
QrCode::generate('আমাকে একটি QrCode এ পরিণত করুন!');

// একটি PNG তৈরি করুন এবং ফাইলে সংরক্ষণ করুন
QrCode::format('png')->generate('এটি সংরক্ষণ করুন!', storage_path('app/qrcode.png'));
```

## কনফিগারেশন

`config/laravel-qrcode.php` কনফিগ ফাইলে `format`, `size`, `margin`, `error_correction`, এবং `encoding` এর জন্য ডিফল্ট মান রয়েছে। আপনি আপনার `.env` ফাইলে এগুলো ওভাররাইড করতে পারেন:

```
QRCODE_FORMAT=png
QRCODE_SIZE=200
QRCODE_MARGIN=10
QRCODE_ERROR_CORRECTION=H
QRCODE_ENCODING=UTF-8
```

<a id="docs-upgrade"></a>
## আপগ্রেড গাইড

v2 বা v3 থেকে আপগ্রেড করতে আপনার `composer.json` ফাইলে `~4` পরিবর্তন করুন।

আপনি যদি `png` ইমেজ ফরম্যাট ব্যবহার করার পরিকল্পনা করেন তবে আপনাকে অবশ্যই `imagick` PHP এক্সটেনশন ইনস্টল করতে হবে।

#### v4

> 4.1.0 তৈরি করার সময় একটি ভুল হয়েছিল এবং মাস্টার ব্রাঞ্চে একটি ব্যাকওয়ার্ড ব্রেকিং পরিবর্তন অনুমোদিত হয়েছিল। আপনি যদি Laravel ব্যবহার করেন তবে `generate` মেথড এখন `Illuminate\Support\HtmlString` এর একটি ইনস্ট্যান্স রিটার্ন করবে। আরও তথ্যের জন্য https://github.com/SimpleSoftwareIO/simple-qrcode/issues/205 দেখুন।

v3 এর মধ্যে একটি Laravel ফ্যাসাড সমস্যা ছিল যা কিছু লোডিং সমস্যার কারণ হয়েছিল। এটি ঠিক করার একমাত্র উপায় ছিল একটি ব্যাকওয়ার্ড ব্রেকিং পরিবর্তন তৈরি করা, তাই v4 প্রকাশ করা হয়েছে। আপনি যদি v2 থেকে আসেন তবে কোনও কোড পরিবর্তন করার প্রয়োজন নেই। নীচের পরিবর্তনটি শুধুমাত্র v3 ব্যবহারকারীদের প্রভাবিত করে।

`QrCode` ফ্যাসাডের সমস্ত রেফারেন্স পরিবর্তন করতে হবে:

```
use Manoar\QrCode\Facades\QrCode;
```

<a id="docs-ideas"></a>
## সহজ ধারণা

#### প্রিন্ট ভিউ

আমরা এই প্যাকেজটি যে প্রধান জিনিসগুলির জন্য ব্যবহার করি তার মধ্যে একটি হল আমাদের সমস্ত প্রিন্ট ভিউতে QrCode থাকা। এটি আমাদের গ্রাহকদের কোড স্ক্যান করে প্রিন্ট করার পরে মূল পৃষ্ঠায় ফিরে আসতে দেয়। আমরা আমাদের footer.blade.php ফাইলে নিম্নলিখিত কোড যোগ করে এটি অর্জন করেছি:

	<div class="visible-print text-center">
		{!! QrCode::size(100)->generate(Request::url()); !!}
		<p>মূল পৃষ্ঠায় ফিরে যেতে আমাকে স্ক্যান করুন।</p>
	</div>

#### একটি QrCode এম্বেড করুন

আপনি ব্যবহারকারীদের দ্রুত স্ক্যান করার অনুমতি দিতে একটি ই-মেইলের ভিতরে একটি qrcode এম্বেড করতে পারেন। Laravel এর সাথে এটি কীভাবে করবেন তার একটি উদাহরণ নীচে দেওয়া হল:

	//একটি ব্লেড টেমপ্লেটের ভিতরে।
	<img src="{!!$message->embedData(QrCode::format('png')->generate('আমাকে একটি ই-মেইলে এম্বেড করুন!'), 'QrCode.png', 'image/png')!!}">

<a id="docs-usage"></a>
## ব্যবহার

#### বেসিক ব্যবহার

```
// নীচের সমস্ত উদাহরণ ধরে নিচ্ছে যে আপনি নিম্নলিখিত কোড লাইন দিয়ে QrCode ফ্যাসাড ব্যবহার করছেন। Laravel ব্যবহারকারীদের জন্য ফ্যাসাড স্বয়ংক্রিয়ভাবে লোড হয়।

use Manoar\QrCode\Facades\QrCode;
```

QrCode জেনারেটর ব্যবহার করা খুব সহজ। সবচেয়ে মৌলিক সিনট্যাক্স হল:

	use Manoar\QrCode\Facades\QrCode;

	QrCode::generate('আমাকে একটি QrCode এ পরিণত করুন!');

এটি একটি QrCode তৈরি করবে যাতে লেখা থাকবে "Make me into a QrCode!"

![উদাহরণ QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/make-me-into-a-qrcode.png?raw=true)

#### Generate `(string $data, string $filename = null)`

`Generate` QrCode তৈরি করতে ব্যবহৃত হয়।

	QrCode::generate('আমাকে একটি QrCode এ পরিণত করুন!');

`Generate` ডিফল্টরূপে একটি SVG ইমেজ স্ট্রিং রিটার্ন করবে। আপনি Laravel এর Blade সিস্টেমে একটি আধুনিক ব্রাউজারে এটি সরাসরি প্রিন্ট করতে পারেন নিম্নলিখিত কোড দিয়ে:

	{!! QrCode::generate('আমাকে একটি QrCode এ পরিণত করুন!'); !!}

`generate` মেথডের একটি দ্বিতীয় প্যারামিটার রয়েছে যা QrCode সংরক্ষণ করার জন্য একটি ফাইলের নাম এবং পাথ গ্রহণ করবে।

	QrCode::generate('আমাকে একটি QrCode এ পরিণত করুন!', '../public/qrcodes/qrcode.svg');

#### Format `(string $format)`

বর্তমানে তিনটি ফরম্যাট সমর্থিত; `png,` `eps,` এবং `svg`। ফরম্যাট পরিবর্তন করতে নিম্নলিখিত কোড ব্যবহার করুন:

	QrCode::format('png');  //একটি png ইমেজ রিটার্ন করবে
	QrCode::format('eps');  //একটি eps ইমেজ রিটার্ন করবে
	QrCode::format('svg');  //একটি svg ইমেজ রিটার্ন করবে

> একটি `png` ইমেজ তৈরি করার জন্য `imagick` প্রয়োজন।

#### Size `(int $size)`

আপনি `size` মেথড ব্যবহার করে একটি QrCode এর আকার পরিবর্তন করতে পারেন। নিম্নলিখিত সিনট্যাক্স ব্যবহার করে পিক্সেলে কাঙ্ক্ষিত আকার উল্লেখ করুন:

	QrCode::size(100);

![200 পিক্সেল](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) ![250 পিক্সেল](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/250-pixels.png?raw=true)

#### Color `(int $red, int $green, int $blue, int $alpha = null)`

> একটি QrCode এর রঙ পরিবর্তন করার সময় সতর্ক থাকুন, কারণ কিছু রিডার রঙিন QrCode পড়তে খুব অসুবিধা বোধ করে।

সমস্ত রঙ অবশ্যই RGBA (Red Green Blue Alpha) তে প্রকাশ করতে হবে। আপনি নিম্নলিখিত ব্যবহার করে একটি QrCode এর রঙ পরিবর্তন করতে পারেন:

	QrCode::color(255, 0, 0); // লাল QrCode
	QrCode::color(255, 0, 0, 25); // ২৫% স্বচ্ছতা সহ লাল QrCode

![লাল QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-qrcode.png?raw=true) ![লাল স্বচ্ছ QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent.png?raw=true)

#### Background Color `(int $red, int $green, int $blue, int $alpha = null)`

আপনি `backgroundColor` মেথড কল করে একটি QrCode এর পটভূমির রঙ পরিবর্তন করতে পারেন।

	QrCode::backgroundColor(255, 0, 0); // লাল পটভূমি QrCode
	QrCode::backgroundColor(255, 0, 0, 25); // ২৫% স্বচ্ছতা সহ লাল পটভূমি QrCode

![লাল পটভূমি QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-background.png?raw=true) ![লাল স্বচ্ছ পটভূমি QrCode](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/red-25-transparent-background.png?raw=true)

#### Gradient `$startRed, $startGreen, $startBlue, $endRed, $endGreen, $endBlue, string $type)`

আপনি `gradient` মেথড কল করে QrCode এ একটি গ্রেডিয়েন্ট প্রয়োগ করতে পারেন।

নিম্নলিখিত গ্রেডিয়েন্ট প্রকারগুলি সমর্থিত:

| প্রকার | উদাহরণ |
| --- | --- |
| `vertical` | ![উল্লম্ব](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/vertical.png?raw=true) |
| `horizontal` | ![অনুভূমিক](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/horizontal.png?raw=true) |
| `diagonal` | ![কর্ণ](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/diagonal.png?raw=true) |
| `inverse_diagonal` | ![বিপরীত কর্ণ](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/inverse_diagonal.png?raw=true) |
| `radial` | ![রেডিয়াল](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/radial.png?raw=true) |

#### EyeColor `(int $eyeNumber, int $innerRed, int $innerGreen, int $innerBlue, int $outterRed = 0, int $outterGreen = 0, int $outterBlue = 0)`

আপনি `eyeColor` মেথড ব্যবহার করে চোখের রঙ পরিবর্তন করতে পারেন।

	QrCode::eyeColor(0, 255, 255, 255, 0, 0, 0); // চোখ `0` এর রঙ পরিবর্তন করে

| চোখের নম্বর | উদাহরণ |
| --- | --- |
| `0` | ![চোখ 0](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-0.png?raw=true) |
| `1` | ![চোখ 1](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-1.png?raw=true)|
| `2` | ![চোখ 2](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/eye-2.png?raw=true) |


#### Style `(string $style, float $size = 0.5)`

স্টাইল সহজেই `square`, `dot,` বা `round` দিয়ে পরিবর্তন করা যেতে পারে। এটি QrCode এর ভিতরের ব্লকগুলি পরিবর্তন করবে। দ্বিতীয় প্যারামিটারটি ডট বা রাউন্ডনেসের আকারকে প্রভাবিত করবে।

	QrCode::style('dot'); // `dot` স্টাইল ব্যবহার করে।

| স্টাইল | উদাহরণ |
| --- | --- |
| `square` | ![বর্গ](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `dot` | ![ডট](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/dot.png)|
| `round` | ![গোল](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/round.png?raw=true) |

#### Eye Style `(string $style)`

QrCode এর ভিতরের চোখ দুটি ভিন্ন স্টাইল সমর্থন করে, `square` এবং `circle`।

	QrCode::eye('circle'); // `circle` স্টাইলের চোখ ব্যবহার করে।

| স্টাইল | উদাহরণ |
| --- | --- |
| `square` | ![বর্গ](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/200-pixels.png?raw=true) |
| `circle` | ![বৃত্ত](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/circle-eye.png?raw=true)|

#### Margin `(int $margin)`

একটি QrCode এর চারপাশে মার্জিন পরিবর্তন করার ক্ষমতাও সমর্থিত। নিম্নলিখিত সিনট্যাক্স ব্যবহার করে কাঙ্ক্ষিত মার্জিন উল্লেখ করুন:

	QrCode::margin(100);

#### Error Correction `(string $errorCorrection)`

ত্রুটি সংশোধনের স্তর পরিবর্তন করা সহজ। শুধু নিম্নলিখিত সিনট্যাক্স ব্যবহার করুন:

	QrCode::errorCorrection('H');

`errorCorrection` মেথডের জন্য নিম্নলিখিত বিকল্পগুলি সমর্থিত:

| ত্রুটি সংশোধন | প্রদত্ত নিশ্চয়তা |
| --- | --- |
| L | ৭% কোডওয়ার্ড পুনরুদ্ধার করা যেতে পারে। |
| M | ১৫% কোডওয়ার্ড পুনরুদ্ধার করা যেতে পারে। |
| Q | ২৫% কোডওয়ার্ড পুনরুদ্ধার করা যেতে পারে। |
| H | ৩০% কোডওয়ার্ড পুনরুদ্ধার করা যেতে পারে। |

>যত বেশি ত্রুটি সংশোধন ব্যবহার করা হয়; QrCode তত বড় হয় এবং এটি তত কম ডেটা সংরক্ষণ করতে পারে। [ত্রুটি সংশোধন](http://en.wikipedia.org/wiki/QR_code#Error_correction) সম্পর্কে আরও পড়ুন।

#### Encoding `(string $encoding)`

একটি QrCode তৈরি করতে ব্যবহৃত ক্যারেক্টার এনকোডিং পরিবর্তন করুন। ডিফল্টরূপে `ISO-8859-1` এনকোডার হিসাবে নির্বাচিত হয়। [ক্যারেক্টার এনকোডিং](http://en.wikipedia.org/wiki/Character_encoding) সম্পর্কে আরও পড়ুন।

আপনি এটিকে নিম্নলিখিত যেকোনো একটিতে পরিবর্তন করতে পারেন:

	QrCode::encoding('UTF-8')->generate('বিশেষ প্রতীক সহ আমাকে একটি QrCode তৈরি করুন ♠♥!!');

| ক্যারেক্টার এনকোডার |
| --- |
| ISO-8859-1 |
| ISO-8859-2 |
| ISO-8859-3 |
| ISO-8859-4 |
| ISO-8859-5 |
| ISO-8859-6 |
| ISO-8859-7 |
| ISO-8859-8 |
| ISO-8859-9 |
| ISO-8859-10 |
| ISO-8859-11 |
| ISO-8859-12 |
| ISO-8859-13 |
| ISO-8859-14 |
| ISO-8859-15 |
| ISO-8859-16 |
| SHIFT-JIS |
| WINDOWS-1250 |
| WINDOWS-1251 |
| WINDOWS-1252 |
| WINDOWS-1256 |
| UTF-16BE |
| UTF-8 |
| ASCII |
| GBK |
| EUC-KR |

#### Merge `(string $filepath, float $percentage = .2, bool $absolute = false)`

`merge` মেথড একটি QrCode এর উপর একটি ইমেজ মার্জ করে। এটি সাধারণত একটি QrCode এর মধ্যে লোগো স্থাপন করতে ব্যবহৃত হয়।

	//মাঝখানে একটি ইমেজ সহ একটি QrCode তৈরি করে।
	QrCode::format('png')->merge('path-to-image.png')->generate();

	//মাঝখানে একটি ইমেজ সহ একটি QrCode তৈরি করে। ঢোকানো ইমেজটি QrCode এর ৩০% জায়গা নেয়।
	QrCode::format('png')->merge('path-to-image.png', .3)->generate();

	//মাঝখানে একটি ইমেজ সহ একটি QrCode তৈরি করে। ঢোকানো ইমেজটি QrCode এর ৩০% জায়গা নেয়।
	QrCode::format('png')->merge('http://www.google.com/someimage.png', .3, true)->generate();

> `merge` মেথড এই সময়ে শুধুমাত্র PNG সমর্থন করে।
> যদি `$absolute` `false` সেট করা থাকে তবে ফাইলপাথ অ্যাপ বেস পাথের সাথে সম্পর্কিত। অ্যাবসোলিউট পাথ ব্যবহার করতে এই ভেরিয়েবলটি `true` তে পরিবর্তন করুন।

> `merge` মেথড ব্যবহার করার সময় আপনার উচ্চ স্তরের ত্রুটি সংশোধন ব্যবহার করা উচিত যাতে QrCodeটি এখনও পঠনযোগ্য থাকে। আমরা `errorCorrection('H')` ব্যবহার করার পরামর্শ দিই।

![মার্জড লোগো](https://raw.githubusercontent.com/SimpleSoftwareIO/simple-qrcode/master/docs/imgs/merged-qrcode.png?raw=true)

#### Merge Binary String `(string $content, float $percentage = .2)`

`mergeString` মেথড `merge` কলের মতো একই ফলাফল অর্জন করতে ব্যবহার করা যেতে পারে, তবে এটি আপনাকে ফাইলপাথের পরিবর্তে ফাইলের একটি স্ট্রিং রিপ্রেজেন্টেশন প্রদান করতে দেয়। এটি `Storage` ফ্যাসাডের সাথে কাজ করার সময় দরকারী। এর ইন্টারফেস `merge` কলের সাথে বেশ মিল।

	//মাঝখানে একটি ইমেজ সহ একটি QrCode তৈরি করে।
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'))->generate();

	//মাঝখানে একটি ইমেজ সহ একটি QrCode তৈরি করে। ঢোকানো ইমেজটি QrCode এর ৩০% জায়গা নেয়।
	QrCode::format('png')->mergeString(Storage::get('path/to/image.png'), .3)->generate();

>সাধারণ `merge` কলের মতো, এই সময়ে শুধুমাত্র PNG সমর্থিত। ত্রুটি সংশোধনের ক্ষেত্রেও একই কথা প্রযোজ্য, উচ্চ স্তর সুপারিশ করা হয়।

#### অ্যাডভান্সড ব্যবহার

সমস্ত মেথড চেইনিং সমর্থন করে। `generate` মেথড অবশ্যই শেষে কল করতে হবে। উদাহরণস্বরূপ আপনি নিম্নলিখিত যেকোনো একটি চালাতে পারেন:

	QrCode::size(250)->color(150,90,10)->backgroundColor(10,14,244)->generate('আমাকে একটি QrCode তৈরি করুন!');
	QrCode::format('png')->size(399)->color(40,40,40)->generate('আমাকে একটি QrCode তৈরি করুন!');

আপনি একটি raw স্ট্রিং প্রদান করে এবং `base64_encode` দিয়ে এনকোড করে ফাইল সংরক্ষণ না করেই একটি PNG ইমেজ প্রদর্শন করতে পারেন।

	<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate('আমাকে একটি QrCode এ পরিণত করুন!')) !!} ">

<a id="docs-helpers"></a>
## হেল্পার

#### হেল্পার কি?

হেল্পার হল QrCode তৈরি করার একটি সহজ উপায় যা স্ক্যান করার সময় রিডারকে একটি নির্দিষ্ট ক্রিয়া সম্পাদন করতে বাধ্য করে।

#### বিটকয়েন

এই হেল্পার পেমেন্ট পাঠানোর জন্য একটি স্ক্যানযোগ্য বিটকয়েন তৈরি করে। [আরও তথ্য](https://bitco.in/en/developer-guide#plain-text)

	QrCode::BTC($address, $amount);

	//ঠিকানায় একটি 0.334BTC পেমেন্ট পাঠায়
	QrCode::BTC('bitcoin address', 0.334);

	//কিছু ঐচ্ছিক আর্গুমেন্ট সহ ঠিকানায় একটি 0.334BTC পেমেন্ট পাঠায়
	QrCode::size(500)->BTC('address', 0.0034, [
				'label' => 'my label',
				'message' => 'my message',
				'returnAddress' => 'https://www.returnaddress.com'
		]);

#### ই-মেইল

এই হেল্পার একটি ই-মেইল qrcode তৈরি করে যা ই-মেইল ঠিকানা, বিষয় এবং বডি পূরণ করতে সক্ষম:

	QrCode::email($to, $subject, $body);

	//টু ঠিকানা পূরণ করে
	QrCode::email('foo@bar.com');

	//একটি ই-মেইলের টু ঠিকানা, বিষয় এবং বডি পূরণ করে।
	QrCode::email('foo@bar.com', 'This is the subject.', 'This is the message body.');

	//একটি ই-মেইলের শুধু বিষয় এবং বডি পূরণ করে।
	QrCode::email(null, 'This is the subject.', 'This is the message body.');

#### জিও

এই হেল্পার একটি অক্ষাংশ এবং দ্রাঘিমাংশ তৈরি করে যা একটি ফোন পড়তে পারে এবং Google Maps বা অনুরূপ অ্যাপে অবস্থানটি খোলে।

	QrCode::geo($latitude, $longitude);

	QrCode::geo(37.822214, -122.481769);

#### ফোন নম্বর

এই হেল্পার একটি QrCode তৈরি করে যা স্ক্যান করা যায় এবং তারপর একটি নম্বর ডায়াল করে।

	QrCode::phoneNumber($phoneNumber);

	QrCode::phoneNumber('555-555-5555');
	QrCode::phoneNumber('1-800-Laravel');

#### এসএমএস (টেক্সট মেসেজ)

এই হেল্পার এসএমএস বার্তা তৈরি করে যা পাঠানোর ঠিকানা এবং বার্তার বডি দিয়ে প্রিফিল করা যেতে পারে:

	QrCode::SMS($phoneNumber, $message);

	//নম্বর পূরণ করা সহ একটি টেক্সট মেসেজ তৈরি করে।
	QrCode::SMS('555-555-5555');

	//নম্বর এবং বার্তা পূরণ করা সহ একটি টেক্সট মেসেজ তৈরি করে।
	QrCode::SMS('555-555-5555', 'Body of the message');

#### ওয়াইফাই

এই হেল্পার স্ক্যানযোগ্য QrCode তৈরি করে যা একটি ফোনকে একটি ওয়াইফাই নেটওয়ার্কের সাথে সংযুক্ত করতে পারে:

	QrCode::wiFi([
		'encryption' => 'WPA/WEP',
		'ssid' => 'SSID of the network',
		'password' => 'Password of the network',
		'hidden' => 'Whether the network is a hidden SSID or not.'
	]);

	//একটি খোলা ওয়াইফাই নেটওয়ার্কের সাথে সংযোগ করে।
	QrCode::wiFi([
		'ssid' => 'Network Name',
	]);

	//একটি খোলা, লুকানো ওয়াইফাই নেটওয়ার্কের সাথে সংযোগ করে।
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'hidden' => 'true'
	]);

	//একটি সুরক্ষিত ওয়াইফাই নেটওয়ার্কের সাথে সংযোগ করে।
	QrCode::wiFi([
		'ssid' => 'Network Name',
		'encryption' => 'WPA',
		'password' => 'myPassword'
	]);

> ওয়াইফাই স্ক্যানিং বর্তমানে অ্যাপল পণ্যগুলিতে সমর্থিত নয়।

<a id="docs-common-usage"></a>
## সাধারণ QrCode ব্যবহার

আপনি আরও উন্নত তথ্য সংরক্ষণ করতে একটি QrCode তৈরি করতে `generate` বিভাগের ভিতরে নীচের সারণীতে পাওয়া একটি উপসর্গ ব্যবহার করতে পারেন:

	QrCode::generate('http://www.tarikmanoar.com');


| ব্যবহার | উপসর্গ | উদাহরণ |
| --- | --- | --- |
| ওয়েবসাইট ইউআরএল | http:// | http://www.tarikmanoar.com |
| সুরক্ষিত ইউআরএল | https:// | https://www.tarikmanoar.com |
| ই-মেইল ঠিকানা | mailto: | mailto:support@tarikmanoar.com |
| ফোন নম্বর | tel: | tel:555-555-5555 |
| টেক্সট (এসএমএস) | sms: | sms:555-555-5555 |
| প্রিটাইপড মেসেজ সহ টেক্সট (এসএমএস) | sms: | sms::I am a pretyped message |
| প্রিটাইপড মেসেজ এবং নম্বর সহ টেক্সট (এসএমএস) | sms: | sms:555-555-5555:I am a pretyped message |
| জিও ঠিকানা | geo: | geo:-78.400364,-85.916993 |
| MeCard | mecard: | MECARD:Simple, Software;Some Address, Somewhere, 20430;TEL:555-555-5555;EMAIL:support@tarikmanoar.com; |
| VCard | BEGIN:VCARD | [উদাহরণ দেখুন](https://en.wikipedia.org/wiki/VCard) |
| ওয়াইফাই | wifi: | wifi:WEP/WPA;SSID;PSK;Hidden(True/False) |

<a id="docs-outside-laravel"></a>
## Laravel এর বাইরে ব্যবহার

আপনি একটি নতুন `Generator` ক্লাস ইনস্ট্যানশিয়েট করে Laravel এর বাইরে এই প্যাকেজটি ব্যবহার করতে পারেন।

	use Manoar\QrCode\Generator;

	$qrcode = new Generator;
	$qrcode->size(500)->generate('Laravel ছাড়া একটি qrcode তৈরি করুন!');


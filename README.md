# Action Delay for Laravel



[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/laravel-action-delay.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-action-delay)


&nbsp;
## Introduction

This package allows you to delay an action (Jobs, Database Query or even PHP Code) at specific datetime with a simple command.


&nbsp;
* [Requirement](#requirement)
* [Installation](#installation)
* [Usage](#usage)
* [Example](#example)


&nbsp;
&nbsp;
## Requirement

* Laravel 10.x (and above)


&nbsp;
&nbsp;
## Installation


This package can be used in Laravel 10.x or higher. If you are using an older version of Laravel, there's might be some problem. If there's any problem, you can [create new issue](https://github.com/syamsoul/laravel-action-delay/issues) and I will fix it as soon as possible.

You can install the package via composer:

``` bash
composer require syamsoul/laravel-action-delay
```

&nbsp;
&nbsp;
## Usage

You can delay an action via `Artisan` command.
``` bash
php artisan souldoit:action-delay
```

&nbsp;
&nbsp;
## Example

#### 1. Delay Laravel Jobs
```bash
 What action you want to delay? [Laravel Jobs]:
  [1] Laravel Jobs
  [2] Database Query
  [3] PHP Code
  [4] External Process
 > 1

 What job you want to delay? [App\Jobs\GenerateCertificate]:
  [1] App\Jobs\GenerateCertificate
  [2] App\Jobs\SendCongratulationsEmail
 > 2

 Please insert #1 parameter: `user` (Type: App\Models\User):
 > \App\Models\User::find(1)

 Please insert #2 parameter: `text` (Type: string):
 > Congratulations on your success!

 What time to execute (in UTC time, format:Y-m-d H:i:s):
 > 2024-06-01 10:16:0
```

#### 2. Delay Database Query
```bash
 What action you want to delay? [Laravel Jobs]:
  [1] Laravel Jobs
  [2] Database Query
  [3] PHP Code
  [4] External Process
 > 2

 Enter MySQL query:
 > UPDATE `variables` SET `_value`='false' WHERE `_key`='maintainance_mode_enabled'

 What time to execute (in UTC time, format:Y-m-d H:i:s):
 > 2024-06-01 08:30:35
```

&nbsp;
#### 3. Delay PHP Code
```bash
 What action you want to delay? [Laravel Jobs]:
  [1] Laravel Jobs
  [2] Database Query
  [3] PHP Code
  [4] External Process
 > 3

 Enter PHP code:
 > \App\Models\Variable::where('_key', 'maintainance_mode_enabled')->update(['_value' => 'false']); \App\Models\Variable::where('_key', 'new_feature_enabled')->update(['_value' => 'true']);

 What time to execute (in UTC time, format:Y-m-d H:i:s):
 > 2024-06-01 08:30:35
```

&nbsp;
#### 4. Delay External Process
```bash
 What action you want to delay? [Laravel Jobs]:
  [1] Laravel Jobs
  [2] Database Query
  [3] PHP Code
  [4] External Process
 > 4

 Enter command:
 > sh deploy

 Process timeout [600]: #default is 600 seconds, enter to choose default value
 >

 What time to execute (in UTC time, format:Y-m-d H:i:s):
 > 2024-06-01 08:30:35
```

&nbsp;
&nbsp;
## Support me

If you find this package helps you, kindly support me by donating some BNB (BSC) to the address below.

```
0x364d8eA5E7a4ce97e89f7b2cb7198d6d5DFe0aCe
```

<img src="https://info.souldoit.com/img/wallet-address-bnb-bsc.png" width="150">


&nbsp;
&nbsp;
## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
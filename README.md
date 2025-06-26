# Action Delay for Laravel



[![Latest Version on Packagist](https://img.shields.io/packagist/v/syamsoul/laravel-action-delay.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-action-delay)
[![Total Downloads](https://img.shields.io/packagist/dt/syamsoul/laravel-action-delay.svg?style=flat-square)](https://packagist.org/packages/syamsoul/laravel-action-delay)
[![License](https://img.shields.io/github/license/syamsoul/laravel-action-delay.svg?style=flat-square)](LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-10.x%2B-red.svg?style=flat-square)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue.svg?style=flat-square)](https://php.net)


&nbsp;
## Introduction

This package allows you to delay an action (Jobs, Database Query, PHP Code or External Process) at specific datetime with a simple command.


&nbsp;
* [Requirement](#requirement)
* [Installation](#installation)
* [Usage](#usage)
* [Single-Line Commands (No Prompts)](#single-line-commands-no-prompts)
* [Interactive Prompts](#interactive-prompts)


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
## Single-Line Commands (No Prompts)

You can delay actions using single-line commands without any interactive prompts. This is useful for automation, scripts, or when you want to schedule actions programmatically.

#### 1. Delay Laravel Jobs
```bash
php artisan souldoit:action-delay --action=1 --job=\\SoulDoit\\ActionDelay\\Jobs\\ExternalProcessJob --job-parameter="touch newfile.txt" --delay-at="2025-06-25 16:25:00"
```

#### 2. Delay Database Query
```bash
php artisan souldoit:action-delay --action=2 --db-query="INSERT INTO \`users\` (\`username\`,\`email\`,\`first_name\`,\`last_name\`,\`created_at\`,\`updated_at\`) VALUES ('user01','user01@gmail.com','User','One',NOW(),NOW())" --delay-at="2025-06-25 15:51:25"
```

#### 3. Delay PHP Code
```bash
php artisan souldoit:action-delay --action=3 --php-code="\DB::table('users')->insert(['username'=>'user02', 'email'=>'user02@gmail.com', 'first_name'=>'User', 'last_name'=>'Two', 'updated_at'=>now(), 'created_at'=>now()])" --delay-at="2025-06-25 16:32:00"
```

#### 4. Delay External Process
```bash
php artisan souldoit:action-delay --action=4 --command="php artisan down" --command-timeout=600 --delay-at="2025-06-25 16:37:50"
```

**Available Options:**
- `--action`: Action type (1=Laravel Jobs, 2=Database Query, 3=PHP Code, 4=External Process)
- `--job`: Job class name (for action=1)
- `--job-parameter`: Job parameters (for action=1)
- `--db-query`: SQL query (for action=2)
- `--php-code`: PHP code to execute (for action=3)
- `--command`: Command to execute (for action=4)
- `--command-timeout`: Process timeout in seconds (for action=4, default: 600)
- `--delay-seconds`: Delay execution by specified number of seconds from current time
- `--delay-at`: Execution at specific date & time in UTC (format: Y-m-d H:i:s)
- 

&nbsp;
&nbsp;
## Interactive Prompts

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
 > 2024-06-01 10:16:00
```

&nbsp;
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

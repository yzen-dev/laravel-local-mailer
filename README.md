# Local mailer for laravel

![Packagist Version](https://img.shields.io/packagist/v/yzen.dev/laravel-local-mailer?color=blue&label=version)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/yzen-dev/laravel-local-mailer/Run%20tests?label=tests&logo=github)
[![Coverage](https://codecov.io/gh/yzen-dev/laravel-local-mailer/branch/master/graph/badge.svg?token=QAO8STLPMI)](https://codecov.io/gh/yzen-dev/laravel-local-mailer)
![License](https://img.shields.io/github/license/yzen-dev/laravel-local-mailer)
![Packagist Downloads](https://img.shields.io/packagist/dm/yzen.dev/laravel-local-mailer)
![Packagist Downloads](https://img.shields.io/packagist/dt/yzen.dev/laravel-local-mailer)


Each developer needs to check the sending of email messages during development. Most of them have their own ways - usage gmail, Mailtrap, laravel logs, etc.

This solution will create its own mail transport, saving emails as daily logs, with the ability to view!

![image](https://user-images.githubusercontent.com/24630195/170493285-127b4211-3963-4bde-8bcf-3c6195fc6f49.png)


## :scroll: **Installation**
The package can be installed via composer:
```
composer require yzen.dev/laravel-local-mailer
```
In the config **config/mail.php** add a new transport:

```php
return [
    //...
    'mailers' => [
        //...
        'local-mailer' => [
            'transport' => 'local-mailer'
        ],
    ]
]
```
Now you can include this transport in the env:
```dotenv
MAIL_MAILER=local-mailer
```

The page for viewing is available at ``{HOST}/local-mailer``.
Here you can view the log for any date. For each log, the full email will be displayed - the title, to, contents of the letter (html page), attached files, etc.

![image](https://user-images.githubusercontent.com/24630195/172157281-66206eee-b61b-48f9-b35b-e0387c48c683.png)



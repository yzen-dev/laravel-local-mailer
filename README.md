# Local mailer for laravel

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

The page for viewing is available at ``{HOST}/local-mailer``

![image](https://user-images.githubusercontent.com/24630195/170495087-c172cd4f-14b3-41ea-b5ea-a5db67af6889.png)

<p align="center"><a href="https://github.com/ajangi/php-rest-response" style="border-radius:100%;"><img src="https://raw.githubusercontent.com/ajangi/ajangi/744acdd11fa62946dc4a2404e8628941f28f3674/man.svg" width="200" style="border-radius:100%;"></a></p>
<p align="center">
<a href="https://packagist.org/packages/ajangi/php-rest-response"><img src="https://poser.pugx.org/ajangi/php-rest-response/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/ajangi/php-rest-response"><img src="https://poser.pugx.org/ajangi/php-rest-response/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/ajangi/php-rest-response"><img src="https://poser.pugx.org/ajangi/php-rest-response/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/ajangi/php-rest-response"><img src="https://poser.pugx.org/ajangi/php-rest-response/composerlock" alt="License"></a>
</p>

# Laravel-Crypt-Model
Encoding and Decoding laravel model attributes made easy.

### Requirements
- minimum php version : 7.1.0

### Installation
```bash
composer require ajangi/laravel-crypt-model
```

### Hot to use?

#### 1- Register your models
To register your models, you should pass the desired prefix and the class name of your model to.
```php
<?php

use LaravelCryptModel\PrefixedAttributes;

PrefixedAttributes::registerModels([
        'user' => [
            'model' => \App\Models\User::class,
            'attributes' => ['id','avatar_file_id']
        ],
        'Order' => [
            'model' => \App\Models\Oredr::class,
            'attributes' => ['id','customer_user_id']
        ]
    ]);
```
Typically, you would put the code above in a service provider.

#### 2- Publish config file
```bash
php artisan vendor:publish
```
then select ajangi/laravel-crypt-model to push config file. After publishing the file ``` config/laravel-crypt-model.php ``` will be added.

#### 3- Preparing your models

On each model that needs a hashed prefixed attribute, you should use the LaravelCryptModel\Models\Concerns\HasHashedPrefixedAttributes trait.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelCryptModel\Models\Concerns\HasHashedPrefixedAttributes;

class User extends Model
{
    use HasFactory,Notifiable, HasHashedPrefixedAttributes;
}
```

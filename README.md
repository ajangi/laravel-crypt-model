<p align="center"><a href="https://github.com/ajangi/laravel-crypt-model" style="border-radius:100%;"><img src="https://raw.githubusercontent.com/ajangi/ajangi/744acdd11fa62946dc4a2404e8628941f28f3674/man.svg" width="200" style="border-radius:100%;"></a></p>
<p align="center">
<a href="https://packagist.org/packages/ajangi/laravel-crypt-model"><img src="https://poser.pugx.org/ajangi/laravel-crypt-model/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/ajangi/laravel-crypt-model"><img src="https://poser.pugx.org/ajangi/laravel-crypt-model/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/ajangi/laravel-crypt-model"><img src="https://poser.pugx.org/ajangi/laravel-crypt-model/license.svg" alt="License"></a>
<a href="https://packagist.org/packages/ajangi/laravel-crypt-model"><img src="https://poser.pugx.org/ajangi/laravel-crypt-model/composerlock" alt="License"></a>
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
php artisan vendor:publish --provider="LaravelCryptModel\LaravelCryptoModelServiceProvider"
```
then select ajangi/laravel-crypt-model to push config file. After publishing the file ``` config/laravel-crypt-model.php ``` will be added.
```php
<?php

return [
    'model_new_attribute_prefix' => 'hashed_',
    'aes_secret_key' => env('AES_SECRET_KEY','6818f23eef19d38dad1d272345454549991f6368'), //the secret key you should change
    'aes_secret_iv' => env('AES_SECRET_IV','73658734657823465872364587634876523487657'), //the secret iv you should change
];

```
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

#### 4- Getting model with prefixed hashed attributes appended to it
```php
<?php
use App\Models\User;

$user = User::query()
        ->where('name','Alireza')
        ->first();
return json_encode($user);
```
the above code will return :
```json
{
  "id": 1,
  "name": "Alireza",
  "family": "Jangi",
  "mobile": "09393563537",
  "created_at": null,
  "updated_at": null,
  "user_id_hashed_": "user_id_hashed_7QOG8YaqVQigyD0sYEd25A==",
}
```
#### 5- Get model using prefixed hashed attribute
To get model using prefixed hashed attribute you can try two methods : 
##### a. using model :
```php
use App\Models\User;
$user = User::findByPrefixedAttribute('user_id_hashed_7QOG8YaqVQigyD0sYEd25A=='); // the prefixed hashed value we get in step 4
return json_encode($user);
```
the above code will return :
```json
{
  "id": 1,
  "name": "Alireza",
  "family": "Jangi",
  "mobile": "09393563537",
  "created_at": null,
  "updated_at": null,
  "user_id_hashed_": "user_id_hashed_7QOG8YaqVQigyD0sYEd25A==",
}
```
##### b. using ``` LaravelCryptModel\PrefixedAttributes ``` :
```php
use LaravelCryptModel\PrefixedAttributes;
$user = PrefixedAttributes::findModel('user_id_hashed_7QOG8YaqVQigyD0sYEd25A=='); // the prefixed hashed value we get in step 4
return json_encode($user);
```
the above code will return :
```json
{
  "id": 1,
  "name": "Alireza",
  "family": "Jangi",
  "mobile": "09393563537",
  "created_at": null,
  "updated_at": null,
  "user_id_hashed_": "user_id_hashed_7QOG8YaqVQigyD0sYEd25A==",
}
```
### Contributing 
Take a look at [CONTRIBUTING](CONTRIBUTING.md) for details.

<?php
require 'vendor/autoload.php';
try {
    \LaravelCryptModel\PrefixedAttributes::registerModels([
        'user' => [
            'model' => \LaravelCryptModel\Models\Concerns\User::class,
            'attributes' => ['id', 'file_id']
        ],
        'animal' => [
            'model' => \LaravelCryptModel\Models\Concerns\Animal::class,
            'attributes' => ['id', 'food_id']
        ]
    ]);
    //$encoder = new \LaravelCryptModel\Encode\LaravelCryptEncoder();
    //$encoder->decrypt(12);
    //\LaravelCryptModel\Encode\LaravelCryptEncoder::decrypt('Alireza');
    //\LaravelCryptModel\Encode\LaravelCryptEncoder::encrypt('Alireza');
    \LaravelCryptModel\PrefixedAttributes::getPrefixForModel(\LaravelCryptModel\Models\Concerns\User::class,'id');
    //var_dump(\LaravelCryptModel\Encode\LaravelCryptEncoder::encrypt('Alireza'));
} catch (\LaravelCryptModel\Exceptions\RegisteredModelsNotStructured $e) {
    echo "ERROR!!!";
}


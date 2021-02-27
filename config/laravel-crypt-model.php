<?php

return [
    'model_new_attribute_prefix' => 'hashed_',
    'aes_secret_key' => env('AES_SECRET_KEY',
        pack('H*', "bcb04b7e103a0cd8b54763051c0okmlnh5abe029fdebae5e1d417e2ffb2a00au") // key is specified using hexadecimal (64 characters)
    ),
    'aes_secret_iv' => env('AES_SECRET_IV',
        base64_encode(base64_decode('yg/unZfv3LO3aTNvIdW3jQ=='))
    ),
];
<?php

return [
    'model_new_attribute_prefix' => 'hashed_',
    'aes_secret_key' => env('AES_SECRET_KEY','6818f23eef19d38dad1d272345454549991f6368'), //the secret key you should change
    'aes_secret_iv' => env('AES_SECRET_IV','73658734657823465872364587634876523487657'), //the secret iv you should change
];
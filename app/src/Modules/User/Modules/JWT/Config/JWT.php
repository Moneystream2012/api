<?php

return [
    'class'      => \App\Modules\User\Modules\JWT\JWTCrypror::class,
    'publicKey'  => __DIR__ . '/JWT/pubkey.pem',
    'privateKey' => __DIR__ . '/JWT/privkey.pem'

];
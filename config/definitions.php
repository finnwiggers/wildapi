<?php

use App\Database;
use Invoker\ParameterResolver\Container\TypeHintContainerResolver;

return [
    Database::class=>function(){
        return new Database(host: '127.0.0.1',
                            dbname:'slim-api',
                            user: 'FinnWiggers',
                            password: '123');
    }
];
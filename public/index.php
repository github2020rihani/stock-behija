<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php;C:\php\pear';



return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

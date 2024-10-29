<?php

namespace Aijoh\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aijoh\Core\Core
 */
class Core extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Aijoh\Core\Core::class;
    }
}

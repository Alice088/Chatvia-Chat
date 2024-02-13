<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string createRememberToken(int $length = 32)
 * @see RememberTokenManager
 */
class RememberTokenManager extends Facade
{
  protected static function getFacadeAccessor()
  {
    return "RememberTokenManager";
  }
}

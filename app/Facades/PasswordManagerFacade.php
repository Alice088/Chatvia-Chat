<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


/**
 * @see PasswordManager
 */
class PasswordManagerFacade extends Facade {
  protected static function getFacadeAccessor() {
    return "PasswordManager";
  }
}
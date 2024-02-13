<?php

namespace app\Helpers;

class RememberTokenManager {
  /**
   * Helper function
   * app/Helpers/createRememberToken.php
   * @param int $length
   * @return string
   */
  public static function createRememberToken(int $length = 32)
  {
    return bin2hex(random_bytes($length));
  }
} 

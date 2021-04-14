<?php


namespace App\Exception;


use Throwable;

class InvalidConfirmationTokenException extends \Exception
{
 public function __construct(
     $message = "",
     $code = 0,
     Throwable $previous = null)
 {
     parent::__construct('Confirmation is not valid', $code, $previous);
 }
}
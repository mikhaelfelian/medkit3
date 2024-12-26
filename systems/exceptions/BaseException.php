<?php

class BaseException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "", $code = 500)
    {
        $this->message = $message;
        $this->code = $code;
        parent::__construct($message, $code);
    }
} 
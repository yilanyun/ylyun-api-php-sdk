<?php

namespace YLYun\Exceptions;

use Exception;

class YLYunException extends Exception {

    function __construct($message, $code=-1) {
        parent::__construct($message, $code);
    }
}

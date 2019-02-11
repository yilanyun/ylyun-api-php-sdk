<?php

namespace YLYun\Exceptions;
class YLYunException extends \Exception {

    function __construct($message, $code=-1) {
        parent::__construct($message, $code);
    }
}

<?php
namespace YLYun\Exceptions;

class APIConnectionException extends YLYunException {

    function __toString() {
        return "\n" . __CLASS__ . " -- {$this->message}[{$this->code}] \n";
    }
}

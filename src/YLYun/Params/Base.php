<?php
/**
 * base入参类
 */

namespace YLYun\Params;

class Base
{
    /**
     * @return array
     */
    public function toArray()
    {
        /*get_class_vars();*/
        return get_object_vars($this);
    }


    /**
     * @return string
     */
    public function toJson()
    {
        /*get_class_vars();*/
        return json_encode($this);
    }


    public function format($params)
    {
        $vAry = $this->toArray();
        foreach ($vAry as $key => $value) {
            $this->$key = $params[$key];
        }
    }
}
<?php

class MY_Library
{

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same syntax as controllers.
     * Copied from system/core/CI_Model.
     * 
     * @param string $var
     * @return mixed
     */
    public function __get($var)
    {
        return get_instance()->$var;
    }
}

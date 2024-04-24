<?php

namespace App\Services;

abstract class BaseService
{
    protected $data;

    public function setParam($data = null)
    {
        $this->data = $data;

        return $this;
    }

    abstract function handle();
}

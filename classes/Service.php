<?php

class Service
{

    public $available = false;

    public function __construct()
    {
        $this->available = true;
    }
    public function __destruct()
    {

    }

    public function all()
    {
        return [
            ['name' => 'consulataion', 'price' => 500, 'days' => ['sun', 'Mon']],
            ['name' => 'Training', 'price' => 200, 'days' => ['Tues', 'Wed']],
            ['name' => 'coding', 'price' => 1000, 'days' => ['sat', 'fri']]
        ];
    }
}
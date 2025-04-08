<?php

class Arrival
{
    private $name;
    private $time;

    public function __construct($name)
    {
        $this->name = $name;
        $this->time = date('H:i:s');
    }

    public function logArrival()
    {
        $isLate = $this->isLate();

        $entry = [
            'name' => $this->name,
            'time' => $this->time,
            'late' => $isLate
        ];

        Helper::addArrival($entry);
    }

    private function isLate()
    {
        $hour = date('H');
        $minute = date('i');

        return $hour > 8 || ($hour == 8 && $minute > 0);
    }

}

<?php

class Helper
{
    public static function getData($filename)
    {
        $json = file_get_contents($filename);
        return json_decode($json, true) ?? [];
    }

    public static function saveData($filename, $data)
    {
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public static function getStudents()
    {
        return self::getData('data/students.json');
    }

    public static function getArrivals()
    {
        return self::getData('data/arrivals.json');
    }

    public static function addStudent($name)
    {
        $students = self::getStudents();
        if (!in_array($name, $students)) {
            $students[] = $name;
            self::saveData('data/students.json', $students);
        }
    }

    public static function addArrival($arrival)
    {
        $arrivals = self::getArrivals();
        $arrivals[] = $arrival;
        self::saveData('data/arrivals.json', $arrivals);
    }

    public static function getArrivalsByStudent($name)
    {
        $arrivals = self::getArrivals();
        return array_filter($arrivals, fn($a) => $a['name'] === $name);
    }
}

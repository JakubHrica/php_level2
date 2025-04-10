<?php
class Student {
    private $name;
    private static $file = 'data/students.json';

    public function __construct($name) {
        $this->name = $name;
    }

    // Uloženie nového/načítanie už existujúceho študenta
    public static function getOrCreate($name) {
        $students = self::getAllStudents();
        if (!in_array($name, $students)) {
            $students[] = $name;
            file_put_contents(self::$file, json_encode($students, JSON_PRETTY_PRINT));
        }
        return $name;
    }

    // Získanie všetkých študentov
    private static function getAllStudents() {
        if (file_exists(self::$file)) {
            $data = file_get_contents(self::$file);
            return json_decode($data, true) ?? [];
        }
        return [];
    }
}
?>

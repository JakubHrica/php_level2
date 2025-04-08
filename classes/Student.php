<?php
class Student {
    private $name;
    private static $file = 'data/students.json';

    public function __construct($name) {
        $this->name = $name;
    }

    // Uloženie nového študenta
    public static function create($name) {
        $students = self::getAllStudents();
        $students[] = $name;
        file_put_contents(self::$file, json_encode($students, JSON_PRETTY_PRINT));
    }

    // Skontroluje, či študent existuje
    public static function exists($name) {
        $students = self::getAllStudents();
        return in_array($name, $students);
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

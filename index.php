<?php
session_start();

require_once 'classes/Helper.php';
require_once 'classes/Student.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získanie mena z formulára
    $name = trim($_POST['name'] ?? '');

    if ($name !== '') { // Kontrola, či meno nie je prázdne
        // Uložíme meno do session
        $_SESSION['student_name'] = $name;

        // Ak študent ešte neexistuje, pridáme ho
        if (!Student::exists($name)) {
            Student::create($name);
        }

        // Presmerovanie na profilovú stránku
        header('Location: profile.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prihlásenie študenta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Prihlásenie</h1>
    <form method="POST">
        <label for="name">Meno študenta:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Prihlásiť sa</button>
    </form>
</div>
</body>
</html>

<?php
session_start();
require_once 'classes/Helper.php';
require_once 'classes/Student.php';
require_once 'classes/Arrival.php';

$studentName = $_SESSION['student_name'];

// Odhlásenie
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Pridanie príchodu
if (isset($_POST['add_arrival'])) {
    $arrival = new Arrival($studentName);
    $arrival->logArrival();
    header("Location: profile.php");
    exit;
}

// Získanie zoznamu príchodov podľa toho, či je user prihlásený ako 'all' alebo ako konkrétny študent
if ($studentName === 'all') {
    $arrivals = Helper::getArrivals();
} else {
    $arrivals = Helper::getArrivalsByStudent($studentName);
}

// Zoradenie príchodov podľa času
usort($arrivals, fn($a, $b) => strtotime($a['time']) <=> strtotime($b['time'])); 

// Zoskupenie príchodov podľa rovnakého dátumu
$groupedArrivals = [];
foreach ($arrivals as $arrival) {
    $date = date('Y-m-d', strtotime($arrival['time'])); // Získanie dátumu (bez času)
    $groupedArrivals[$date][] = $arrival;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil študenta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
    <div class="left">Prihlásený ako: <?= htmlspecialchars($studentName) ?></div>
    <div class="right">Počet príchodov: <?= count($arrivals) ?></div>
</div>

<div class="container">
<form method="POST">
    <?php if ($studentName !== 'all'): ?>
        <button type="submit" name="add_arrival">Zaznač príchod</button>
    <?php endif; ?>
    <button type="submit" name="logout">Odhlásiť sa</button>
</form>


    <h2 style="margin-top: 2rem;">Zoznam príchodov</h2>
    <?php if (empty($arrivals)): ?>
        <p>Žiadne príchody.</p>
    <?php else: ?>
        <?php foreach ($groupedArrivals as $date => $dayArrivals): ?>
            <div class="date-group">
                <div class="date-heading"><?= htmlspecialchars($date) ?></div>
                <?php foreach ($dayArrivals as $index => $arrival): ?>
                    <div class="arrival">
                        <span><?= $index + 1 ?>. <?= htmlspecialchars($arrival['time']) ?></span>
                        <span><?php if ($studentName === 'all') {echo htmlspecialchars($arrival['name']); } ?></span>
                        <span class="note"><?= $arrival['late'] ? 'Meškanie' : '' ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>

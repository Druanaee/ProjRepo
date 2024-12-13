<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/php-main/style.css">
</head>
<body>
<?php
$host = "localhost";
$baza = "projekt";
$user = "root";
$password = "";
$poloczenie = mysqli_connect($host, $user, $password, $baza);
if($poloczenie == null) {
    die("błąd w połączeniu");
}
else {
    echo "połączenie zostało nawiązane";
}
?>
<main>
    <h1>Dodaj wydarzenie</h1>
    <form method="POST" action="./dodaj_wydarzenie.php">
        <label for="i1">Data</label><input name="i1" type="date">
        <label for="i2">Czas</label><input name="i2" type="time">
        <label for="i3">Dane</label><input name="i3" type="text">
        <label>Wyślij zapytanie</label>
        <input type="submit">
    </form>
    <?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Wydarzenie zostało dodane pomyślnie!</p>
    <?php endif; ?>
    <h2>Lista wydarzeń</h2>
<?php
$qu = "SELECT * FROM wydarzenia";
$rezultat = mysqli_query($poloczenie, $qu);
if ($iwiersz = mysqli_fetch_array($rezultat)) {
    echo '<p>' . htmlspecialchars($iwiersz["opis"]) . '</p>';
    echo '<p>' . htmlspecialchars($iwiersz["wydarzenie_czas"]) . '</p>';
    echo '<p>' . htmlspecialchars($iwiersz["wydarzenie_data"]) . '</p>';
}
?>
</main>
</body>
</html>
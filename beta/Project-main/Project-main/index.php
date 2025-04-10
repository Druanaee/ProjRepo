<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./stylecalendar.css">
    <script src="./themechange.js"></script>
</head>
<body class="dark">
<?php
    require_once('./database.php');

    $token = $_COOKIE['access_token'];
    if (!isset($token)) {
        header('Location: http://notik.nameless.pw/Project-main/login.html');
        exit();
    }

    $escaped_token = mysqli_real_escape_string($conn, $token);

    $get_user_id_query = "SELECT UserId FROM access_tokens WHERE Token = '$escaped_token'";
    $get_user_id_result = mysqli_query($conn, $get_user_id_query);
    if (!$get_user_id_result) {
        die('Error getting UserID by Token: ' . mysqli_error($conn));
    }

    $user_id = mysqli_fetch_assoc($get_user_id_result)['UserId'];

    if (!isset($user_id)) {
        header('Location: http://notik.nameless.pw/Project-main/login.html');
        exit();
    }
?>
<header>
    <img src="./logo no text.png" alt="logonotexterror" id="logo">
    <div>
            <button id="themeToggle"></button>
            <button id="login">Login</button>
    </div>
</header>
<nav>
    <ul>
        <li><a id="firstnavlink" href="http://notik.nameless.pw/Project-main/kalendarz.php">Calendar</a></li>
        <li><a href="http://notik.nameless.pw/Project-main/index.html">Strona główna</a></li>
    </ul>
</nav>
<main>
    <h1>Dodaj wydarzenie</h1>
    <?php if (isset($_GET['success'])): ?>
    <!-- <p style="color: green;">Wydarzenie zostało dodane pomyślnie!</p> -->
    <?php endif; ?>
    <form method="POST" action="./dodaj_wydarzenie.php">
        <div>
            <label for="date">Date</label>
            <input id="date" name="date" type="date">
        </div>
        <div>
            <label for="time">Time</label>
            <input id="time" name="time" type="time">
        </div>
        <div>
            <label for="description">Description</label>
            <input id="description" name="description" type="text">
        </div>
        <input type="submit" id="mainsubm">
    </form>
    <h2>Lista wydarzeń</h2>
    <table>
        <tr id="list">
            <th id="listdate">Date</th>
            <th id="listtime">Time</th>
            <th id="listdata">Description</th>
            <th id="listbuttons">Controls</th>
        </tr>
    <?php
        $query = "SELECT * FROM db WHERE `OwnerId` = '$user_id'";
        $result = mysqli_query($conn, $query);
        while ($record = mysqli_fetch_array($result)):
    ?>
        <tr>
            <td id="date"><?php echo htmlspecialchars($record["Date"]); ?></td>
            <td id="time"><?php echo htmlspecialchars($record["Time"]); ?></td>
            <td id="description"><?php echo htmlspecialchars($record["Description"]); ?></td>
            <td id="deleteandsubmit">
                <form method="POST" action="./edytuj_wydarzenie.php">
                    <input type="hidden" name="id" value="<?php echo $record["id"]; ?>">
                    <input type="submit" value="Edit" id="submit">
                </form>

                <form method="POST" action="./usun_wydarzenie.php">
                    <input type="hidden" name="id" value="<?php echo $record["id"]; ?>">
                    <input type="submit" value="Delete" id="delete">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </table>
</main>
</body>
</html>

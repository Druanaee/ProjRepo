<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./stylecalendar.css">
    <script src="./themechange.js"></script>
    <script src="./BackHome.js"></script>
    <script src="login(костыль).js"></script>
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
      <button id="logo"></button>
        <div id="themeToggleDiv">
            <button id="themeToggle"></button>
            <button id="login">Logout</button>
        </div>
    </header>
<main>
    <table>
        <tr id="list">
            <th id="listdate">Date</th>
            <th id="listtime">Time</th>
            <th id="listdata">Description</th>
            <th id="listbuttons">Controls</th>
        </tr>
        <form method="POST" action="./dodaj_wydarzenie.php">
            <td id="date">
                <div>
                    <input id="date" name="date" type="date">
                </div>
            </td>
            <td id="time">
                <div>
                    <input id="time" name="time" type="time">
                </div>
            </td>
            <td id="description">            
                <div>
                    <input id="description" name="description" type="text">
                </div>
            </td>
            <td id="deleteandsubmit"><input type="submit" id="mainsubm"></td>
        </form>
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

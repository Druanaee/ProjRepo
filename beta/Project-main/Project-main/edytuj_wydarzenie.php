<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('./database.php');
    $id = $_POST["id"];
    $query = "SELECT * FROM db WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $smth = mysqli_fetch_array($result);
    if($smth):
?>
<form method="POST" action="./update.php"> 
    <input type="hidden" name="id" value="<?php echo $smth["id"]; ?>">

    <label for="date">Date</label>
    <input name="date" type="date" value="<?php echo htmlspecialchars($smth["Date"]); ?>">
    
    <label for="time">Time</label>
    <input name="time" type="time" value="<?php echo htmlspecialchars($smth["Time"]); ?>">
    
    <label for="description">Description</label>
    <input name="description" type="text" value="<?php echo htmlspecialchars($smth["Description"]); ?>">
    
    <input type="submit" value="Confirm">
</form>
<a href="http://notik.nameless.pw/Project-main/index.php">Powrót do dodawania wydarzeń</a>
<?php
endif;
}
?>
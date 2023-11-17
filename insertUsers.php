<?php
    require_once "conn.php";
    $team = $_POST['teamcode'];
    $batch = $_POST['batch'];
    for($i=0;$i<count($_POST['names']);$i++){
        $name = $_POST['names'][$i]['pname'];
        $sql = "INSERT INTO playerdata (`teamcode`, `userid`, `name`, `batch`) VALUES ('$team', '$i', '$name', '$batch');";
        mysqli_query($conn,$sql) or die("Failed");
    }
    echo "Success";
?>
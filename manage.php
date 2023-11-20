<?php
    require_once "conn.php";

    if($_GET['for']=="complete"){
        $team = $_GET['team'];
        $sql = "SELECT attempted FROM playerdata WHERE teamcode='$team';";
        $res = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);
        $last = $row['attempted'];
        while($row = mysqli_fetch_assoc($res)){
            if($row['attempted']!=$last){
                echo '0';
                return;
            }
        }
        // $sql = "UPDATE `playerdata` SET `attempted` = 0 WHERE `playerdata`.`teamcode` = '$team'";
        // mysqli_query($conn,$sql) or die("failed");
        echo '1';
    }else if($_GET['for']=="details"){
        $team = $_GET['team'];
        $sql = "SELECT * FROM playerdata WHERE teamcode='$team';";
        $res = mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
            $arr = mysqli_fetch_all($res,MYSQLI_ASSOC);
            echo json_encode($arr);
        }
    }else if($_GET['for']=="submit"){
        $team = $_GET['team'];
        $uid = $_GET['uid'];
        $pts = $_GET['pts'];
        $time = $_GET['time'];
        $sql = "UPDATE `playerdata` SET `points` = points+$pts, `attempted` = attempted+1, `time`=$time WHERE `playerdata`.`teamcode` = '$team' AND `playerdata`.`userid` = $uid";
        mysqli_query($conn,$sql) or die("failed");
        echo "success";
    }else if($_GET['for']=="leaderboard"){
        $team = $_GET['team'];
        $sql = "SELECT name as 'playername',points,time FROM playerdata WHERE teamcode='$team';";
        $res = mysqli_query($conn,$sql);
        $row = mysqli_fetch_all($res,MYSQLI_ASSOC);
        echo json_encode($row);
    }else if($_GET['for']=="setQno"){
        $team = $_GET['team'];
        $qno = $_GET['qno'];
        $sql = "UPDATE on_q SET qno=$qno WHERE teamcode='$team'";
        mysqli_query($conn,$sql) or die("failed");
    }else if($_GET['for']=="getQno"){
        $team = $_GET['team'];
        $sql = "SELECT qno FROM on_q WHERE teamcode='$team';";
        $res = mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($res);
        echo $row['qno'];
    }
?>
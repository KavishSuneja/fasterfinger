<!-- <pre> -->
<?php
    require_once "conn.php";
    $team = $_GET['team'];
    $sql = "SELECT * FROM playerdata WHERE teamcode='$team';";
    $res = mysqli_query($conn,$sql);
    $playerData = [];
    $batch = "";
    while($row = mysqli_fetch_assoc($res)){
        array_push($playerData,$row['name']);
        $batch = $row['batch'];
    }
    // print_r($playerData);
    $sql = "SELECT * FROM questions WHERE batch='$batch';";
    $res = mysqli_query($conn,$sql);
    $questionData = mysqli_fetch_all($res,MYSQLI_ASSOC);
    // print_r($questionData);
?>
<!-- </pre> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="quiz.css">
    <style>
        .quiz-btn-radio:checked+label .quiz-btn {
            background: linear-gradient(to right, #FF6400, #FFAE15);
            border: none;
        }

        .quiz-btn-radio {
            display: none;
        }
    </style>
</head>

<body>
    <div class="div-main">
        <div class="div-grid">
        <div class="quiz-left">
                <img src="images/logo (2).png" alt="Image not Found" class="logo-img">
                <span class="quiz-question">Arrange the following in ascending order</span>
                <div class="quiz-choices-outer">
                    <div class="quiz-choices">
                        <span class="quiz-choice optionone">a] 10asfasddd</span>
                        <span class="quiz-choice optiontwo">b] 10asdf</span>
                    </div>
                    <div class="quiz-choices">
                        <span class="quiz-choice optionthree">a] 10asfasddd</span>
                        <span class="quiz-choice optionfour">a] 10asdf</span>
                    </div>
                </div>

                <div class="quiz-form">
                    <!-- <input type="radio" id="opt1" name="age" value="" class="quiz-btn-radio"> -->
                    <label for="opt1"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">A</div>
                            <span class="quiz-frm-ques sp choiceone">a,b,c,d</span>
                        </div>
                    </div></label>
                    <!-- <input type="radio" id="opt2" name="age" value="" class="quiz-btn-radio"> -->

                    <label for="opt2"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">B</div>
                            <span class="quiz-frm-ques sp choicetwo">a,b,c,d</span>
                        </div>
                    </div></label>
                    


                    <!-- <input type="radio" id="opt3" name="age" value="" class="quiz-btn-radio"> -->

                    <label for="opt3"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">C</div>
                            <span class="quiz-frm-ques sp choicethree">a,b,c,d</span>
                        </div>
                    </div></label>
                    


                    <!-- <input type="radio" id="opt4" name="age" value="" class="quiz-btn-radio"> -->
                
                    <label for="opt4"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">D</div>
                            <span class="quiz-frm-ques sp choicefour">a,b,c,d</span>
                        </div>
                    </div></label>
                    </div><br><br>
                    <!-- <input type="submit" value="Show" class="showbtn"> -->
                    <input type="submit" value="Show" class="showbtn">
                    <input type="submit" value="Next" class="submitbtn">
                </div>
            </div>


            <div class="quiz-right">
                <h2 class="lead_header">Leaderboard</h2>
                <div class="headers">
                    <span class='head_val'>Rank</span>
                    <span class='head_val'>Name</span>
                    <span class='head_val'>Points</span>
                    <span class='head_val'>Seconds</span>

                </div>
                
                <?php
                    /* for($i=0;$i<count($playerData);$i++){
                ?>
                    <div class="data">
                        <span class='data_val' id="rank" class="<?php echo "rank_".$i; ?>">#1</span>
                        <span class='data_val' id="name"><?php echo $playerData[$i]['']; ?></span>
                        <span class='data_val' id="pts" <?php echo "pts_".$i; ?>><?php echo $playerData[$i]; ?></span>
                        <span class='data_val' id="time" <?php echo "time_".$i; ?>>0</span>
                    </div>
                <?php
                    } */
                ?>
            </div>


        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        let questions = <?php echo json_encode($questionData); ?>;
        function next(data){
            console.log(data);
            $(".quiz-btn").each((key,element)=>{
                $(element).css("background-color","black");
            })
            $('.quiz-question').text(data.question);
            $('.optionone').text(data.opt1);
            $('.optiontwo').text(data.opt2);
            $('.optionthree').text(data.opt3);
            $('.optionfour').text(data.opt4);
            $('.choiceone').text(data.choice1);
            $('.choicetwo').text(data.choice2);
            $('.choicethree').text(data.choice3);
            $('.choicefour').text(data.choice4);
            // $('#opt1').val(data.choice1);
            // $('#opt2').val(data.choice2);
            // $('#opt3').val(data.choice3);
            // $('#opt4').val(data.choice4);
        }
        let n=0;
        let lastQues = false;
        let waiting=false;
        next(questions[n]);
        $('.submitbtn').click(function(){
            if(lastQues){
                alert("Quiz Over!");
                return;
            }
            n++;
            next(questions[n])
            if(!questions[n+1]){
                lastQues=true;
                $(".submitbtn").val("End");
            }
        });
        $('.showbtn').click(function(){
            $(".sp").each((key,element) => {
                if($(element).text()==questions[n].correctans){
                    $(element).parent().parent().css("background-color","green")
                }
            });
        })
        $(document).ready(function(){
            next(questions[0])
            setInterval(()=>{
                $.ajax({
                    method:"GET",
                    url:"manage.php",
                    data:{
                        for:"complete",
                        team:"<?php echo $_GET['team']; ?>"
                    },
                    success:(data)=>{
                        console.log(data);
                        if(data=='1' && waiting==true){
                            waiting=false;
                            alert("everyone has completed");
                        }else if(data=='0'){
                            waiting=true;
                        }
                    }
                })
            },1000);
        })

    </script>
</body>

</html>
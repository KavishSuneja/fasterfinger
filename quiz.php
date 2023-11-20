<!-- <pre> -->
<?php
    require_once "conn.php";
    $team = $_GET['team'];
    $sql = "SELECT name as 'playername',points,time FROM playerdata WHERE teamcode='$team';";
    $res = mysqli_query($conn,$sql);
    $playerData = mysqli_fetch_all($res,MYSQLI_ASSOC);
    $sql = "SELECT DISTINCT questions.batch,questions.qno,questions.question,questions.opt1,questions.opt2,questions.opt3,questions.opt4,questions.choice1,questions.choice2,questions.choice3,questions.choice4,questions.correctans FROM questions LEFT JOIN playerdata ON questions.batch=playerdata.batch WHERE playerdata.teamcode='$team'";
    $res = mysqli_query($conn,$sql);
    $questionData = mysqli_fetch_all($res,MYSQLI_ASSOC);
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
                    <div class="submit-div">
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
                    <div class="data_outer"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        let questions = <?php echo json_encode($questionData); ?>;

        let leadarray = <?php echo json_encode($playerData); ?>;


      function upload_leaderboard(){
            leadarray.sort(function (a, b) {
                // First, compare points
                if (b.points !== a.points) {
                    return b.points - a.points;
                }
                // If points are the same, compare time
                return a.time - b.time;
            });
            for(i=0; i<leadarray.length; i++){
                $('.data_outer').append(`<div class="data">
                    <span class='data_val' id="rank" >${i+1}</span>
                    <span class='data_val' id="name">${leadarray[i]['playername']}</span>
                    <span class='data_val' id="pts">${leadarray[i]['points']}</span>
                    <span class='data_val' id="time" >${leadarray[i]['time']}</span>
                </div>`)
        
            }
        }
        function next(data){
            console.log(data);
            $.ajax({
                method:"GET",
                url:"manage.php",
                data:{
                    for:"setQno",
                    team:"<?php echo $_GET['team']; ?>",
                    qno:n
                },
            })
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
            upload_leaderboard(leadarray);
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
                            $.ajax({
                                method:"GET",
                                url:"manage.php",
                                data:{
                                    for:"leaderboard",
                                    team:"<?php echo $_GET['team']; ?>"
                                },
                                success:(data)=>{
                                    console.log(JSON.parse(data));
                                    leadarray=JSON.parse(data);
                                    $(".data_outer").html(" ")
                                    upload_leaderboard(leadarray);
                                }
                            })
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
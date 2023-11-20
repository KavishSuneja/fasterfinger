<!-- <pre> -->
<?php
    require_once "conn.php";
    $team = $_GET['team'];
    $sql = "SELECT * FROM playerdata WHERE teamcode='$team';";
    $res = mysqli_query($conn,$sql);
    $batch = "";
    while($row = mysqli_fetch_assoc($res)){
        $batch = $row['batch'];
        break;
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

        .div-grid{
            display: block;
        }
        .submitbtn{
            align-self: flex-end;
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
                    <input type="radio" id="opt1" name="age" value="" class="quiz-btn-radio">
                    <label for="opt1"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">A</div>
                            <span class="quiz-frm-ques sp choiceone">a,b,c,d</span>
                        </div>
                    </div></label>
                    <input type="radio" id="opt2" name="age" value="" class="quiz-btn-radio">

                    <label for="opt2"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">B</div>
                            <span class="quiz-frm-ques sp choicetwo">a,b,c,d</span>
                        </div>
                    </div></label>
                    


                    <input type="radio" id="opt3" name="age" value="" class="quiz-btn-radio">

                    <label for="opt3"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">C</div>
                            <span class="quiz-frm-ques sp choicethree">a,b,c,d</span>
                        </div>
                    </div></label>
                    


                    <input type="radio" id="opt4" name="age" value="" class="quiz-btn-radio">
                
                    <label for="opt4"><div type="submit" class="quiz-btn">
                        <div class="btn-div">
                            <div class="quiz-letter">D</div>
                            <span class="quiz-frm-ques sp choicefour">a,b,c,d</span>
                        </div>
                    </div></label>
                    </div><br><br>
                    <input type="submit" value="Next" class="submitbtn">
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script>
        let questions = <?php echo json_encode($questionData); ?>;
        let ansArray = []
        function next(data){
            console.log(data);
            $('.quiz-question').text(data.question);
            $('.optionone').text(data.opt1);
            $('.optiontwo').text(data.opt2);
            $('.optionthree').text(data.opt3);
            $('.optionfour').text(data.opt4);
            $('.choiceone').text(data.choice1);
            $('.choicetwo').text(data.choice2);
            $('.choicethree').text(data.choice3);
            $('.choicefour').text(data.choice4);
            $('#opt1').val(data.choice1);
            $('#opt2').val(data.choice2);
            $('#opt3').val(data.choice3);
            $('#opt4').val(data.choice4);
        }
        let n = 0;
        const constAns = 1;
        let timeTaken = 1;
        let startTime = new Date();
        let endTime = new Date();
        $(document).ready(function(){
            next(questions[n])
            $('.submitbtn').click(function(){
                let endTime = new Date();
                timeTaken = 400 - (Math.floor( ((endTime - startTime) / 100) ));
                $('.submitbtn').css("display","none")
                $.ajax({
                    method:"GET",
                    url:"manage.php",
                    data:{
                        team:"<?php echo $_GET['team']; ?>",
                        uid:"<?php echo $_GET['uid']; ?>",
                        for:"submit",
                        pts:$('input[name="age"]:checked').val()==questions[n].correctans ? constAns * timeTaken : 0,
                        time:(Math.floor(((endTime - startTime) / 100))/10)
                    },
                    success:(data)=>{
                        if(data=="failed"){
                            alert("error")
                        }
                    }
                })
            });
            setInterval(function(){
                $.ajax({
                    method:"GET",
                    url:"manage.php",
                    data:{
                        team:"<?php echo $_GET['team']; ?>",
                        for:"getQno",
                    },
                    success:(data)=>{
                        if(data>n){
                            console.log("Next Question!");
                            n++;
                            next(questions[n]);
                            startTime = new Date();
                            $(".submitbtn").css("display","block")
                        }
                    }
                })
            },1000)
        })
        // $(document).ready(function(){
        //     next(questions[n])
        //     $('.submitbtn').click(function(){
        //         $.ajax({
        //             method:"GET",
        //             url:"manage.php",
        //             data:{
        //                 uid:"<?php /*echo $_GET['uid']; ?>",
        //                 team:"<?php echo $_GET['team']; ?>",
        //                 for:"complete",
        //             },
        //             success:(data)=>{
        //                 console.log(data);
        //                 if(data=="0" && n>0){
        //                     alert("everyone is not complete yet!");
        //                 }else{
        //                     n++;
        //                     ansArray.push($('input[name="age"]:checked').val());
        //                     $.ajax({
        //                         method:"GET",
        //                         url:"manage.php",
        //                         data:{
        //                             team:"<?php echo $_GET['team']; ?>",
        //                             uid:"<?php echo $_GET['uid'];*/ ?>",
        //                             for:"submit",
        //                             pts:$('input[name="age"]:checked').val()==questions[n-1].correctans ? constAns * timeTaken : 0
        //                         },
        //                         success:(data)=>{
        //                             if(data=="failed"){
        //                                 alert("error")
        //                             }
        //                         }
        //                     })
        //                     if(lastQues){
        //                         console.log("submitted");
        //                         console.log(ansArray);
        //                         alert("ended")
        //                         return
        //                     }
        //                     if(!questions[n+1]){
        //                         lastQues=true;
        //                         $('.submitbtn').val("Submit")
        //                     }
        //                     next(questions[n])
        //                 }
        //             }
        //         })
        //     })
        // })
    </script>
</body>

</html>
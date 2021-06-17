<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>스마트 초인종</title>

        <!-- JQuery 라이브러리 설정 -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

        <!--폰트-->
        <link rel="stylesheet" href="https://unpkg.com/@kfonts/nanum-handwritting-neulisneulische/index.css" />

        <!-- CSS -->
        <style>
            body {background-image:url("./img/background.png"); background-position:top; background-repeat: no-repeat; background-size: 100% 100%;
                text-align: center; font-family: "나눔손글씨 느릿느릿체", "나눔손글씨느릿느릿체", "nanum-handwritting-neulisneulische";}
            h1 {margin:2%; padding:2%; font-size:50px;}
            div {margin:3%; padding:2%; font-size:20px;}

            /*채팅, 방문기록조회, 알림설정 버튼*/
            .homepage_image {width:10%; height:10%;}
            .homepage_button_image {width:100%; height:100%;}
            .homepage_button {width:50%; height:30%; background-color:white; border:none;}
        </style>
        
    </head>

    <body>
		<?php
    
    $conn= mysqli_connect("localhost","root","741010","smartbell");
    $sql="
        INSERT INTO topic
        (who,purpose,created,chat)
        VALUES(
            '{$_POST['who']}','{$_POST['purpose']}',NOW(),'{$_POST['chat']}'
            )
    ";
    mysqli_query($conn,$sql);
    
 
    ?>
        <h1>스마트 초인종</h1>
        
        <!--카메라 스트리밍-->
      

        <!--채팅 버튼-->
        <div>
            <img class="homepage_image" src="./img/chatting_image.png" alt="채팅 이미지">
            <button class="homepage_button" value="채팅하기" onclick="window.location.href='http://3bee631eb419.ngrok.io '"><img class="homepage_button_image" src="./img/chatting_button.png"></button>
        </div>


        <div>
            <img class="homepage_image" src="./img/home_button.png" alt="나가기">
            <button class="homepage_button" value="나가기" onclick="window.location.href='https://smartbell-othij.run.goorm.io/'"><img class="homepage_button_image" src="./img/exit.png"></button>
        </div>

       <div>


       </div>
    </body>
</html>
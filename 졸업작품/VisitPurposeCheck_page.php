top<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>스마트 초인종</title>

        <!--폰트-->
        <link rel="stylesheet" href="https://unpkg.com/@kfonts/nanum-handwritting-neulisneulische/index.css" />

        <!--CSS-->
        <style>
         	body {background-image:url("./img/background.png"); background-position:top; background-repeat: no-repeat; background-size: 100% 100%;
				text-align: center; font-family: "나눔손글씨 느릿느릿체", "나눔손글씨느릿느릿체", "nanum-handwritting-neulisneulische"; font-size:20px;}
			h1 {margin:2%; padding:2%; font-size:50px;}
			table{width:50%; height:20%; margin:auto;}
			table, th, td{margin:auto; border-radius:10px; border-collapse:collapse;}
			th {background-color: #FEE2F7;}
			td {background-color: #FFF3FC;}

			/*홈버튼*/
			.home_button_image {width:100%; height:100%;}
			.home_button {width:8%; height:8%; background-color:white; border-radius:10px; border:none; margin:1%; padding:0%; float:left;}
        </style>
    </head>
    <body>
    	<!--홈 버튼-->
        <button  class="home_button" onclick="window.location.href='SmartBell_homepage.php'"><img class="home_button_image" src="./img/home_button.png"></button>

        <h1>방문목적조회</h1>
    
        <!--방문목적 테이블-->
        <?php
            $conn = mysqli_connect("localhost", "root", "741010" , "smartbell");
            $sql = "SELECT * FROM topic";
            $result = mysqli_query($conn, $sql);

     

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "아이디 : " . $row["id"]. " 이름: " . $row["who"].
                    "목적: ". $row["purpose"]." 시간: ".
                    $row["created"] ." 방문이유: ".$row["chat"]."<br>";
                }
            }
            else{
                echo "테이블에 데이터가 없습니다.";
            }
            mysqli_close($conn); // 디비 접속 닫기
        ?>
    </body>
</html>
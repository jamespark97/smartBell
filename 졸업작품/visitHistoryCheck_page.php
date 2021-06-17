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
            table{width:50%; height:20%; margin:auto;}
            table, th, td{margin:auto; border-radius:10px; border-collapse:collapse;}
            th {background-color: #FEE2F7;}
            td {background-color: #FFF3FC;}

            /*홈버튼*/
            .home_button_image {width:100%; height:100%;}
            .home_button {width:8%; height:8%; background-color:white; border-radius:10px; border:none; margin:1%; padding:0%; float:left;}

            /*방문기록/목적조회 버튼*/
            .visithistorycheckpage_button_image {width:100%; height:100%;}
            .visithistorycheckpage_button {width:40%; height:30%; background-color:white; border:none;}

            /*날짜 입력*/
            .input_visit_date {width:20%; height:30%; border-radius:10px;
    text-align:center; font-size:20px; font-family: "나눔손글씨 느릿느릿체", "나눔손글씨느릿느릿체", "nanum-handwritting-neulisneulische";}
        </style>

        <!--JavaCript-->
        <script>
            // 방문기록 조회 버튼
            function VisitHistoryCheck(){
                var start_date = document.getElementById('start_date').value;
                var start_time = document.getElementById('start_time').value;
                var end_date = document.getElementById('end_date').value;
                var end_time = document.getElementById('end_time').value;
                var date_time = "/log?from=" + start_date + " " + start_time +":00&to="+ end_date + " "+ end_time + ":00";
                invokeGetLogAPI(date_time);
            }

            // AWS DynamoDB에서 방문기록 조회
            var invokeGetLogAPI = function(date_time) {
                // 디바이스 조회 URI
                // production 스테이지 편집기의 맨 위에 있는 "호출 URL/devices/IoTSmartWindowData"로 대체해야 함
                var API_URI = 'https://izpr4ttkc5.execute-api.ap-northeast-1.amazonaws.com/production/devices/IoTSmartBell' + date_time;                 
                $.ajax(API_URI, {
                    method: 'GET',
                    contentType: "application/json",

                    success: function (data, status, xhr) {
                            var result = JSON.parse(data);
                            print_VisitHistory_log(result);
                            console.log("data="+data);
                    },
                    error: function(xhr,status,e){
                            alert("error");
                    }
                });
            };

            // 방문기록 테이블에 출력
            function print_VisitHistory_log(result) {
                // 테이블 생성
                $('#VisitHistory_log').empty()
                var tr1 = document.createElement("tr");
                var th1 = document.createElement("th");
                var th2 = document.createElement("th");
                th1.innerText = "날짜 시간";
                th2.innerText = "방문자 종류";
                tr1.append(th1);
                tr1.append(th2);
                $('#VisitHistory_log').append(tr1);

                // 방문기록 출력
                for(idx in result.data){
                    // AWS DynamoDB에서 불러온 값
                    var time = result.data[idx].timestamp;
                    var visitor = result.data[idx].ButtonState;
                    switch(visitor){
                        case "BUTTON_IN":
                            visitor = "집방문";
                            break;
                        case "BUTTON_MEET":
                            visitor = "잠깐대면";
                            break;
                        case "BUTTON_OUT":
                            visitor = "비대면";
                            break;
                        default:
                            break;
                    }
                    // 테이블에 출력
                    var tr2 = document.createElement("tr");
                    var td1 = document.createElement("td");
                    var td2 = document.createElement("td");
                    td1.innerText = time;
                    td2.innerText = visitor;
                    tr2.append(td1);
                    tr2.append(td2);
                    $('#VisitHistory_log').append(tr2);
                }
            }
        </script>
        
    </head>
    <body>
        <!--홈 버튼-->
        <button  class="home_button" onclick="window.location.href='SmartBell_homepage.php'"><img class="home_button_image" src="./img/home_button.png"></button>
        
        <h1>방문기록조회</h1>
        
        <!--조회 기간 입력-->
        <div>
            <input class="input_visit_date" type="date" value="2021-05-01" id="start_date"/>
            <input class="input_visit_date" type="time" value="00:00" id="start_time"/>
            ~
            <input class="input_visit_date" type="date" value="2021-05-31" id="end_date"/>
            <input class="input_visit_date" type="time" value="00:00" id="end_time"/>
            <br>
        </div>

        <!--방문기록 조회 버튼 & 방문목적 조회 버튼-->
        <div>
            <button class="visithistorycheckpage_button" value="방문기록 조회하기" onclick="VisitHistoryCheck()"><img class="visithistorycheckpage_button_image" src="./img/visithistory_button.png"></button>

            <button class="visithistorycheckpage_button" value="방문목적 조회하기" onclick="window.location.href='VisitPurposeCheck_page.php'"><img class="visithistorycheckpage_button_image" src="./img/visitpurpose_button.png"></button>
        </div>

        <!--방문기록 테이블-->
        <div>
            <table id="VisitHistory_log"></table>
        </div>

        <div id="VisitPurpose_log">
        </div>
    </body>
</html>

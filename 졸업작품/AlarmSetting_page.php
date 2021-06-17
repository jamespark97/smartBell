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

            /*홈버튼*/
            .home_button_image {width:100%; height:100%;}
            .home_button {width:8%; height:8%; background-color:white; border-radius:10px; border:none; margin:1%; padding:0%; float:left;}

            /*알림 ON/OFF 버튼*/
            .alarmsettingpage_button_image {width:100%; height:100%;}
            .alarmsettingpage_button {width:40%; height:30%; background-color:white; border:none;}

            /*알림 상태*/
            .mark {width: 10%; background-color:#FADEE1; font-size:20px;}
        </style>

        <!--JavaScript-->
        <script>
            var payload;

            window.onload = function(){
                invokeGetDeviceAPI("refresh");
            }

            // AWS에서 알림 상태 가져오는 함수
            function invokeGetDeviceAPI(state) {
                // 디바이스 조회 URI
                // production 스테이지 편집기의 맨 위에 있는 "호출 URL/devices/IoTSmartWindow"로 대체해야 함
                var API_URI = 'https://izpr4ttkc5.execute-api.ap-northeast-1.amazonaws.com/production/devices/IoTSmartBell';                 
                $.ajax(API_URI, {
                    method: 'GET',
                    contentType: "application/json",

                    success: function (data, status, xhr) {
                            var result = JSON.parse(data);
                            console.log("data="+data);
                            if(state == "refresh"){
                                printAlarmState(result);  // 성공시, 데이터 출력을 위한 함수 호출
                            }
                            else if(state == "Buzzer_Alarm"){
                                printBuzzerState(result);
                            }
                            else if(state == "LED_Alarm"){
                                printLEDState(result);
                            }
                    },
                    error: function(xhr,status,e){
                            alert("error");
                    }
                });
            };

            function printAlarmState(data){
                Buzzer_State = data.state.reported.BuzzerState;
                LED_State = data.state.reported.LEDState;

                console.log(Buzzer_State);
                console.log(LED_State);

                switch(Buzzer_State){
                    case "ALARM_ON":
                        document.getElementById("BuzzerAlarm_State").innerHTML = "켜짐";
                        document.getElementById("BuzzerAlarm_button").value = "ALARM_ON";
                        document.getElementById("BuzzerAlarm_image").src = "./img/buzzer_off_button.png";
                        break;
                    case "ALARM_OFF":
                        document.getElementById("BuzzerAlarm_State").innerHTML = "꺼짐";
                        document.getElementById("BuzzerAlarm_button").value = "ALARM_OFF"
                        document.getElementById("BuzzerAlarm_image").src = "./img/buzzer_on_button.png";
                        break;
                }

                switch(LED_State){
                    case "ALARM_ON":
                        document.getElementById("LEDAlarm_State").innerHTML = "켜짐";
                        document.getElementById("LEDAlarm_button").value = "ALARM_ON";
                        document.getElementById("LEDAlarm_image").src = "./img/led_off_button.png";
                        break;
                    case "ALARM_OFF":
                        document.getElementById("LEDAlarm_State").innerHTML = "꺼짐";
                        document.getElementById("LEDAlarm_button").value = "ALARM_OFF"
                        document.getElementById("LEDAlarm_image").src = "./img/led_on_button.png";
                        break;
                }
            }

            // 소리 알림 버튼
            function BuzzerAlarm_change() {
                var Buzzer_State = document.getElementById("BuzzerAlarm_button").value;
                switch(Buzzer_State){
                    case "ALARM_ON":
                        document.getElementById("BuzzerAlarm_button").value = "ALARM_OFF";
                        document.getElementById("BuzzerAlarm_State").innerText = "꺼짐"
                        document.getElementById("BuzzerAlarm_image").src = "./img/buzzer_on_button.png";
                        payload = {tags: [{tagName: "BuzzerState", tagValue:"ALARM_OFF"}]};
                        break;
                    case "ALARM_OFF":
                        document.getElementById("BuzzerAlarm_button").value = "ALARM_ON"
                        document.getElementById("BuzzerAlarm_State").innerText = "켜짐"
                        document.getElementById("BuzzerAlarm_image").src = "./img/buzzer_off_button.png";
                        payload = {tags: [{tagName: "BuzzerState", tagValue:"ALARM_ON"}]};
                        break;
                }
                invokeAPI("소리");
            }

            // LED 알림 버튼
            function LEDAlarm_change() {
                var LED_State = document.getElementById("LEDAlarm_button").value;
                switch(LED_State){
                    case "ALARM_ON":
                        document.getElementById("LEDAlarm_button").value = "ALARM_OFF";
                        document.getElementById("LEDAlarm_State").innerText = "꺼짐"
                        document.getElementById("LEDAlarm_image").src = "./img/led_on_button.png";
                        payload = {tags: [{tagName: "LEDState", tagValue:"ALARM_OFF"}]};
                        break;
                    case "ALARM_OFF":
                        document.getElementById("LEDAlarm_button").value = "ALARM_ON"
                        document.getElementById("LEDAlarm_State").innerText = "켜짐"
                        document.getElementById("LEDAlarm_image").src = "./img/led_off_button.png";
                        payload = {tags: [{tagName: "LEDState", tagValue:"ALARM_ON"}]};
                        break;
                }
                invokeAPI("빛");
            }

            

            // AWS에 payload 전송
            var invokeAPI = function(alarm) {
                // 디바이스 조회 URI
                var API_URI = 'https://izpr4ttkc5.execute-api.ap-northeast-1.amazonaws.com/production/devices/IoTSmartBell';
                
                  
                $.ajax(API_URI, {
                    method: 'PUT',
                    contentType: "application/json",
                    data: JSON.stringify(payload),

                    success: function (data, status, xhr) {
                            var result = JSON.parse(data);
                            window.alert(alarm + " 알람 설정 완료!");
                    },
                    error: function(xhr,status,e){
                            alert("error");
                    }
                });
            };
        </script>

    </head>
    <body>
        <!--홈 버튼-->
        <button  class="home_button" onclick="window.location.href='SmartBell_homepage.php'"><img class="home_button_image" src="./img/home_button.png"></button>

        <h1>알람 설정</h1>

        <!--알림 현재 상태 테이블-->
        <div>
            <mark class="mark">소리 알림: <span id="BuzzerAlarm_State"></span></mark>
            <mark class="mark">빛 알림: <span id="LEDAlarm_State"></span></mark>
        </div>


        <!--알림 ON/OFF 버튼-->
        <div>
            <!--소리 알림 버튼-->
            <button  class="alarmsettingpage_button" id="BuzzerAlarm_button" value="ALARM_ON" onclick="BuzzerAlarm_change()"><img class="alarmsettingpage_button_image" id="BuzzerAlarm_image"></button>

            <!--빛 알림 버튼-->
            <button  class="alarmsettingpage_button" id="LEDAlarm_button" value="ALARM_ON" onclick="LEDAlarm_change()"><img class="alarmsettingpage_button_image" id="LEDAlarm_image"></button>
        </div>
    </body>
</html>
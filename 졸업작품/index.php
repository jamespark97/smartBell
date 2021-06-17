<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>스마트초인종</title>
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>

   <script src="update_visitor_data.js"></script>
   <link rel="stylesheet" href="https://unpkg.com/@kfonts/nanum-handwritting-neulisneulische/index.css" />
   <style>

       body {background-image:url("./img/background.png"); background-position:top; background-repeat: no-repeat; background-size: 100% 100%; font-family: "나눔손글씨 느릿느릿체", "나눔손글씨느릿느릿체", "nanum-handwritting-neulisneulische"; font-size:20px;}


      .sizedown{
         display: none;
               }

      h1 {margin:5%; text-align:center; font-size:50px;}
      
      .div {margin:5% 5%; padding: 2%;}
      
      fieldset {border-style:dashed;border-color:#99CCFF; border-radius:50px;}
      
      legend {text-align:center; font-size:30px; }
      
      input {font-family: "나눔손글씨 느릿느릿체", "나눔손글씨느릿느릿체", "nanum-handwritting-neulisneulische"; font-size:20px;}
      
      li {margin:1%;}     

      #submit_button {margin:auto; padding:2%; background-color:#99CCFF; border-radius:10px; border-style:none; font-size:20px;}

      @media screen and (max-width: 500px){
         .sizedown{
            display: flex;
            margin: 5%;
         }
      }
     #day_night{
        border:none;
        border-radius: 20px;
        box-shadow: 0 4px 16px rgba(0, 79, 255, 0.3);
        
     }
     button:focus{
        outline: 0;
     }
     button:hover{
        background: rgba(0, 79,255, 0.9);
        
        box-shadow: 0 2px 4px rgba(0,79, 255, 0.6);
     }
    
   </style>

</head>
<body>
   <h1>스마트 초인종</h1>
  
   <div class="sizedown">
      <p>
         야간모드 주간모드 기능입니다
      
     
        <input type="button" id="day_night" type="buttom" value="야간"  onclick="
      if(  document.querySelector('#day_night').value ==='주간'){
        
        document.querySelector('body').style.backgroundColor='lavender';
        document.querySelector('body').style.color='black';
        document.querySelector('#day_night').value='야간';
        alert('주간모드로 전환합니다');

      } 
      else{
        
        document.querySelector('body').style.backgroundColor='black';
            document.querySelector('body').style.color='white';
            document.querySelector('#day_night').value='주간';
            alert('야간모드로 전환합니다');

      }
        
        ">
     
   
      </p>

   </div>
   <div class='div' id='div1'>
      <form action="check_file.php" method="POST"> 
         <fieldset>
            <legend> &nbsp;&nbsp;방문자 정보 입력&nbsp;&nbsp;</legend>
            <ul>
               <li>방문자: &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; 
               <input type='text' id='who' name='who' placeholder="ex) 배달기사, 수리기사"></li><br>
               <li>방문목적: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type='text' name='purpose' placeholder="ex) 음식 배달"></li><br>
               <li>만나야하는 이유:
               <input type='text' name='chat' placeholder="ex) 만나서 결제 필요"> &nbsp; &nbsp;
               <input id="submit_button" type="submit" value="입력 완료!"></li>
            </ul>
         </fieldset>
      </form>
   </div>
   
   <div class='div' id='div2'>
      
   </div>

   
   <!--
   <div class='div' id='div3'>
      <form>
         <input type='text' type='text' name='input_message' placeholder='메세지를 입력하세요.' id='input_message'>
         <button type="button" id='input_message_button' onclick="sendVisitorMessage()">전송</button>
      </form>
   </div>
   -->
</body>
</html>
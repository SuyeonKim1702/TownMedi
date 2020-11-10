<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

    <?php
    session_start();
    $_SESSION[ 'post' ] = 'N';
  
    if($_SESSION['edit'] == 'N'){
      $_SESSION[ 'index' ] = -1; // delete, modify 할 때 이 변수 이용 -> post라는 의미 
      $index = $_GET['varname']; 
      $type =  $_GET['type']; 
        $rating = "";
        $waitingTime = "";
        $cost = "";
        $comment = "please leave a review ... ";
      
    }else if($_SESSION['edit'] == 'Y'){
      $tmp = $_SESSION['index'];
      $_SESSION[ 'index' ] = -1;
      $_SESSION['edit'] = 'Y';
      $index = $tmp;
      $type = $_SESSION['type']; 
      $user = 1;


      $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'townmedi');


      if($type == 'hospital'){

      $sql = "SELECT rating, waitingTime, cost, comment
           from ReviewForHospital
           where userIdx={$user} AND hospitalIdx = {$index};";

      }else{
        $sql = "SELECT rating, waitingTime, cost, comment
        from ReviewForPharm
        where userIdx={$user} AND pharmIdx = {$index};";
      }


      $result = mysqli_query($conn, $sql);

      while($row = mysqli_fetch_assoc($result)){
        $rating = $row['rating'];
        $waitingTime = $row['waitingTime'];
        $cost = $row['cost'];
        $comment = $row['comment'];
        
       
       //echo $rating, $waitingTime, $cost, $comment;
        
       }






    }
   

 ?>

        <div id="top">
        <a href="connect.php">
        <h1 id="logo"><img src="image/logo.png" width="280" height="140"/></h1></a>        </div>

        <div style=" text-align:center;">
        <div style="font-size:40px; font-weight:bold; ">Write a review
        </div>
        
        <FORM NAME=frmInfo METHOD=POST ACTION="<?php echo 'detail.php?type='.$type.'&&varname='.$index.'&&src=create' ?>">

        <div style="width:400px; margin-left:650px; margin-top:50px; height:100px;">
        <div style="float: left;">cost(won):</div>
        <INPUT style="float: left; width:70px; height:15px;" TYPE=TEXT NAME=cost SIZE=30 VALUE="<?php echo $cost ?>">
        <div style="float: left; width:100px;"></div>

        <div style="float: left; margin-left:40px;  ">waiting time(m):</div>
        <INPUT style="float: left; width:70px; height:15px;" TYPE=TEXT NAME=time SIZE=30 VALUE="<?php echo $waitingTime ?>">

        <div style="margin-top:20px; float: left; ">rating(1~5):</div>
        <INPUT style=" margin-top:20px; float: left; width:70px; height:15px;" VALUE="<?php echo $rating ?>" TYPE=TEXT NAME=rating SIZE=30>


        </div>
      <div style="height:30px;"> Do you want to recommend this hospital/pharmacy to others?</div>
      <div>
       <input type="radio" name="yesoryes" value="Y">Yes
       <input type="radio" name="yesoryes" value="N">No
       
      </div>
        
        <textarea id="review" NAME=review placeholder="<?php echo $comment ?>" style="width:700px; height:200px; margin-top:50px;"></textarea>

        <div style="height:50px;">
        <INPUT style="background-color:#1c4a94; margin-right:10px; color:#ffffff; border-radius:10px; margin-top:10px; color: font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:30px;" TYPE=SUBMIT VALUE='POST'>

  </div>

  </FORM>

        </div>
        </body>
        </html>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

    <?php
    session_start();
 
    $index = $_GET['varname']; 
    $type =  $_GET['type']; 
    $src = $_GET['src'];
     

    
    

    //post
    if($src=='create' &&$_SESSION['post'] =='N'){

      $_SESSION['post'] ='Y';
      $cost = $_POST['cost'];
      $time = $_POST['time'];
      $rating = $_POST['rating'];
      $comment = $_POST['review'];
      $rec= $_POST['yesoryes'];
      

    

      $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'townmedi');

     if($type=='hospital'){
      $sql="INSERT INTO ReviewForHospital (userIdx, hospitalIdx, rating, recommend, waitingTime, cost, comment)
      VALUES
      (1, $index, $rating, '$rec', $time, $cost, '$comment')";
     }


     if (!mysqli_query($conn,$sql)){
       die('Error: ' . mysqli_error($conn));
  }

     mysqli_close($conn);
    
     

    }
    


 
 ?>

        <div id="top">
        <h1 id="logo"><img src="image/logo.png" width="280" height="140"/></h1>
        <form ACTION ="result.php" METHOD="POST" style="margin-top:50px;" name="keyword">
<INPUT style="font-size:17px;" TYPE="TEXT" name="keyword" placeholder="type a keyword"><INPUT style="font-size:17px; margin-left:5px;" TYPE="submit" value="search"><BR>
<select  style="font-size:17px; margin-top:40px; margin-right:10px" name="town" >
    <option  value="none">=== select town ===</option>
    <option value=1>Englewood</option>
    <option value=2>Denver</option>
    <option value=3>Sheridan</option>
    <option value=4>Glendale</option>
    <option value=5>Thorntone</option>
    <option value=6>Starsburg</option>
    <option value=7>Watkins</option>
    <option value=8>Fisher</option>
    <option value=9>Synder</option>
    <option value=10>Lane</option>
    <option value=11>Morgan</option>
    <option value=12>Sterling</option>
    <option value=13>Crook</option>
  </select>
 


  <select  style="font-size:17px; margin-top:40px;" name="subject" >
    <option value="none">=== select subject ===</option>
    <option value=1>dentist</option>
    <option value=2>plastic surgery</option>
    <option value=3>eye</option>
    <option value=4>pediatrics</option>
    <option value=5>emergency room</option>
    <option value=6>dermatology</option>
    <option value=7>Otorhinolaryngology</option>
    <option value=8>psychiatry</option>
    <option value=9>obgy</option>
    <option value=10>orthopedices</option>


  </select>

</form>
</div>

<div style="height:500px;">

<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '',
  'townmedi');

 if($type =='hospital'){

   $sql1 = "SELECT Distinct hospitalName, opentime, closedtime, SubjectName, tel, onSundays
   from Hospital H
   join ReviewForHospital RFH on H.hospitalIdx = RFH.hospitalIdx
   join Subject S on S.SubjectIdx = H.subject
   where H.hospitalIdx ={$index};";

  $sql2 = "SELECT  AVG(waitingTime) as waitingTime, AVG(cost) as cost
  from ReviewForHospital
  WHERE hospitalIdx={$index}
  GROUP BY hospitalIdx;";


$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

while($row1 = mysqli_fetch_assoc($result1)){
 $hospitalName = $row1['hospitalName'];
 $openTime = $row1['opentime'];
 $openTime = date("g:i a", strtotime($openTime));
 $closedTime = $row1['closedtime'];
 $closedTime = date("g:i a", strtotime($closedTime));
 $tel = $row1['tel'];

 $onSundays = $row1['onSundays'];
 if($onSundays == 'N') $onSundays = 'Closed';
 else $onSundays = 'Open';
 $subject = $row1['SubjectName'];
 
}

while($row1 = mysqli_fetch_assoc($result2)){
 $waitingTime = (int)$row1['waitingTime'];
 $cost = (int)$row1['cost'];

}
$text = '<div style="float: left; width: 40%; text-align: center;">
 <img src="image/thumb.png"  width="400" height="400" style="border-radius: 7px; "/>
 </div>
 <div style="float: left; width: 35%; text-align: left;">
 <div style="color: #2a2ead; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: larger; margin-left: -60px; margin-top: -30px"><h1>'.$hospitalName.'</h1></div>
 
 <div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 20px">Subject: '.$subject.' </div>
 
 <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 15px">Open at: '.$openTime.'</div>
 <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 5px">Close at: '.$closedTime.'</div>
 <div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">Location: 60 Maryland South, Suite 210 Baltimore, Denver 10020, U.S</div>
 <div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">Tel: '.$tel.'</div>
 <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 20px">Average cost: '.$cost.' won </div>
 <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 5px">Average waiting time: '.$waitingTime.'m</div>
 <div style="color: #bf2c2c; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">'.$onSundays.' Sundays</div>
 
 </div>';
 }else{
  $sql1 = "SELECT Distinct pharmName, opentime, closedtime, tel, onSundays
  from Pharmacy P
  join ReviewForPharm RFP on P.pharmIdx = RFP.pharmIdx
  where P.pharmIdx = {$index};";

 $sql2 = "SELECT  AVG(waitingTime) as waitingTime, AVG(cost) as cost, numOfMask
 from ReviewForPharm
 join NumberOfMask NOM on ReviewForPharm.pharmIdx = NOM.pharmIdx
 WHERE ReviewForPharm.pharmIdx={$index}
 GROUP BY ReviewForPharm.pharmIdx;";


$result1 = mysqli_query($conn, $sql1);
$result2 = mysqli_query($conn, $sql2);

while($row1 = mysqli_fetch_assoc($result1)){
$pharmName = $row1['pharmName'];
$openTime = $row1['opentime'];
$openTime = date("g:i a", strtotime($openTime));
$closedTime = $row1['closedtime'];
$closedTime = date("g:i a", strtotime($closedTime));
$tel = $row1['tel'];

$onSundays = $row1['onSundays'];
if($onSundays == 'N') $onSundays = 'Closed';
else $onSundays = 'Open';

}

while($row1 = mysqli_fetch_assoc($result2)){
$waitingTime = (int)$row1['waitingTime'];
$cost = (int)$row1['cost'];
$mask = $row1['numOfMask'];

}
$text = '<div style="float: left; width: 40%; text-align: center;">
<img src="image/pharmacy.png"  width="400" height="400" style="border-radius: 7px; "/>
</div>
<div style="float: left; width: 35%; text-align: left;">
<div style="color: #2a2ead; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: larger; margin-left: -60px; margin-top: -30px"><h1>'.$pharmName.'</h1></div>

<div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 20px">Nuber of Mask: '.$mask.' </div>

<div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 15px">Open at: '.$openTime.'</div>
<div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 23px; margin-left: -60px; margin-top: 5px">Close at: '.$closedTime.'</div>
<div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">Location: 60 Maryland South, Suite 210 Baltimore, Denver 10020, U.S</div>
<div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">Tel: '.$tel.'</div>
<div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 20px">Average cost: '.$cost.' won </div>
<div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 5px">Average waiting time: '.$waitingTime.'m</div>
<div style="color: #bf2c2c; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 21px; margin-left: -60px; margin-top: 15px">'.$onSundays.' Sundays</div>

</div>';

 }

echo $text;


if($type=='hospital'){
  $sql3="SELECT AVG(rating) as rating, COUNT(IF(recommend='Y',recommend,null))*100/COUNT(*) as percentage
  from ReviewForHospital
  WHERE hospitalIdx={$index};";
}else{
  $sql3="SELECT AVG(rating) as rating, COUNT(IF(recommend='Y',recommend,null))*100/COUNT(*) as percentage
from ReviewForPharm
WHERE pharmIdx={$index};";
}


$result3 = mysqli_query($conn, $sql3);

while($row1 = mysqli_fetch_assoc($result3)){
  $avg_rating = round($row1['rating'],2);
  $percentage = (int)$row1['percentage'];
  
  }
  
  $text='</div>
  <div style="height: 200px">
  <div style="float: left; width: 30%; text-align: center;">
  <div>
  <div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 76px; font-weight: bold;" >'.$avg_rating.'</div>';
  for($i=1;$i<=(int)$avg_rating;$i++){
    $text=$text.'<span class="fa fa-star checked" style="font-size: 30px; color:#ffdf29;"></span>';
  }
  for($i=1;$i<=5-(int)$avg_rating;$i++){
    $text=$text.'<span class="fa fa-star" style="font-size: 30px; color:#c7c6c1"></span>';

  }
 
 $text = $text.'<div style="font-family: Verdana, Geneva, Tahoma, sans-serif;font-size: 23px;" >Average Rating</div>
  </div>
  </div>';
  $text = $text.' <div style="float:left; height: 100%; width: 30%; text-align: center;">
  <div style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 65px; font-weight: bold; margin-bottom: 15px;" >'.$percentage.'%</div>';
  
  for($i=1;$i<=$percentage/10;$i++){
    $text=$text.' <span class="fa fa-user checked" style="font-size: 35px; color: #1c4a94;"></span>';
  }
  for($i=1;$i<=10-$percentage/10;$i++){
    $text=$text.' <span class="fa fa-user checked" style="font-size: 35px;"></span>';

  }
   
  $text=$text.'<div style="font-family: Verdana, Geneva, Tahoma, sans-serif;font-size: 23px;" >Recommend Percentage</div></div>
  </div> <div style="height:100px;" ><div style="float:left; height:100px; font-size:50px; margin-left:120px; font-family: Verdana, Geneva, Tahoma, sans-serif; ">Reviews</div>
  <div style="float:left; height:100px;  margin-left:120px; "> <a href="review.php?type='.$type.'&&varname='.$index.'"><button style="background-color:#1c4a94; color:#ffffff; border-radius:10px; margin-top:10px; color: font-family: Verdana, Geneva, Tahoma, sans-serif; font-size:25px;">write a review</button>
  </a>
  </div>
  </div>';
  




  if($type=='hospital'){
    $sql4="SELECT rating, recommend, comment, userName from ReviewForHospital
    join User U on U.userIdx = ReviewForHospital.userIdx
    where hospitalIdx={$index};";
  }else{
    $sql4="SELECT rating, recommend, comment, userName from ReviewForPharm
    join User U on U.userIdx = ReviewForPharm.userIdx
    where pharmIdx={$index};";
  }
 

$result4 = mysqli_query($conn, $sql4);


while($row1 = mysqli_fetch_assoc($result4)){
  $rating = $row1['rating'];
  if($row1['recommend'] == 'Y'){
    $recommend = '#d43b3b">'.'Like it!';
  }
  else{
    $recommend = '#9e9e9e">'.'Dislike it';
  } 
  
  $name = $row1['userName'];
  $comment = $row1['comment'];





  $text=$text.'<div style="margin-left:130px; height:200px;"> 
  <div style="float: left;  text-align: center;"><img src="image/man.png"  width="120" height="120"/>
  </div>
  <div style="float: left; width: 15%; margin-left:50px; ">
  <div style="font-family: Verdana, Geneva, Tahoma, sans-serif;font-size: 25px; font-weight: bold;">'.$name.'</div>
  <div style="font-family: Verdana, Geneva, Tahoma, sans-serif;font-size: 25px; font-weight: bold; margin-top: 20px; color:'.$recommend.'</div>
  
  </div>
  <div style="float: left; width: 30%; ">';



  for($i=0;$i<$rating;$i++)
   $text=$text.'<span class="fa fa-star checked" style="font-size: 30px; color:#ffdf29;"></span>';

   for($i=0;$i<5-$rating;$i++)
   $text=$text.'<span class="fa fa-star checked" style="font-size: 30px;"></span>';

   $text=$text.'<div style="font-family: Verdana, Geneva, Tahoma, sans-serif;font-size: 20px; margin-top: 10px;">'.$comment.'</div>
   </div>
   </div>';

  }

echo $text;


?>

        

    </body>
</html>












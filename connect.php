<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div id="top">
        <a href="connect.php">
        <h1 id="logo"><img src="image/logo.png" width="280" height="140"/></h1></a>
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
    <option  value="none">=== select subject ===</option>
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



        <div style="margin:10px;"> <h1> Top 7 Hospitals 🏥 </h1></div>
 

<?php
session_start();

$_SESSION[ 'index' ] = -1;
$conn = mysqli_connect(
  'localhost',
  'root',
  '',
  'townmedi');
$sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName, dense_rank() over (order by SUM(rating)/COUNT(rating) desc) as s_rank
FROM ReviewForHospital
join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
join Town T on H.townIdx = T.townIdx
join Subject S on H.subject = S.SubjectIdx
GROUP BY H.hospitalIdx
ORDER BY SUM(rating)/COUNT(rating) DESC
limit 7 ;";
$i = 0;
$result = mysqli_query($conn, $sql);


$table='<table id="tbmain" style="margin: 12px;" >
<colgroup>
<col style="width:10%">
<col style="width:10%">
<col style="width:20%">
<col style="width:20%">
<col style="width:15%">
<col style="width:20%">

<tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">ranking</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">image</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">name</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">tel</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">area</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">subject</td>
    </tr>
';
while($row = mysqli_fetch_assoc($result)) { 
  
    $i=$i+1;
    $index = $row['hospitalIdx'];
    $path='detail.php?type=hospital&&varname='.$index;
    $table=$table.'
    <tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;"><h2>'.$i.'</h2></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;"><img src="image/thumb.png" width="70" height="70" style="border-radius: 7px;"/></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px; color: steelblue; cursor:pointer;">
      <a style="border-bottom: 1px solid #ededed;
      padding: 10px; color: steelblue;" href='.$path.' <h3>'.$row['hospitalName'].'</a>
      </td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['tel'].'</h3></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['townName'].'</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['SubjectName'].'</td>
    </tr>';
   
   
}
$table=$table.'</table>';
echo $table;
?>
<div style="margin-top:100px; margin-left:10px;"> <h1> Top 7 Pharmacies 💊 </h1></div>

<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '',
  'townmedi');
$sql = "SELECT P.pharmIdx as pharmIdx, pharmName, tel, townName
FROM ReviewForPharm
join Pharmacy P on P.pharmIdx = ReviewForPharm.pharmIdx
join Town T on P.townIdx = T.townIdx
GROUP BY P.pharmIdx
ORDER BY SUM(rating)/COUNT(rating) DESC
limit 7;";
$i = 0;
$result = mysqli_query($conn, $sql);


$table='<table id="tbmain" style="margin: 12px;" >
<colgroup>
<col style="width:10%">
<col style="width:10%">
<col style="width:20%">
<col style="width:20%">
<col style="width:15%">

<tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">ranking</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">image</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">name</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">tel</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">area</td>
    
    </tr>
';
while($row = mysqli_fetch_assoc($result)) { 
  
    $i=$i+1;
    $index = $row['pharmIdx'];
    $path='detail.php?type=pharmacy&&varname='.$index;
    $table=$table.'
    <tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;"><h2>'.$i.'</h2></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;"><img src="image/pharmacy.png" width="70" height="70" style="border-radius: 7px;"/></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px; color: steelblue; cursor:pointer;">
      <a style="border-bottom: 1px solid #ededed;
      padding: 10px; color: steelblue;" href='.$path.' <h3>'.$row['pharmName'].'</a>
      </td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['tel'].'</h3></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['townName'].'</td>
    
    </tr>';
   
   
}


$table=$table.'</table>';
echo $table;
?>
        </div>
        



        <div style="margin-top:100px; margin-left:10px;"> <h1> The average rating & price of hospitals by village </h1></div>

<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '',
  'townmedi');
$sql = "SELECT  distinct T.townName as townName, AVG(rating) over (partition by H.townIdx) as Avg, AVG(cost) over (partition by H.townIdx) as Cost
from ReviewForHospital
join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
join Town T on T.townIdx = H.townIdx
order by Avg DESC;";
$i = 0;
$result = mysqli_query($conn, $sql);


$table='<table id="tbmain" style="margin: 12px;" >
<colgroup>
<col style="width:10%">
<col style="width:10%">
<col style="width:20%">


<tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">town</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">Avg rating</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">Avg costs</td>
   
    
    </tr>
';
while($row = mysqli_fetch_assoc($result)) { 
  
    $table=$table.'
    <tr>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;"><h2>'.$row['townName'].'</h2></td>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;">'.$row['Avg'].'</h3></td>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;">'.(int)$row['Cost'].' won</h3></td>
    
    </tr>';
   
   
}


$table=$table.'</table>';
echo $table;
?>
        </div>




        <div style="margin-top:100px; margin-left:10px;"> <h1> The average rating & price of pharmacies by village </h1></div>

<?php
$conn = mysqli_connect(
  'localhost',
  'root',
  '',
  'townmedi');
$sql = "SELECT  distinct T.townName, AVG(rating) over (partition by T.townIdx) as Avg, AVG(cost) over (partition by P.townIdx) as Cost
from ReviewForPharm
join Pharmacy P on ReviewForPharm.pharmIdx = P.pharmIdx
join Town T on T.townIdx = P.townIdx
order by Avg DESC;";
$i = 0;
$result = mysqli_query($conn, $sql);


$table='<table id="tbmain" style="margin: 12px;" >
<colgroup>
<col style="width:10%">
<col style="width:10%">
<col style="width:20%">


<tr>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">town</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">Avg rating</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">Avg costs</td>
   
    
    </tr>
';
while($row = mysqli_fetch_assoc($result)) { 
  
    $table=$table.'
    <tr>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;"><h2>'.$row['townName'].'</h2></td>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;">'.$row['Avg'].'</h3></td>
    <td style="border-bottom: 1px solid #ededed;
    padding: 10px;">'.(int)$row['Cost'].' won</h3></td>
    
    </tr>';
   
   
}


$table=$table.'</table>';
echo $table;
?>
        </div>






    </body>
</html>



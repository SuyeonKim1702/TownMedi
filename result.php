<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
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
<div style="margin-left:10px;"> <h1> Results for hospitals you want 🏥 </h1></div>

<?php
$keyword = $_POST['keyword'];
$town = $_POST['town'];
$subject = $_POST['subject'];
$sql2 ='';
session_start();

$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'townmedi');



if($keyword == '' && $town == 'none' && $subject == 'none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";
    
    $sql2 = "SELECT P.pharmIdx as pharmIdx, pharmName, tel, townName
    FROM ReviewForPharm
    join Pharmacy P on P.pharmIdx = ReviewForPharm.pharmIdx
    join Town T on P.townIdx = T.townIdx
    GROUP BY P.pharmIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

}else if($keyword == '' && $town != 'none' && $subject == 'none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE T.townIdx = {$town}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

    $sql2 = "SELECT P.pharmIdx as pharmIdx, pharmName, tel, townName
    FROM ReviewForPharm
    join Pharmacy P on P.pharmIdx = ReviewForPharm.pharmIdx
    join Town T on P.townIdx = T.townIdx
    WHERE P.townIdx= {$town}
    GROUP BY P.pharmIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

}else if($keyword == '' && $town != 'none' && $subject != 'none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE T.townIdx = {$town} AND S.SubjectIdx = {$subject}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";


}else if($keyword == '' && $town == 'none' && $subject != 'none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE S.SubjectIdx = {$subject}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

}else if($keyword != '' && $town == 'none' && $subject == 'none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE H.hospitalName LIKE '%{$keyword}%'
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

    $sql2 = "SELECT P.pharmIdx as pharmIdx, pharmName, tel, townName
    FROM ReviewForPharm
    join Pharmacy P on P.pharmIdx = ReviewForPharm.pharmIdx
    join Town T on P.townIdx = T.townIdx
    WHERE P.pharmName LIKE '%{$keyword}%'
    GROUP BY P.pharmIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

}else if($keyword != '' && $town =='none' && $subject !='none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE H.hospitalName LIKE '%{$keyword}%' && S.SubjectIdx = {$subject}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

}else if($keyword != '' && $town !='none' && $subject =='none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE H.hospitalName LIKE '%{$keyword}%' && T.townIdx = {$town}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

     $sql2 = "SELECT P.pharmIdx as pharmIdx, pharmName, tel, townName
    FROM ReviewForPharm
    join Pharmacy P on P.pharmIdx = ReviewForPharm.pharmIdx
    join Town T on P.townIdx = T.townIdx
    WHERE P.pharmName LIKE '%{$keyword}%' AND T.townIdx = {$town}
    GROUP BY P.pharmIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";

   

}else if($keyword != '' && $town !='none' && $subject !='none'){
    $sql = "SELECT H.hospitalIdx as hospitalIdx, hospitalName, tel, townName, SubjectName
    FROM ReviewForHospital
    join Hospital H on H.hospitalIdx = ReviewForHospital.hospitalIdx
    join Town T on H.townIdx = T.townIdx
    join Subject S on H.subject = S.SubjectIdx
    WHERE H.hospitalName LIKE '%{$keyword}%' && T.townIdx = {$town} && S.SubjectName = {$subject}
    GROUP BY H.hospitalIdx
    ORDER BY SUM(rating)/COUNT(rating) DESC;";
}

$result = mysqli_query($conn, $sql);




$table='<form ACTION ="detail.php" METHOD="POST">
<table id="tbmain" style="margin: 12px;" >
<colgroup>
<col style="width:10%">
<col style="width:10%">
<col style="width:20%">
<col style="width:20%">
<col style="width:15%">
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
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">subject</td>

    
    </tr>';
$i=0;

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
      <a href='.$path.' <h3>'.$row['hospitalName'].'</a>
      </td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['tel'].'</h3></td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['townName'].'</td>
      <td style="border-bottom: 1px solid #ededed;
      padding: 10px;">'.$row['SubjectName'].'</td>
    
    </tr>';

    
   

}
$table=$table.'</table> </form>';
echo $table;
   ?>

<div style=" margin-top:10px; margin-left:10px;"> <h1> Results for pharmacies you want 💊 </h1></div>
<?php
if($sql2!=''){
    $result2 = mysqli_query($conn, $sql2);
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
    

    
    </tr>';
$i=0;
while($row = mysqli_fetch_assoc($result2)) { 
    
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
   


}
?>

        

    </body>
</html>



<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>
    <div id="top">
        <h1 id="logo"><img src="image/logo.png" width="280" height="140"/></h1>
        </div>
        <?php 

     $index = $_POST['index'];
     $success = true;


     $conn = mysqli_connect(
        'localhost',
        'root',
        '',
        'townmedi');

        $sql2 = "SELECT numOfMask
        from NumberOfMask
        WHERE pharmIdx={$index};";

        $result = mysqli_query($conn, $sql2);

        while($row1 = mysqli_fetch_assoc($result)){
            $mask = $row1['numOfMask'];
            
            
            }
           
            $mask = $mask-1;

       mysqli_close($conn);

       if($mask == -1){
        echo ' <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 50px; margin-top: 50px; margin-left: 50px;">Mask sold out ...  </div>';

       }else{

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $Mysqli = new mysqli('localhost','root','','townmedi');
        $Mysqli->set_charset('utf8mb4');
   
   
        try{
           $Mysqli->begin_transaction();
           $Mysqli->query("UPDATE NumberOfMask 
           SET numOfMask = {$mask}
           WHERE pharmIdx = {$index};");
     
           $Mysqli->commit();
           echo ' <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 30px; margin-top: 50px;">Reservation succeed! </div>';
           
   
   
   
        } catch(\Throwable $e){
           $Mysqli->rollback();
           // Rethrow the exception so that PHP does not continue with the execution and the error can be logged in the error_log
           $success = false;
           echo ' <div style="color: #1c4a94; font-weight: bold; font-family: Verdana, Geneva, Tahoma, sans-serif; font-size: 30px; margin-top: 50px;">Reservation failed! </div>';

           
           throw $e;
       
        }
          
       }
    
   
         ?>
        </body>
        </html>
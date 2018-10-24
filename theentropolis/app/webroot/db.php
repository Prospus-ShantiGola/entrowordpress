<?php
$Server = "localhost";
 $Username = "root";
 $PW = "t#3en+r0";
 $DB = "trepicity";
$u=filter_input(INPUT_POST, 'EntroT');
$p=filter_input(INPUT_POST, 'Prospus1');
$con = mysqli_connect($Server, $Username, $PW, $DB);

 if($con == false) {
     die("Error: " . mysqli_error_connect());
 }  

$st=$con->prepare("SELECT * FROM users WHERE id = 319 ");
$st->bind_param('s', $u);
$st->execute();
$rs=$st->get_result();
if ($rs->num_rows > 0) {
while ($row = $rs->fetch_assoc()) 
    {


     echo "Connected";
    }     



} else {
    echo "wrong username or password";
}



 mysqli_close($connection);
 ?>

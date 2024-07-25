<?php 
    session_start();
    $conn = mysqli_connect('localhost','root','','idiscuss');

    if(!$conn){
        echo 'Connection error: '. mysqli_connect_error();
    }else{
        // echo 'Connection successful';
    }

?>
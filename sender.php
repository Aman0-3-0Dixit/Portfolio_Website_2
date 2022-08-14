<?php
$username=$_POST['name'];
$email=$_POST['email'];
$messaged=$_POST['messageHolder'];

if(!empty($username) || !empty($email)){
    $host="Mysql@127.0.0.1:3306";
    $dbUsername="root";
    $dbPassword="aman123";
    $dbname="register";

    $conn= new mysqli($host,$dbUsername,$dbPassword,$dbname);
    if(mysqli_connect_error()){
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }
    else{
        $SELECT="SELECT email from register Where email=? Limit 1";
        $INSERT="INSERT Into register (username,email,messaged) values(?,?,?)";

        $stmt=$conn->prepare($SELECT);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum=$stmt->num_rows;

        if($rnum==0){
            $stmt->close();
            $stmt=$conn->prepare($INSERT);
            $stmt->bind_param("ssssii",$username,$email,$messaged);
            $stmt->execute();
            echo "New record inserted succesfully";
        }
        else{
            echo "Someone already registered with this mail id";
        }

        $stmt->close();
        $conn->close();

    }
}
else{
    echo "All fields are required";
    die();
}

?>
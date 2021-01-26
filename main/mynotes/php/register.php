<?php

    require_once('dbconnect.php');
    session_start();


    $username = mysqli_real_escape_string($con, $_POST['username']) ;
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cfm_password = mysqli_real_escape_string($con, $_POST['confirmpassword']);
    
    
    $errors = array();

    if(empty($username)) {array_push($errors, "Username is empty!");}
    if(empty($firstname)) {array_push($errors, "Firstname is empty!");}
    if(empty($lastname)) {array_push($errors, "Lastname is empty!");}
    if(empty($password)) {array_push($errors, "Password is empty!");}
    if($password != $cfm_password){array_push($errors, "Password does not match!");}

    
    if(!empty($username)){
        $stmt = $con->prepare("SELECT username FROM tbl_users WHERE username=? LIMIT 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->store_result();

    if($stmt->num_rows == 1){
        array_push($errors, "username is already registered");
        $stmt->close();
    }
    }

    if(count($errors)==0){
        $password = password_hash($cfm_password, PASSWORD_BCRYPT);
        $stmt = $con->prepare("INSERT INTO tbl_users(username, firstname, lastname, password ) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $username,  $firstname,  $lastname,  $password);
        $stmt->execute();
        header("location:../html/signup.php?Success= Successfully Registered!");
    }else{
        header("location:../html/signup.php?Error= $errors[0]");
    }
?>


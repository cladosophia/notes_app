<?php 
require_once('dbconnect.php');
session_start();
    
        $username = $_POST['username'];
        $password = $_POST['password'];
        $newhash ="";
        
        if(empty($username) || empty($password)){
            header("location:../html/login.php?Empty= Please fill in the Blanks!");
        }
        else{
            $stmt = $con->prepare("SELECT user_id, firstname, lastname, username, password FROM tbl_users WHERE username=? LIMIT 1");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->bind_result($user_ID, $firstname, $lastname, $username, $hash);
            $stmt->store_result();
           
            
            
            
            if($stmt->num_rows == 1){
                while($stmt->fetch()){
                
                    if(password_verify($password, $hash)){
                        $_SESSION['user_id']=$user_ID;
                        $_SESSION['firstname']=$firstname;
                        $_SESSION['lastname']=$lastname;

                        header("location:../index.php");
                    }
                    else{
                    header("location:../html/login.php?Invalid= Incorrect Password!");     
                }
            }
            }else{
                header("location:../html/login.php?Invalid= Username not found!");
            }
                
            
            $stmt->close();           
        } 
    

?>
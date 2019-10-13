<?php
   session_start();   
   if (isset($_POST['csrf_request']))
   	{
   	if ($_POST['csrf_request'] == $_SESSION["logedIn"]){
           //generate CSRF token when the request comes from the login page(on page loads)
           generateCSRFToken();
           echo "SUCCESS";
   		} else	{
   		echo "null";
   		}
    }      

    //method for generate CSRF token
    function generateCSRFToken(){
        //creating cookie with base64 encoded value, set time to 30 mins ahead and set root path as "/"
        return setcookie("csrf_token", base64_encode(openssl_random_pseudo_bytes(32)), time() + 1800, "/");
    } 
    
?>
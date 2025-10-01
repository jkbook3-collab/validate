<?php
//TASK b - create variables named usr, psw, pswErr, and usrErr and initialize them to empty values
$usr = $psw = "";
$usrErr = $pswErr = "";

$logErr = true;
$display = "display:none;";

//TASK c - replace "aaaa" with the proper superglobal variable to capture all the post array elements
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $display = "display:block;";

//TASK d - replace "bbbb" with the proper superglobal variable to capture the username field
  $usr = validate_fields($_POST["usr"]);  
  $pattern = "/^[a-zA-Z ]*$/";
  if (empty($usr)) {
    $usrErr = "Username is required";
    $logErr = true;
  } elseif (!preg_match($pattern,$usr)) {
     $usrErr = "Only letters allowed"; 
     $logErr = true;
  } else {
     $logErr = false;
  }
 
 
//Task e - replace "cccc" with the proper superglobal variable to capture the password field
  $psw = validate_fields($_POST["psw"]);

//TASK f - using the pattern above, create a new pattern to validate the password field 
  $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_$^!]).{15,}$/";    
  if (empty($psw)) {
    $pswErr = "Password is required";
    $logErr = true;
  } elseif (!preg_match($pattern,$psw)) {
     $pswErr = "Invalid Password"; 
     $logErr = true;
  } else {
    $logErr = false; 
  }    
}

if ( !$logErr)  {
//TASK g - Issue a Session ID
  session_start();
  $_SESSION["user"]= $usr;
}

//TASK h - create a function called validate_fields() that accepts the data field checks for new lines, leading and trailing spaces, removes backslashes, and encodes HTML and return the cleaned data back
  function validate_fields($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>Login Form</title>
   <meta charset="utf-8">
   <style>
    /* Style all input fields */
    input {
     width: 100%;
     padding: 12px;
     border: 1px solid #ccc;
     border-radius: 4px;
     box-sizing: border-box;
     margin-top: 6px;
     margin-bottom: 16px;
     }

    /* Style the submit button */
    #sub {
     background-color: #4CAF50;
     color: white;
     }

    /* Style the container for inputs */
    .container {
     width: 300px;
     margin: 0 auto;
     background-color: #f1f1f1;
     padding: 20px;
     }

   /* The message box is shown only when the user clicks on the password field */
   #message {
     display:none;
     width: 300px;
     margin: 0 auto;
     background: #f1f1f1;
     color: #000;
     position: relative;
     padding: 20px;
     margin-top: 10px;
     }

   #message p {
     padding: 10px 35px;
     font-size: 18px;
     }

   /* Add a green text color when the requirements are right */
   .valid {
     color: green;
     }

   /* Add a red text color when the requirements are wrong */
   .invalid {
     color: red;
     }
   </style>
</head>
<body>    
   <div class="container">
      <form name="loginform" id="loginform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
         <p>Username<br>
         <input type="text" id="usr" name="usr"></p>
	     <p>Password<br>
         <input type="password" id="psw" name="psw">
	     </p>
         <input type="submit" id="sub" name="sub" value="Log In">
      </form>
   </div>
   <div id="message" style="<?php echo $display; ?>">
     <?php if (!empty($usrErr)) { ?>
     <p class="invalid"><?php echo $usrErr; ?></p>
     <?php } ?>
     <?php if (!empty($pswErr)) { ?>
     <p class="invalid"><?php echo $pswErr; ?></p>
     <?php } ?>
    
     <p>Username: <?php echo $usr; ?></p>
     <p>Password: <?php echo $psw; ?></p>
     <p>Session ID: <?php echo session_id(); ?></p>  
   </div>
</body>
</html>
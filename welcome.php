#!/usr/local/bin/php
<?php 
    session_save_path(dirname(realpath(__FILE__)) . '/sessions/');
    session_name('LogIn');
    session_start();
?>
<!DOCTYPE html>
<?php if (isset($_SESSION['loggedin'])){ //if they are logged in ?>  
      <html>
          <head>
              <title> Welcome! </title>
</head>
<body>
    <p> Welcome.  Your email address is <?php echo $_SESSION['user_email']//print their email; ?> </p>
    <p> Here is a list of all registered email addresses:  </p>

</body>
</html>
<?php
    $file_Content = fopen("validatedUsers.txt", "r");
    while ($line = fgets($file_Content)) {
        if ((strcmp(substr($line, 0, 6) , "email:") === 0) ){
            $EM = substr($line, 6, -1);
            echo $EM." ";
            //echo the email if they get it from the filecontent of validated users and it matches 
      
        }
      
     }
    
    fclose($file_Content); //close the file and user can logout from below 
    ?>
    
    <a href="./logout.php"> <input type="submit" value="Logout"></a> 
    <?php
}
?> 

#!/usr/local/bin/php
<!DOCTYPE html> <html>
<head>
<title>Validation </title> 
</head>

<?php
    $emailVal = $_GET['email']; //get email from query string of validate link
    $tokenVal = $_GET['token'];//get token from query string of validate link
    $Validated_File = fopen("validatedUsers.txt", "a");
    $Unvalidated_File =  fopen("UnvalidatedUsers.txt", "r+");
    //wwrite email token in validated file 
    fwrite($Validated_File,"email:"); 
    fwrite($Validated_File, $emailVal);
    fwrite($Validated_File, "\n");
    fwrite($Validated_File,"token:");
    fwrite($Validated_File, $tokenVal);
    fwrite($Validated_File, "\n");
    $NewFile= "";
    $Flag = false;
    $Pass_word = "";
    //get the unvalidated file contents, and if the string in the unvalidated file is the same as the email 
    //use the email in EM and the password in Pass_Word and append it
    while ($line = fgets($Unvalidated_File)) {
       if ((strcmp(substr($line, 0, 6) , "email:") === 0) && $Flag === false){
           
            $EM = substr($line, 6, -1);
            // echo "found an email" . $EM;
            if ($EM === $emailVal)
            {
                // echo "found the email";
                $Flag = true;
            }
       }
       else if($Flag === true) {
           $Flag = false;
           $Pass_word = substr($line, 9, -1);
        //    echo "found passwword";
        //    echo $Pass_word;
       }
       else {
        $NewFile = $NewFile . $line;
      

        }
    }
    //save email passwword in validated file 
    fwrite($Unvalidated_File, $NewFile);
    fwrite($Validated_File,"Password:");
    fwrite($Validated_File, $Pass_word);
    fwrite($Validated_File, "\n");
    fclose($Validated_File);
    fclose($Unvalidated_File);
    echo "You are registered!";
?>

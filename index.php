#!/usr/local/bin/php
<?php 
ob_start();
session_save_path(dirname(realpath(__FILE__)) . '/sessions');
session_name('LogIn');
session_start(); 
$_SESSION['loggedin'] = false; 


$min = 100;
$email = "";
$hashed_password = "";
$max = 50000;
$random = mt_rand($min,$max);
$hash_validate = md5($random); //Generating random number for the validation url 
$validate_text = "validate by clicking here:";

        if ($_SERVER["REQUEST_METHOD"] == "POST") { //getting users email and password which theyve entered 
            if (!empty($_POST["email"] && !empty($_POST["password"]))){
                $email = trim($_POST['email']); //getting email 
                $password = trim($_POST['password']); //getting password 
                $fileContent = file_get_contents("validatedUsers.txt"); //getting the entire content of the validated users file 
                $hashed_password = md5($_POST["password"]); //hashing the password 
                $url_to_mail = ("https://www.pic.ucla.edu/~lakshitavij2501/HW7/validate.php?email=" . $email . "&token=" . $hash_validate);  //creating an email to send 
                

        if (isset($_POST['register'])){ //if the user clicks register 
            extract($_REQUEST);
            $UnvalidatedFile = fopen("UnvalidatedUsers.txt", "a");  //Open unvalidated file 
            $ValidatedFile = fopen("validatedUsers.txt", "a");//Open validated file 
            if(strpos($fileContent, $email)!== false){ //if the email is in the validated file, then tell teh user to validate or log in
                echo  "Already registered. Please log in/validate." ;
            }

            else { //write the email, hashed paswword in the unvalidated file along with the token
                fwrite($UnvalidatedFile, "email:");
                fwrite($UnvalidatedFile, $email);
                fwrite($UnvalidatedFile, "\n");
                fwrite($UnvalidatedFile, "Password:");
                fwrite($UnvalidatedFile, $hashed_password);
                fwrite($UnvalidatedFile, $hash_validate);
                fwrite($UnvalidatedFile, "\n");
                fclose($UnvalidatedFile);
                mail($email, 'validation', $validate_text. $url_to_mail); //send mail to user to the email they register with, the validation text, and the hashed token 
                echo  "A validation email has been sent to:  " . $email . "  Please follow the link.";

            }

                
        }


        }
    
        if (isset($_POST['login'])){ //if login button is clicked
            extract($_REQUEST);
            $ValidatedFile = fopen("validatedUsers.txt", "a"); //open validated file
            $ValidatedFileContent = file_get_contents("validatedUsers.txt"); //get its contents 
            // $UnvalidatedFile = fopen("UnvalidatedUsers.txt", "a");
            // $unValfileContent = file_get_contents("UnvalidatedUsers.txt");
            // $ValidatedFile = fopen("validatedUsers.txt", "a");
            // fwrite($ValidatedFile, $hashed_password);
            // while (!feof($UnvalidatedFile)){
            //     $remove_usersEmail = str_replace($email,"", $unValfileContent);
            //     $remove_usersPassword = str_replace($hashed_password, "", $unValfileContent);
            // }

           
            if((strpos($ValidatedFileContent, $email)!== false)) { //if the email is in the validated file 

                if ((strpos($ValidatedFileContent, $hashed_password)=== false)) { //howwever if the password doesnt match the email tell the user its a mismatch
                    echo  "Password doesnt match email. Please try again";
                }

                else {
                    $_SESSION['loggedin'] = true;  //login is true and get users email 
                    $_SESSION['user_email'] = $email;
                    echo  " <script src=\"hw7.js\" defer> </script>";  //take them to welcome.php
                
                }

            }

            else {
                echo  "No such email address. Please register or validate."; //else tell them to register or validate 
            }

           
           
        }

    }



    

    
?>
        
<!DOCTYPE html> <html>
<head>
<link rel = "stylesheet" href="hw7.css?v=15">
<title>HW7 </title> 
</head>
<body> 
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div id = "loginInfo">
        Email Address:<input type = "text" id ="email"  name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" /> <br>
        Password(&ge; 6 characters letters or digits):<input type = "text" name="password"  id ="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" />
        <?php $hashed_password = hash("md5", $password); ?>
        </div>
        <div id = "final">
    <input type = "submit" id ="register" value="register" name="register"> 
    <input type = "submit" id ="login" value="log in" name="login"> 
    </div>
</form>






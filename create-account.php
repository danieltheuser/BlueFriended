<?php 
include('classes/DB.php');

if (isset($_POST['createaccount'])) {
    try {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $email2 = $_POST['email2'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $birthdate = date('Y-m-d', strtotime("{$_POST['dd']}-{$_POST['mm']}-{$_POST['yyyy']}"));
        $birthsex = isset($_POST['birthsex']) ? $_POST['birthsex'] : '';

    // CHECKING IF USER CREATING NEW ACCOUNT DID NOT FORGET TO FILL IN HIS FIRST NAME
    if (strlen($first_name) >=1) {

        // CHECKING IF USER'S FIRST NAME IS NOT TOO SHORT
        if (strlen($first_name) >=2) {

            // CHECKING IF USER'S FIRST NAME IS LESS THAN 30 CHARACTERS LONG
            if (strlen($first_name) <=30) {

                // CHECKING IF USER USED ONLY LOWERCASE AND UPPERCASE LETTERS FOR HIS FIRST NAME
                if (preg_match('/^[\p{L}]+$/u',$first_name)) {

                    // CHECKING IF USER CREATING NEW ACCOUNT DID NOT FORGET TO FILL IN HIS LAST NAME
                    if (strlen($last_name) >=1) {

                        // CHECKING IF USER'S LAST NAME IS NOT TOO SHORT
                        if (strlen($last_name) >=2) {

                            // CHECKING IF USER'S LAST NAME IS LESS THAN 30 CHARACTERS LONG
                            if (strlen($last_name) <=30) {

                                // CHECKING IF USER USED ONLY LOWERCASE AND UPPERCASE LETTERS FOR HIS LAST NAME
                                if (preg_match('/^[\p{L}]+$/u',$last_name)) {
                                
                                    // CHECKING AVAILABILITY OF USERNAME
                                    if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                                        // CHECKING IF USERNAME IS BETWEEN 5 TO 25 CHARACTERS LONG
                                        if (strlen($username) >=5 && strlen($username) <=25) {

                                            // MAKING SURE THAT USERNAME ONLY CONTAINS LETTERS, NUMBERS, '_' AND '.'
                                            if (preg_match("/^[a-zA-Z0-9\_\.]+$/",$username)) {

                                                // CHECKING IF USER CREATING NEW ACCOUNT FILLED IN HIS EMAIL ADDRESS
                                                if (strlen($email) >=1) {

                                                    // CHECKING IF USER CREATING NEW ACCOUNT FILLED IN HIS EMAIL ADRESS AGAIN
                                                    if (strlen($email2) >=1) {

                                                        // CHECKING IF EMAIL ADDRESSES ARE NOT LONGER THAN 255 CHARACTERS
                                                        if (strlen($email) <=255 && strlen($email2) <=255) {

                                                            // CHECKING IF EMAIL ADDRESSES MATCH
                                                            if ($email == $email2) {

                                                                // CHECKING VALIDATION OF EMAIL ADDRESS
                                                                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                                                                    // CHECKING IF THE EMAIL IS NOT BEING USED FOR ANOTHER ACCOUNT
                                                                    if (!DB::query('SELECT email FROM users WHERE email=:email', array(':email'=>$email))) {

                                                                        // CHECKING IF PASSWORD IS BETWEEN 8 TO 25 CHARACTERS LONG
                                                                        if (strlen($password) >=8 && strlen($password) <=25) {

                                                                            // CHECKING IF PASSWORD2 IS BETWEEN 8 TO 25 CHARACTERS LONG
                                                                            if (strlen($password2) >=8 && strlen($password2) <=25) { 

                                                                                // CHECKING IF PASSWORDS MATCH
                                                                                if ($password == $password2) {

                                                                                    // CHECKING IF PASSWORD CONTAINS AT LEAST 1 LOWERCASE LETTER
                                                                                    if (preg_match_all("/(?=.*[a-z])[a-z]/",$password)) {

                                                                                        // CHECKING IF PASSWORD CONTAINS AT LEAST 1 UPPERCASE LETTER
                                                                                        if (preg_match_all("/(?=.*[A-Z])[A-Z]/",$password)) {

                                                                                            // CHECKING IF PASSWORD CONTAINS AT LEAST 1 DIGIT
                                                                                            if (preg_match_all("/(?=.*[0-9])[0-9]/",$password)) {

                                                                                                // CHECKING IF USER SELECTED HIS BIRTH DATE
                                                                                                if (!empty($_POST['dd']) && !empty($_POST['mm']) && !empty($_POST['yyyy'])) {

                                                                                                    // CHECKING IF USER SELECTED HIS BIRTH SEX
                                                                                                    if (!empty($birthsex)) {

                                                                                                        // INSERTING USERS DATA INTO DATABASE (table: users)
                                                                                                        DB::query("INSERT INTO users (first_name, last_name, username, email, password, birthdate, birthsex, signup_date) VALUES (?, ?, ?, ?, ?, ?, ?, CURTIME());", [$first_name, $last_name, $username, $email, password_hash($password, PASSWORD_DEFAULT), $birthdate, $birthsex]);
                                                                                                        echo 'Welcome on BlueFriended!';

                                                                                                    // CHECKING IF USER SELECTED HIS BIRTH SEX
                                                                                                    } else {
                                                                                                            echo 'Select your Birth Sex.';
                                                                                                    }
                                                                                                    
                                                                                                // CHECKING IF USER SELECTED HIS BIRTH DATE    
                                                                                                } else {
                                                                                                        echo 'Choose your birthday.';
                                                                                                }

                                                                                            // CHECKING IF PASSWORD CONTAINS AT LEAST 1 DIGIT
                                                                                            } else {
                                                                                                    echo 'Password must contain at least 1 digit.';
                                                                                            }

                                                                                        } else {
                                                                                                echo 'Password must contain at least 1 uppercase letter.';
                                                                                        }

                                                                                    } else {
                                                                                            echo 'Password must contain at least 1 lowercase letter.';
                                                                                    }
                                                                                
                                                                                // CHECKING IF PASSWORDS MATCH
                                                                                } else {
                                                                                        echo 'Passwords do not match.';
                                                                                }

                                                                            // CHECKING IF PASSWORD2 IS BETWEEN 8 TO 25 CHARACTERS LONG
                                                                            } else {
                                                                                    echo 'Password has to be between 8 to 25 characters long.';
                                                                            }

                                                                        // CHECKING IF PASSWORD IS BETWEEN 8 TO 25 CHARACTERS LONG
                                                                        } else {
                                                                                echo 'Password has to be between 8 to 25 characters long.';
                                                                        }

                                                                    // CHECKING IF THE EMAIL IS NOT BEING USED FOR ANOTHER ACCOUNT        
                                                                    } else {
                                                                            echo 'Email address has already been used for another account. Please try another or sign in with this email address.';
                                                                    }

                                                                // CHECKING VALIDATION OF EMAIL ADDRESS    
                                                                } else {
                                                                        echo 'This Email address is invalid.';
                                                                }

                                                            // CHECKING IF EMAIL ADDRESSES MATCH
                                                            } else {
                                                                    echo 'Email addresses do not match.';
                                                            }    
                                                    
                                                        } else {
                                                                echo 'Email address can not have more than 255 characters.';
                                                        }

                                                    // CHECKING IF USER CREATING NEW ACCOUNT FILLED IN HIS EMAIL ADRESS AGAIN
                                                    } else {
                                                            echo 'Please fill in your Email address again.';  
                                                    }
                                                    
                                                // CHECKING IF USER CREATING NEW ACCOUNT FILLED IN HIS EMAIL ADDRESS
                                                } else {
                                                        echo 'Please fill in your Email address.';
                                                }
                                        
                                            // MAKING SURE THAT USERNAME ONLY CONTAINS LETTERS, NUMBERS, '_' AND '.'
                                            } else {
                                                    echo "Username can only contain letters, numbers, _ and .";
                                            }   
                                        
                                        // CHECKING IF USERNAME IS BETWEEN 5 TO 25 CHARACTERS LONG
                                        } else {
                                                echo 'Username has to be between 5 to 25 characters long.';
                                        } 
                                    
                                    // CHECKING AVAILABILITY OF USERNAME    
                                    } else {
                                            echo 'This username has already been taken. Please choose another.';
                                    } 
                
                                // CHECKING IF USER USED ONLY LOWERCASE AND UPPERCASE LETTERS FOR HIS LAST NAME
                                } else {
                                        echo 'Use only lowercase and uppercase letters for your Last name.';
                                }

                            // CHECKING IF USER'S LAST NAME IS LESS THAN 30 CHARACTERS LONG
                            } else {
                                    echo 'Last name can not be longer than 30 characters.';
                            }

                        // CHECKING IF USER'S LAST NAME IS NOT TOO SHORT    
                        } else {
                                echo 'Last name can not be too short.';
                        }
                        
                    // CHECKING IF USER CREATING NEW ACCOUNT DID NOT FORGET TO FILL IN HIS LAST NAME
                    } else {
                            echo 'Please fill in your Last name.';
                    }

                // CHECKING IF USER USED ONLY LOWERCASE AND UPPERCASE LETTERS FOR HIS FIRST NAME
                } else {
                        echo 'Use only lowercase and uppercase letters for your First name.';
                }

            // CHECKING IF USER'S FIRST NAME IS LESS THAN 30 CHARACTERS LONG
            } else {
                    echo 'First name can not be longer than 30 characters.';
            }
        
        // CHECKING IF USER'S FIRST NAME IS NOT TOO SHORT
        } else {
                echo 'First name can not be too short.';
        }

    // CHECKING IF USER CREATING NEW ACCOUNT DID NOT FORGET TO FILL IN HIS FIRST NAME
    } else {
            echo 'Please fill in your First name.';
    }

}
catch(Exception $e)
{
    echo "Error -> $e";
}
}
?>

<script src="js/jquery.min.js"> </script>
<script defer src="js/main.js"> </script>

<h1>Register</h1>
<form action="create-account.php" method="POST">
    <input type="text" name="first_name" value="" placeholder="First name ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="text" name="last_name" value="" placeholder="Last name ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="text" name="username" value="" placeholder="Username ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="email" name="email" value="" placeholder="E-mail adress ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="email" name="email2" value="" placeholder="Confirm E-mail adress ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="password" name="password" value="" placeholder="Password ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> </p>
    <input type="password" name="password2" value="" placeholder="Confirm Password ..."> <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?></p>
    <label>birthday :</label>
    <SELECT id="month" name="mm" onchange="change_month(this)">
    </SELECT>
    <SELECT id="day" name="dd">
    </SELECT>
    <SELECT id="year" name="yyyy" onchange="change_year(this)">
    </SELECT></p>
    <input type="radio" name="birthsex" value="female"> Female <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> <br>
    <input type="radio" name="birthsex" value="male"> Male <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> <br>
    <input type="radio" name="birthsex" value="other"> Other <?php echo '<span style="color:#AFA;text-align:center;">✔</span>'; ?> <br><br>
    <input type="submit" name="createaccount" value="Create Account">
</form>

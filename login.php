<?php 
$url =  'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/dash.php';
//LOGIN PART

// for the purpuse of testingecho "<div class='alert alert-success' role='alert'>Connected to the database</div>";

// NOTE. IN ORDER TO LOG IN I DECIDED TO USE MAIL INSTEAD OF THE 'NAME' THAT USER GAVE WHEN EGISTERING 	  

// if not empty - user clicks sing up button
//LOGIN GOES HERE
if(!empty(filter_input(INPUT_POST, 'loginSubmit'))){
    //read all inputs and validate them
    $mail = filter_input(INPUT_POST, 'mailLogin', FILTER_VALIDATE_EMAIL)
        or die("<div class='alert alert-danger' role='alert'>Incorrect mail</div>");
    $password = filter_input(INPUT_POST, 'passwordLogin')
        or die("<div class='alert alert-danger' role='alert'>Empty or incorrect password</div>");
    echo $mail.$password;
    $sql = 'SELECT ID, username, password, imig_url FROM user WHERE mail=?';
    $stmt = $con->prepare($sql); //let's prepare to execute our sql, it's gonna be stored in $stmt
    $stmt->bind_param('s', $mail);
    $stmt->execute();
    $stmt->bind_result($userid, $person, $passwordhash, $img_url);
    while($stmt->fetch()){}
    echo '<br>'.$password.'<br>'.$passwordhash;
    if (password_verify($password, $passwordhash)){
        echo 'logged in as user '.$userid.', '.$person;
        $_SESSION['userid'] = $userid;
        $_SESSION['username'] = $mail;
        $_SESSION['person'] = $person;
		$_SESSION['avatar'] = $img_url;
        print_r($_SESSION);
        header('HTTP/1.1 303 See other');
        header('LOCATION:'.$url);
    }
    else{
        echo "<div class='alert alert-danger' role='alert'>Check your email or password and try again</div>";

    }

}


//REGISTER HERE
if (!empty(filter_input(INPUT_POST, 'registerSubmit'))) {
       //read all inputs and validate them
        $user = filter_input(INPUT_POST, 'nameRegister')
        or die('Invalid Name input');
        $mail = filter_input(INPUT_POST, 'mailRegister', FILTER_VALIDATE_EMAIL)
        or die('Incorrect mail');
        $password = filter_input(INPUT_POST, 'passwordRegister')
        or die('Empty or incorrect password');
        // now, when we have all from user, password is being hashed and saled
        $password = password_hash($password, PASSWORD_DEFAULT);

        //checking if the user exist in the database
        $sqlcheck = 'SELECT mail FROM user WHERE mail=?';
        $stmtcheck = $con->prepare($sqlcheck);
        $stmtcheck->bind_param('s', $mail);
        $stmtcheck->execute();
        $stmtcheck->bind_result($mailcheck);
        while ($stmtcheck->fetch()) {
        }
        if ($mail == $mailcheck) {
            echo "<div class='alert alert-danger' role='alert'>
					  This mail is already in our database.
					 </div>";
        } else {

            //now when everything works fine, it's time to put those infromation to the database
            $sql = 'INSERT INTO user (username, mail, password) VALUES (?,?,?)';
            $stmt = $con->prepare($sql);
            $stmt->bind_param('sss', $user, $mail, $password);
            $stmt->execute();

            echo 'Added ' . $stmt->affected_rows . ' users';

        }

}


?>
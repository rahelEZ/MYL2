<?php
require_once "code/init.php";
require_guest($active_user);
//controller
$err = "";
if (!empty($_POST)) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $full_name = $_POST["full_name"];

    $user = new User();
    if (!$user->user_name_available($username)) {
        $err = "The username you picked is taken. try another one";
    } else if (strlen($password) < 6) {
        $err = "please use at least 6 chars for password";
    } else {
        $user->new_user($full_name, $username, $email, $password);
        $user->login();
        redirect("user.php");
    }
//    TODO: add is set valudation
}
//view
include_once "code/header.php";
?>
    <div class="registerFrame">
        <p>
        <p>Create New Account</p>
        <form method="POST">
            <div class="formController">


                <label id="newUserId"> User name: </label>
                <input type="text" name="username" id="newUserId"/>
                <span class="underline"></span>
                <label id="fullName"> Full Name: </label>
                <input type="text" id="newUserName" name="full_name" placeholder="Jane Doe"/>
                <span class="underline"></span>
                <label id="email"> Email: </label>
                <input type="text" id="newEmail" name="email" placeholder="abc@xyz.com"/>
                <span class="underline"></span>
                <label id="password"> Password: </label>
                <input type="password" id="newPassword" name="password" placeholder="Password"/>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
            <div class="error-window"><?= $err ?></div>
            <div>

                <button name="createAccount" type="create" type="submit" id="register">Create</button>
            </div>

        </form>
    </div>


<?php

include_once "code/footer.php";


<?php
require_once "code/init.php";
require_guest($active_user);

if (!empty($_POST) && isset($_POST['login'])) {
    $validation = require_fields(["username" => "Username", "password" => "Password"], $_POST);

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new User();
    if ($validation) {
        $err = $validation;
    } else if (!User::validate_login($username, $password)) {
        $err = "username/password incorrect";
    } else {
        $user->fetch_by_field("username", $username);
        $user->login();
        redirect("home.php");
    }
}

include "code/header.php";
?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <? include '_translate.php' ?>
            </div>
            <div class="col-md-4">
                <form action="" method="post">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Login
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="form-group text-right">

                                <input type="submit" name="login" class="btn btn-primary" value="Login">
                            </div>
                            <div class="form-group text-right">
                                <a href="create_account.php">Create new account</a>
                            </div>
                            <div class="alert alert-danger error-window"><?= $err ?></div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
<?php
include "code/footer.php";
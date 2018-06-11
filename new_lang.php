<?php
require_once "code/init.php";
require_login($active_user);
//controller
$err = "";
if (!empty($_POST)) {
    $lang_name = $_POST["lang_name"];
    $description = $_POST["description"];
    $validation_message = require_fields(["lang_name" => "Language name"], $_POST);
    $language = new Language();
    if ($validation_message) {
        $err = $validation_message;
    } else if (!$language->language_name_available($lang_name)) {
        $err = "Language name is already taken";
    } else {
        $language->create_language($active_user, $lang_name, $description);
        redirect("user.php");
    }

}
//view
include_once "code/header.php";
?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <form method="POST" class="formController">
                    <h2>Create New Language</h2>
                    <div class="form-group">
                        <label id="nameLabel">Name: </label>
                        <input type="text" class="form-control" id="lang_name" name="lang_name"/>
                    </div>
                    <div class="form-group">
                        <label id="descriptionLabel">Description: </label>
                        <textarea class="form-control" id="description" name="description" rows="10"
                                  cols="30"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <a class="btn btn-default" href="user.php">Cancel</a>
                        <button name="submit" type="submit" class="btn btn-primary" id="register">Submit</button>
                    </div>
                    <div class="error-window alert alert-danger"><?= $err ?></div>

                </form>
            </div>
        </div>
    </div>

<?php
include_once "code/footer.php";
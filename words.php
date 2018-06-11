<?php
require_once 'code/init.php';
$lang_id = floor($_GET['lang_id']);
$language = new Language($lang_id);
$creator = new User($language->user_id);
$can_edit = Contributor::can_user_add_word($active_user, $language);
if (!empty($_POST)) {
    $validation_message = require_fields(["word" => "Word", "translation" => "Translation"], $_POST);
    $word = $_POST['word'];
    $translation = $_POST['translation'];
    $new_word = new Word();
    if ($validation_message) {
        $err = $validation_message;
    } else if (!Word::validate_combination($word, $translation, $language)) {
        $err = "This word-translation combination already exists for this language";
    } else {
        $new_word->new_word($word, $translation, $language, $active_user);
    }
}

$all_words = Word::get_all_for_language($language);
require_login($active_user);
include "code/header.php";
?>

    <div class="container">
        <div class="row">


            <div class="col-md-4">
                <?php
                if ($can_edit) {
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Word
                        </div>
                        <div class="panel-body">
                            <form method="post" class="formController">
                                <div class="form-group">
                                    <label id="nameLabel">Word: </label>
                                    <input type="text" id="lang_name" class="form-control" name="word"/>
                                </div>
                                <div class="form-group">
                                    <label id="nameLabel">Translation: </label>
                                    <input type="text" id="lang_name" class="form-control" name="translation"/>
                                </div>
                                <div class="form-group">
                                    <button name="submit" type="submit" class="btn btn-primary" id="register">Submit
                                    </button>
                                </div>
                                <br/>
                                <div class="alert alert-danger error-window"><?= $err ?></div>

                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="text-center">
                            <?= $language->name ?>
                        </h3>

                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Created by:</strong> <?= $creator->full_name ?></li>
                        <li class="list-group-item"><strong>Words Count:</strong> <?= $language->words_count ?></li>
                        <li class="list-group-item"><strong>Rank:</strong> <?= $language->rank ?></li>
                    </ul>
                    <div class="panel-footer">

                         <p><?= nl2br($language->description) ?></p>
                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <h1>Existing Words</h1>
                <table class="table table-bordered">
                    <tr>
                        <th>Word</th>
                        <td>Translation</td>
                        <td>Reliability</td>
                    </tr>
                    <?php
                    foreach ($all_words as $word) {
                        ?>
                        <tr>
                            <td>
                                <?= $word->word ?>
                            </td>
                            <td>
                                <?= $word->translation ?>
                            </td>
                            <td>
                                <?= $word->user_id == $language->user_id ? "High" : "Low" ?>
                            </td>
                        </tr>
                        <?php
                    }

                    ?>
                </table>
            </div>
        </div>
    </div>
<?php
include "code/footer.php";




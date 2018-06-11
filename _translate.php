<?php
$languages = Language::get_list();


if (!empty($_POST) && isset($_POST["translate"])) {
    $translate_source = $_POST["translate"];

    $translation_validation = require_fields(["from_language" => "Source Language", "to_language" => "To Language", "translate_source" => "Input"], $_POST);
    $translation_error = "";
    if ($translation_validation) {

        $translation_error = $translation_validation;
    } else {

        $from_language = new Language($_POST['from_language']);
        $to_language = new Language($_POST['to_language']);
        $text = $_POST['translate_source'];
        $translated_text = Word::translate($from_language, $to_language, strtolower($text));
    }


}


function create_language_list($languages, $name)
{
    foreach ($languages as $language) {
        ?>
        <option <?= $_POST[$name] == $language->id ? "selected" : "" ?>
                value="<?= $language->id ?>"><?= $language->name ?></option>
        <?php
    }
    return "";
}

?>
<div>
    <form method="post">

        <div class="panel panel-default">

            <div class="panel-heading">
                <div class="row">

                    <div class="col-xs-4">
                        Translate
                    </div>

                    <div class="col-xs-4">
                        <select name="from_language" class="form-control">
                            <option value="">From language</option>
                            <?= create_language_list($languages, "from_language") ?>

                        </select>
                    </div>
                    <div class="col-xs-4">
                        <select name="to_language" class="form-control">
                            <option value="">To language</option>
                            <?= create_language_list($languages, "to_language") ?>
                        </select>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <textarea placeholder="Type here" name="translate_source"
                                  class="form-control"><?= $_POST['translate_source'] ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="well well-sm">
                            <p><?= $translated_text ?></p>
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger error-window"><?= $translation_error ?></div>
            </div>
            <div class="panel-footer">
                <div class="row">

                    <div class="col-xs-4">
                        <button name="translate" type="submit" class="btn btn-success">Translate</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

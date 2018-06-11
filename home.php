<?php
require_once "code/init.php";
require_login($active_user);
if (isset($_GET["order_by"]) && in_array($_GET["order_by"], ["asc", "desc"])) {
    $order_by = $_GET["order_by"];
}
$sorted_languages = Language::get_list($order_by);

include "code/header.php";
?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="new_lang.php" class="btn btn-lg btn-block btn-primary">Create language</a>

                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Order by</label>

                    </div>
                    <div class="panel-body">
                        <form action="" method="get">

                            <div class="form-group">
                                <label><input type="radio" <?= $_GET["order_by"] != "asc" ? "checked" : "" ?>
                                              name="order_by" value="desc">
                                    most popular </label><Br/>
                                <label><input type="radio" <?= $_GET["order_by"] == "asc" ? "checked" : "" ?>
                                              name="order_by" value="asc"> least popular </label>
                            </div>
                            <button type="submit" class="btn btn-success">Reorder</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php
                include "_translate.php"
                ?>
                <div class="row">
                    <?php
                    foreach ($sorted_languages as $language) {
                        ?>
                        <div class="col-sm-6 col-md-4">


                            <div class="caption thumbnail alert alert-info">

                                <h3><?= $language->name ?></h3>

                                <p>Word Count: <span class="text-muted"><?= $language->words_count ?></span></p>
                                <p>Rank: <span class="text-muted"><?= $language->rank ?></span></p>

                                <p>
                                    <a href="words.php?lang_id=<?= $language->id ?>" class="btn btn-primary"
                                       role="button">
                                        View Words
                                    </a>
                                </p>

                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
<?php
include "code/footer.php";
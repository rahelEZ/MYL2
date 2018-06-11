<?php
require_once "code/init.php";
require_login($active_user);
$user_languages = Language::languages_for_user($active_user);
include_once "code/header.php"
?>
    <!----------------------------- Whole content ---------------->
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="well well-lg">
                    <h4><?= $active_user->full_name ?></h4>
                    <p class="text-muted">@<?=$active_user->username?></p>
                    <p><?=$active_user->email?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>My Languages <a href="new_lang.php" class="btn pull-right btn-success">Create Language</a></h3></div>

                    <ul class="list-group">
                        <?php
                        foreach ($user_languages as $lang) {
                            ?>
                            <li class="list-group-item"><a
                                        href="words.php?lang_id=<?= $lang->id ?>"><?= $lang->name ?></a>
                                <?php
                                if ($lang->user_id == $active_user->id) {
                                    ?>
                                    <span class="pull-right">[<a href="contributors.php?lang_id=<?= $lang->id ?>"> Edit
                                            Contributors</a>]</span>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <div class="mainContent">


        <?php


        function getUserData()
        {
            $conn = new mysqli("localhost", "root", "", "MYL");
            $userId = $_POST['id'];
            $sql2 = "select * from users where userId =  \"" . $userId . "\";";

            $result = mysqli_query($conn, $sql2);
            $row_number = $result->num_rows;

            echo "<div class = \"middleContent\">";

            if ($row_number > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo ">";
                    echo "<div class = \"smallBoxes\" style = \"position:relative; width:100px; height:100px; background:rgba(0,0,0,0.5); float:left; margin:15px; border-radius:25px;\">
                        <textarea row = \"1\" cols = \"10\" name=\"langId\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">{$row['langId']}</textarea>
                        <textarea row = \"1\" cols = \"10\" name=\"userType\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">{$row['userType']}</textarea>
                        <textarea row = \"1\" cols = \"10\" name=\"id\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">$userId</textarea><button type = \"submit\"><p> {$row['langId']}</p><p> {$row['userType']}</p><p> {$row['wordsInput']}</p></button>
                       
                        </div>";
                    echo("</form>");

                }
            } else {
                echo "it is not working";
            }

            echo "</div>";
        }

        function getData()
        {
            $conn = new mysqli("localhost", "root", "", "MYL");
            // getting data
            $userId = $_POST['id'];
            $sqlTranslate = "SELECT * FROM  Languages;";
            //echo $sqlTranslate;

            $resultFrom = mysqli_query($conn, $sqlTranslate);

            $row_numberFrom = $resultFrom->num_rows;
            //echo $row_numberFrom;
            echo "<div class = \"middleContent\">";

            if ($row_numberFrom > 0) {
                while ($row = $resultFrom->fetch_assoc()) {
                    echo ">";
                    echo "<div class = \"smallBoxes\" style = \"position:relative; width:100px; height:100px; background:rgba(0,0,0,0.5); float:left; margin:20px;border-radius:25px;\">
                        <textarea row = \"1\" cols = \"10\" name=\"langId\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">{$row['langId']}</textarea>
                        <textarea row = \"1\" cols = \"10\" name=\"userType\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">0</textarea>
                        <textarea row = \"1\" cols = \"10\" name=\"id\" method=\"POST\"  style = \"display:none;\"class=\"languagesForm\">$userId</textarea><button type = \"submit\" style=\"position:relative;height:100%;width:100%;\"><p> {$row['langId']}</p></button></div>";
                    echo("</form>");
                }

            } else {
                echo "it is not working";
            }

            echo "</div>";

        }


        ?>


    </div>


<?php

include_once "code/footer.php";
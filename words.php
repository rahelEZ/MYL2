<?php
require_once 'code/init.php';
$lang_id = floor($_GET['lang_id']);
$language = new Language($lang_id);
$creator = new User($language->user_id);
$can_edit = Contributor::can_user_add_word($active_user, $language);
header("words.php");
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
                    <form method="post" class="formController" name = "add"  >
                        <div class="form-group">
                            <label id="nameLabel">Word: </label>
                            <input type="text" id="lang_name" class="form-control" name="word"/>
                        </div>
                        <div class="form-group">
                            <label id="nameLabel">Translation: </label>
                            <input type="text" id="lang_name" class="form-control" name="translation"/>
                        </div>
                        <div class="form-group">
                            <button name="submit" method="POST" type="submit" class="btn btn-primary" id="add">Submit
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
                    <td>Controls</td>
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
                    <td> 

                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id = "<?php echo $word->word; echo "-".$lang_id; ?>" onclick = "showDetails(this)">Edit</button> 
                        <button type="button" class="btn btn-primary" data-toggle="modal"  data-target="#deleteModal" id = "<?php echo $word->word; echo "-".$lang_id; ?>"  onclick = "addWord(this)">Delete</button> 
                    </td>
                </tr>
                <?php
    }

                ?>
            </table>

            <!------------------ Pop up file ---------------------->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Word Editor</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="formController" name = "edit" >
                                <div class="form-group">
                                    <label id="nameLabel">Word: </label>
                                    <input type="text" id="word_edit" class="form-control" name="word_edit"/>
                                </div>
                                <div class="form-group">
                                    <label id="nameLabel">Translation: </label>
                                    <input type="text" id="translation_edit" class="form-control" name="translation_edit"/>
                                </div>
                                <input type = "text" id = "pre_word" name = "pre_word" style = "display:none;">
                                <input type = "text" id = "pre_word" name = "pre_translation" style = "display:none;">

                                <br/>
                         
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary"  id="register" onclick = "editWord(this)" >Submit
                                    </button>
                                </div>
                            </form>
                        </div>

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

            <!------------------ Pop up file ---------------------->

            <div id="deleteModel" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Word Editor</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="formController" name = "edit" >
                                <div class="form-group">
                                    <label id="nameLabel">Word: </label>
                                    <span></span>
                                </div>
                                <div class="form-group">
                                    <label id="nameLabel">Translation: </label>
                                    <span></span>
                                </div>

                                <br/>
                  
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button name="delete"  type="button" class="btn btn-primary" id="delete">Delete
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
			
			<!------------------------- delete word ---------------------------->
					          <div id="deleteModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Word Editor</h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" class="formController" name = "edit" >
                                <div class="form-group">
                                    <h4>Are you sure, you want to delete?</h4>
                                </div>
        
                                <br/>
                               
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button name="button"  class="btn btn-primary" id="register" onclick="deleteWord()">Yes
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        var word;
        var lang_id;
        var translation;
        function showDetails(button){
            var  array = button.id.split("-");
            word = array[0];
            lang_id = array[1];

            $.ajax({
                url: "code/help.php",
                method: "GET",
                data: {"function":"get","word": word, "lang_id": lang_id},
                success: function(response){
                    var reply = JSON.parse(response);
                    translation = reply.translation;
                    document.getElementById("word_edit").value = word;
                    document.getElementById("translation_edit").value = translation;
                }
            });

        }

        function editWord(form){
            $('#myModal').modal('hide');
            var new_word = document.getElementById("word_edit").value;
            var new_translation = document.getElementById("translation_edit").value;
            $.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"edit", "lang_id":lang_id, "pre_word":word, "word":new_word,"translation":new_translation},
                success: function(response){
					redirect("words.php");
                }
            });
        }

        function deleteWord(){
           // var  array = button.id.split("-");
           // word = array[0];
           // lang_id = array[1]; 

            $.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"delete", "word": word, "lang_id": lang_id},
                success: function(response){ 
					redirect("words.php");
                }
            });
			window.alert("Delete completed");
        }
		function addWord(button){
			var  array = button.id.split("-");
            word = array[0];
            lang_id = array[1]; 
		}
		function increment(lang_id){
			window.alert(lang_id);
			  $.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"increment", "lang_id": lang_id},
                success: function(response){ 
					redirect("words.php");
                }
            });
		}
		function refresh(){
			window.alert("it is here");
			redirect("words.php");
		}
    </script>
    <?php
    include "code/footer.php";




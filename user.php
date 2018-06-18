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
                                    <span class="pull-right">
									<button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" style= "margin-top:-8px;" onclick = "save_lang_id(this)" id = "<?php echo $lang->id;?>" >Change name</button>
									<button type = "button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal" style= "margin-top:-8px;" onclick = "save_lang_id(this)" id = "<?php echo $lang->id;?>" > Delete</button>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style=" background: rgba(255,255,255,0.0); color:black; border:0px; margin-top:-10px;" onclick = "save_lang_id(this)"id = "<?php echo $lang->id;?>" >Edit Contributors</button> </span>
                                    <?php
                                }
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                <!------------------------Pop up ---------------------------->
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
                                    <label id="nameLabel">Add Contributor: </label>
                                    <input type="text"  class="form-control" name="word_edit" id = "contributer"/>
                                    <select class="form-control" id = "type">
                                        <option value="contributor">Contributor</option>
                                    </select>
                                </div>
        
                                <br/>
                                <div class="alert alert-danger error-window"><?= $err ?></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button name="button"  class="btn btn-primary" id="register" onclick="addContributer(this)">Add
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
			
			<!--------------------------------- delete popup---------------------------------->
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
                                <div class="alert alert-danger error-window"><?= $err ?></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                    <button name="button"  class="btn btn-primary" id="register" onclick="deleteLang()">Yes
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
			
			<!-------------------------------- edit popup----------------------------------------->
			                        <div id="editModal" class="modal fade" role="dialog">
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
                                    <label id="nameLabel">New name: </label>
                                    <input type="text"  class="form-control" name="change_name" id = "new_name"/>
                                </div>
        
                                <br/>
                                <div class="alert alert-danger error-window"><?= $err ?></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button name="button"  class="btn btn-primary" id="register" onclick="changeName(this)">Add
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
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
        <script>
        var name;
		var  lang_id;
		var type;
		var user_id;
        function save_lang_id(button){
            name = button.id;
            
        }
     function addContributer(form){
         
            var contributerId = document.getElementById("contributer").value;
			lang_id = name;
            var  strUser= document.getElementById("type");
            type = strUser.options[strUser.selectedIndex].value;
            
			$.ajax({
                url: "code/help.php",
                method: "GET",
                data: {"function":"get_user_id", "username": contributerId},
                success: function(response){
						var reply = JSON.parse(response);
						
						if(!reply){
							window.alert("User does not exit!");
						}
						else{
							user_id =reply.id;
							addNewCon();
						}
						

                }
            });
			
	 }
	 function deleteLang(){
			  $.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"delete_lang","lang_id": name},
                success: function(response){
					window.location.reload(true);
					redirect("user.php");
                }
            });
		}
	 function addNewCon(){
            $.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"addContributer", "user_id": user_id, "type": type, "language_id": lang_id},
                success: function(response){
					window.location.reload(true);
					redirect("user.php");
                }
            });
			
			

        }
		function changeName(form){
			var new_name = document.getElementById("new_name").value;
				$.ajax({
                url: "code/help.php",
                method: "POST",
                data: {"function":"change_lang_name","lang_id": name, "new_name":new_name},
                success: function(response){
					window.location.reload(true);
					redirect("user.php");
                }
				
            });
		}
		
        </script>

<?php

include_once "code/footer.php";
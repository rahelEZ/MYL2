<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "MYL2";
// Create connection
$con = new mysqli($servername, $username, $password, $database);
if(isset($_POST['function'])){
    if($_POST['function'] == 'edit'){
        $pre_word = $_POST["pre_word"];
        $word = $_POST["word"];
        $translation =  $_POST["translation"];
        $lang_id = $_POST["lang_id"];
        $result = mysqli_query($con, "UPDATE words SET word = \"".$word."\", translation = \"".$translation."\" WHERE language_id = \"".$lang_id."\" AND word = \"".$pre_word."\";");
    }
    elseif($_POST['function'] == 'delete'){
     $word = $_POST["word"];
    $lang_id = $_POST["lang_id"];
    $result = mysqli_query($con, "DELETE FROM words WHERE word = \"".$word."\" AND language_id = \"".$lang_id."\";");
	$decrease = mysqli_query($con, "UPDATE languages  SET words_count = words_count-1 WHERE id = \"".$lang_id."\";");

    }
	
	elseif($_POST['function'] == 'increment'){
		$lang_id = $_POST["lang_id"];
		$decrease = mysqli_query($con, "UPDATE languages  SET words_count = words_count+1 WHERE id = \"".$lang_id."\";");
		
	}
	elseif($_POST['function'] == 'delete_lang'){
		$lang_id = $_POST["lang_id"];
		$result = mysqli_query($con, "DELETE FROM languages WHERE id = \"".$lang_id."\";");
	}
	elseif($_POST['function'] == 'change_lang_name'){
		$lang_id = $_POST["lang_id"];
		$new_name = $_POST["new_name"];
		$result = mysqli_query($con, "UPDATE languages SET name = \"".$new_name."\" WHERE id = \"".$lang_id."\";");
		
	}
    else{
        $contributerId = $_POST["user_id"];
        $type = $_POST["type"];
        $language_id = $_POST["language_id"];
        $result = mysqli_query($con, "INSERT INTO contributors (language_id,user_id,type) VALUES (\"".$language_id."\", \"".$contributerId."\", \"".$type."\");"); 
		$pre_info = mysqli_fetch_object($result);
        echo json_encode($pre_info); 
    }
}
if(isset($_GET['function'])){
	if($_GET['function'] == 'get_user_id'){
		$username = $_GET["username"];
		$result = mysqli_query($con, "SELECT * FROM users WHERE username = \"".$username."\";");
		$pre_info = mysqli_fetch_object($result);
        echo json_encode($pre_info); 
		
	}
		if($_GET['function'] == 'get_word_count'){
		$lang_id = $_GET["lang_id"];
		$result = mysqli_query($con, "SELECT * FROM languages WHERE id = \"".$lang_id."\";");
		$pre_info = mysqli_fetch_object($result);
        echo json_encode($pre_info); 
		
	}
	if($_GET['function'] == 'get'){
        $word = $_GET["word"];
        $lang_id = $_GET["lang_id"];
        $result = mysqli_query($con, "SELECT * FROM words WHERE word = \"".$word."\" AND language_id = \"".$lang_id."\";");

        $pre_info = mysqli_fetch_object($result);
        echo json_encode($pre_info);  
	}
}


?>
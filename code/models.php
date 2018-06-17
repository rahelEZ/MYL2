<?php

class Model
{
    public $TABLE;
    public $id;

    protected function connection()
    {
        return $GLOBALS['conn'];
    }

    function __construct($id = null)
    {
        if ($id != null) {
            $this->fetch_by_field("id", $id);
        }
    }

    protected function mapResult($instance, $result)
    {
        foreach ($result as $key => $value) {
            $instance->$key = $value;
        }
        return $instance;
    }

    public function fetch_by_field($field, $value)
    {
        $table = $this->TABLE;
        $sql_string = "select * from $table where $field='$value'";

        $query = mysqli_query($this->connection(), $sql_string);
        $row = $query->fetch_array();
        $this->mapResult($this, $row);
    }

    protected function fetch_multiple($where, $combine_by = "AND", $external = "")
    {
        $table = $this->TABLE;
        $where_flat = array();
        foreach ($where as $key => $value) {
            $where_flat[] = $key . " = '" . $value . "'";
        }
        $sql_string = "select * from $table where " . implode(" $combine_by ", $where_flat) . " " . $external;

        return $this->compose_multiple($sql_string);
    }

    protected function compose_multiple($sql_string)
    {

        $class = get_class($this);
        $query = mysqli_query($this->connection(), $sql_string);
        $results = [];
        while ($row = $query->fetch_array()) {

            $instance = new $class;

            $results[] = $this->mapResult($instance, $row);
        }
        return $results;
    }

    protected function get_where_field_in($field, $collection, &$map_to = null)
    {
        if (empty($collection)) {
            return [];
        }
        $sql_string = "select * from {$this->TABLE} where $field in ('" . implode("','", $collection) . "')";
        $returned_items = $this->compose_multiple($sql_string);

        if ($map_to != null) {
            foreach ($returned_items as $item) {
                $key = $item->$field;
                $map_to[$key] = $item;
            }
        }
        return $this->compose_multiple($sql_string);
    }

    public function create($value_pair)
    {
        $table = $this->TABLE;
        $key_list = implode(",", array_keys($value_pair));
        $value_list = "'" . implode("','", array_values($value_pair)) . "'";
        $sql_string = "INSERT INTO $table ($key_list) VALUES ($value_list)";
        $query = mysqli_query($this->connection(), $sql_string);
    }
    public function delete($value_pair)
    {
        $table = $this->TABLE;
        $key_list = implode(",", array_keys($value_pair));
        $value_list = "'" . implode("','", array_values($value_pair)) . "'";
        $sql_string = "DELETE FROM $table ($key_list) VALUES ($value_list)";
        $query = mysqli_query($this->connection(), $sql_string);
    }
    public function update($word,$translation,$word_edit,$translation_edit,$language,$user)
    {
        $table = $this->TABLE;
        $key_list = implode(",", array_keys($value_pair));
        $value_list = "'" . implode("','", array_values($value_pair)) . "'";
        $sql_string = "UPDATE $table SET word = $word_edit, translation = $translation_edit  WHERE language_id = $language AND user_id = $user AND word = $word ";
        $query = mysqli_query($this->connection(), $sql_string);
    }
    public function value_with_key_exists($field, $value)
    {

        $table = $this->TABLE;
        $sql_string = "select id from $table  where $field = '$value'";
        $query = mysqli_query($this->connection(), $sql_string);
        return $query->num_rows > 0;
    }

}


class User extends Model
{
    public $TABLE = "users";


    public $username;
    public $password;
    public $full_name;
    public $rank;
    public $email;


    function new_user($full_name, $username, $email, $password)
    {

        $this->create([
            "username" => $username,
            "password" => $password,
            "email" => $email,
            "full_name" => $full_name
        ]);
        $this->fetch_by_field("username", $username);
    }

    function user_name_available($username)
    {
        return !$this->value_with_key_exists("username", $username);
    }

    function login()
    {

        $_SESSION['user_id'] = $this->id;
    }

    static function validate_login($username, $password)
    {
        $instnace = new self();

        $user = $instnace->fetch_multiple([
            "username" => $username,
            "password" => $password,
        ]);
        return count($user) > 0;
    }

}

class Language extends Model
{

    public $TABLE = "languages";

    public $user_id;
    public $words_count;
    public $name; //lang id
    public $rank;
    public $description;

    public static function languages_for_user($active_user)
    {
        $instance = new self();
        $language_ids_for_user = Contributor::user_lang_ids($active_user);
        return $instance->get_where_field_in("id", $language_ids_for_user);
    }


    public function create_language($user, $lang_name, $description)
    {
        $this->create([
            "user_id" => $user->id,
            "name" => $lang_name,
            "description" => $description
        ]);
        $this->fetch_by_field("name", $lang_name);
        $contributor = new Contributor();
        $contributor->add_contributor($user, $this, Contributor::$CONTRIBUTOR_TYPE['owner']);

    }

    public function language_name_available($lang_name)
    {
        return !$this->value_with_key_exists("name", $lang_name);
    }

    public static function get_list($order= "desc")
    {
        $instance = new self();


        return $instance->fetch_multiple([
            '1' => '1'
        ], " AND ", "order by words_count " . $order);

    }

    public function increment_words()
    {
        $rank = LanguageGradeRule::get_grade_for_count($this->words_count + 1);
        $sql_string = "UPDATE {$this->TABLE} SET words_count = words_count + 1, rank='{$rank}' WHERE id = '{$this->id}'";
		$words_count=$words_count+1;
        $query = mysqli_query($this->connection(), $sql_string);
		header("word.php");
		
    }
    public function decrement_words()
    {
        $rank = LanguageGradeRule::get_grade_for_count($this->words_count - 1);
        $sql_string = "UPDATE {$this->TABLE} SET words_count = words_count - 1, rank='{$rank}' WHERE id = '{$this->id}'";
        $query = mysqli_query($this->connection(),$sql_string);
    }

}

class Contributor extends Model
{

    public static $CONTRIBUTOR_TYPE = [
        "owner" => "owner",
        "editor" => "editor"
    ];

    public $TABLE = "contributors";

    public $language_id;
    public $user_id;
    public $type;

    public static function can_user_add_word($active_user, $language)
    {
        $instance = new self();
        return count($instance->fetch_multiple([
                "user_id" => $active_user->id,
                "language_id" => $language->id
            ])) > 0;
    }

    public function add_contributor($user, $lang, $type)
    {
        $this->create([
            "user_id" => $user->id,
            "language_id" => $lang->id,
            "type" => $type
        ]);
    }

    public static function user_lang_ids($user)
    {
        $instance = new self();
        $values = $instance->fetch_multiple([
            "user_id" => $user->id,
        ]);
        $ids = [];
        foreach ($values as $val) {
            $ids[] = $val->language_id;
        }
        return $ids;


    }
}

class Log
{

}

class Word extends Model
{
    public $TABLE = "words";

    public $word;
    public $translation;
    public $user_id;
    public $lang_id;

    public static function validate_combination($word, $translation, Language $language)
    {
        $instance = new self();
        return count($instance->fetch_multiple([
                'word' => $word,
                'translation' => $translation,
                'language_id' => $language->id
            ])) == 0;
    }

    public function new_word($word, $translation, $language, $user)
    {
		
        $language->increment_words();
        $this->create([
            'word' => strtolower($word),
            'translation' => strtolower($translation),
            'language_id' => $language->id,
            'user_id' => $user->id
        ]);

    }
    
    public function delete_word($word, $translation, $language, $user)
    {
        $this->delete([
            'word' => strtolower($word),
            'translation' => strtolower($translation),
            'language_id' => $language->id,
            'user_id' => $user->id
        ]);
        $language->decrement_words();
    }
    public function update_word($word,$translation,$word_edit, $translation_edit,$language,$user)
    {
        $this->update([
            'word' => strtolower($word),
            'translation' => strtolower($translation),
            'word_edit' => strtolower($word_edit),
            'translation_edit' => strtolower($translation_edit),
            'language_id' => $language->id,
            'user_id' => $user->id
        ]);
    }

    public static function get_all_for_language($language)
    {
        $instance = new self();
        return $instance->fetch_multiple(['language_id' => $language->id]);
    }

    public static function translate($from_language, $to_language, $text)
    {
        $instance = new self();

        $words_to_translate = explode(" ", $text);
        $retriver = "select word,translation from words where language_id={$from_language->id} and word in ('" . implode("','", $words_to_translate) . "')";
        $query = mysqli_query($instance->connection(), $retriver);

        $translation_map = [];
        while ($row = $query->fetch_array()) {
            if (in_array($row['word'], $words_to_translate)) {
                $translation_map[$row['translation']] = $row['word'];
            }
        }


        $final = "select word,translation from words where language_id={$to_language->id} and translation in ('" . implode("','", array_keys($translation_map)) . "')";
        $query = mysqli_query($instance->connection(), $final);
        $translated_list = [];
        while ($row = $query->fetch_array()) {

            $translated_list[$row['translation']] = $row['word'];
        }
        $text = "";
        foreach ($words_to_translate as $word) {
            $key = array_search($word, $translation_map);

            if ($key && $translated_list[$key]) {
                $text .= $translated_list[$key] . " ";
            } else {
                $text .= $word . " ";
            }
        }
        return $text;


    }
}

class LanguageGradeRule extends Model
{
    public $TABLE = "language_grade_rules";
    public $words_count;
    public $grade;


    public static function get_grade_for_count($words_count)
    {
        $instance = new self();
        $sql = "select grade from {$instance->TABLE} where words_count<=$words_count  order by words_count DESC limit 1";
        $query = mysqli_query($instance->connection(), $sql);
        $row = $query->fetch_array();
        return $row['grade'];
    }

    public static function generate_rules()
    {
        $rules = [
            "5" => "D-",
            "10" => "D",
            "15" => "D+",
            "20" => "C-",
            "25" => "C",
            "30" => "C+",
            "40" => "B-",
            "55" => "B",
            "70" => "A-",
            "85" => "A",
            "100" => "A+",

        ];
        foreach ($rules as $key => $value) {
            $instance = new self();
            $instance->create([
                "words_count" => $key,
                "grade" => $value
            ]);
        }
    }

}

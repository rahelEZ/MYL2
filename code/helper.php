<?php
function redirect($target)
{
    header("Location: $target");
}

function require_login($user)
{
    if ($user == null) {
        redirect("index.php");
    }
}

function require_guest($user)
{
    if ($user != null) {
        redirect("home.php");
    }
}

function require_fields($fields, $value_set)
{
    $response = null;
    foreach ($fields as $key => $value) {

        if (!array_key_exists($key, $value_set) || $value_set[$key] == "") {
            $response = $value . " is required";
            break;
        }

    }
    return $response;
}
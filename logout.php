<?php
require_once "code/init.php";
require_login($active_user);
session_destroy();
redirect("index.php");
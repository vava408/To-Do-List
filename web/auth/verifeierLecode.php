<?php

$code = trim($_POST['code']);

if($code == $_SESSION["code"])
{
    echo json_encode(["success" => "Code correcte."]);
	session_destroy();

}

<?php

	function genereSessionCode($code)
    {
        session_start();
        $_SESSION["code"] = $code;
        session_cache_expire(5 , "");

    }
?>
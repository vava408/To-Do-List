<?php
session_start();
session_destroy();
header("Location: ../pages/home.html");
exit();
?>
<?php
session_start();

function getUser() {
    return $_SESSION['user'] ?? 'guest';
}

?>
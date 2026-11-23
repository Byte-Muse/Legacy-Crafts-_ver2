<?php
session_start();
const BASE_URL = "/tp7_php/";
function h($text){
    return htmlspecialchars((string) $text, ENT_QUOTES, "UTF-8");
}

function setFlash($message, $type = "success"){
    $_SESSION["flash"] = ["message" => $message, "type" => $type];
}
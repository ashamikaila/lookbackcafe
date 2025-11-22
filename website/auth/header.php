<?php
session_start(); // must be first line

$isLoggedIn = isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"];
$userName = $_SESSION["user_name"] ?? "User";
$userAvatar = $_SESSION["user_avatar"] ?? null;

function getUserInitials($name): string
{
    $words = explode(' ', trim($name));
    if (count($words) >= 2) {
        return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
    }
    return strtoupper(substr($name, 0, 2));
}

$userInitials = getUserInitials($userName);
?>

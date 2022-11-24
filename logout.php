<?php

@include 'config.php';
class RegisteredUser{
    public function logout($conn){
session_start();
session_unset();
session_destroy();

header('location:login.php');
    }}
    $new = new RegisteredUser();
    $new-> logout($conn);
?>
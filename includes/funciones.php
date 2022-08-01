<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function iniciarSesion($id,$nombre,$email,$login){
    session_start();
    $_SESSION['id']= $id;
    $_SESSION['nombre'] = $nombre;
    $_SESSION['email']= $email;
    $_SESSION['login']= $login;
}
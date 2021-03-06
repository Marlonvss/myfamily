<?php

error_reporting(0);
session_start();

include_once './autoload.php';
include_once './../autoload.php';


$Controll = new CONTROLLERusuarios();
$_ID = ($_POST['id']);
$_EMAIL = ($_POST['email']);
$_SENHA = md5($_POST['senha']);
$_NOME = ($_POST['nome']);
$_ID_FAMILIA = unserialize($_SESSION['userLogged'])->id_familia;

if (isset($_POST['metodo'])) {
    $metodo = $_POST['metodo'];
}

if ($metodo == 'add') {
    $Obj = new usuarios(0, $_EMAIL, $_SENHA, $_NOME, $_ID_FAMILIA);
    $erro = $Controll->Save($Obj);
    if ($erro->erro) {
        echo $erro->mensagem;
    }
}

if ($metodo == "edit") {
    $Obj = new usuarios($_ID, $_EMAIL, $_SENHA, $_NOME, $_ID_FAMILIA);
    $erro = $Controll->Save($Obj);
    if ($erro->erro) {
        echo $erro->mensagem;
    }
}

if ($metodo == "remove") {
    $erro = $Controll->Remove($_ID);
    if ($erro->erro) {
        echo $erro->mensagem;
    }
}

if ($metodo == "load") {
    $Obj = new usuarios($_ID);
    $erro = $Controll->RecuperaByID($Obj);
    if ($erro->erro) {
        echo $erro->mensagem;
    }
    header('Content-Type: application/json');
    echo json_encode($Obj->getFields(false));
}

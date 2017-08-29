<?php
session_start();
include('conf/db.php');
include('controller/SiteController.php');

spl_autoload_register(function($class){
    include 'model/' .$class . '.php';
});

$controller = new SiteController($dbObject);

if(empty($_SESSION['item_user']) && empty($_COOKIE['item_user']))
{
    echo $controller->checkData();
}
else
{
    (!empty($_SESSION['item_user'])) ? $userData = $_SESSION['item_user'] : $userData = $_COOKIE['item_user'];
    if(!empty($_GET['new']))
    {
        if(!empty($_POST['add']))
        {
            $addRes = $controller->addCargo($_POST['add']);
            echo $controller->mainPage($userData, $addRes);
        }


        switch($_GET['new'])
        {
            case 'add':
                echo $controller->addCargoPage();
                break;
            case 'show':
                echo $controller->showCargoPage();
                break;
            default: continue;
        }
    }
    else if(!empty($_GET['manager_cargo']))
    {
        $assignedRes = $controller->managerAssign($_GET['manager_cargo']);
        echo $controller->mainPage($userData, $assignedRes);
    }
    else if(!empty($_GET['user']) && !empty($_GET['type']))
    {
        echo $controller->showUser(array('user' => $_GET['user'], 'type' => $_GET['type']));
    }
    else if(!empty($_GET['edit_cargo']))
    {
        if(!empty($_POST['EDIT_CARGO']))
        {
            $editRes = $controller->editCargo($_POST['EDIT_CARGO']);
            echo $controller->mainPage($userData, $editRes);
        }
        else
        {
            echo $controller->cargoEditPage($_GET['edit_cargo']);
        }
    }
    else if(!empty($_GET['make_table']))
    {
        $controller->makeTable($userData, $_GET['make_table']);
    }
    else
    {
        echo $controller->mainPage($userData);
    }
}
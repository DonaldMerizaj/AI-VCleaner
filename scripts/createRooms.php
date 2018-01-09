<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/17/2017
 * Time: 5:58 PM
 */

include("Room.php");
include("VCleaner.php");

session_start();
if (isset($_POST["createRooms"])) {
    initCreateRooms();
    echo json_encode(createRooms());
}
//nese i ka krijuar fillimisht dhomat por i ndryshon konfigurimet gjate pastrimit
if (isset($_POST["createRooms"]) && isset($_POST["continue_clean"])) {
    echo json_encode(createRooms());
}

if (isset($_POST["clean"])) {
    echo json_encode(createRooms());
}

function initCreateRooms()
{
    if (!isset($_SESSION["energy_spent"])){
        $_SESSION["energy_spent"] = 0;
    } else {
        $_SESSION["energy_spent"] = 0;
    }

}

function createRooms()
{
    $r_width = htmlentities($_REQUEST['r_width']);
//        $r_height = htmlentities($_REQUEST['r_height']);
    $dirt_room = htmlentities($_REQUEST['dirt_room']);

    $vc_room = htmlentities($_REQUEST['vc_room']);

    $vc = new VCleaner($vc_room);

    $dirt_level_a = $dirt_level_b = 0;
    if ($dirt_room == 1) {
        $dirt_level_a = htmlentities($_REQUEST['dirt_level_a']);
    } else if ($dirt_room == 2) {
        $dirt_level_b = htmlentities($_REQUEST['dirt_level_b']);
    } else if ($dirt_room == 3) {
        $dirt_level_a = htmlentities($_REQUEST['dirt_level_a']);
        $dirt_level_b = htmlentities($_REQUEST['dirt_level_b']);
    }

    $rooma = new Room($r_width, $r_width, $dirt_level_a, $vc);
    $roomb = new Room($r_width, $r_width, $dirt_level_b, $vc);

//        echo json_encode($rooma->printMatrixRoom());
//        echo json_encode($roomb->printMatrixRoom());
//        die();
    return [
        'sts' => 1,
        'rooma' => $rooma->printMatrixRoom(),
        'roomb' => $roomb->printMatrixRoom(),
    ];
}

function cleanRoom(Room $room)
{

}

class Cleaning
{
    public $ra, $rb, $dirtRoom, $vcRoom;

}



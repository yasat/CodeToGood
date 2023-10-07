<?php
session_start();

if(isset($_GET['id'])){
    unset($_SESSION['story_id']);
}

if(isset($_SESSION['story_id'])){

    if(count($_SESSION['place'])-1 == $_SESSION['current_scene']){
        $action = strtolower("charecters/".$_SESSION['charecter']. "/" . $_SESSION['charecter'] . "_victory.gif");
        $url = "won.php?id=" . urlencode($_SESSION['story_id']) . "&action=" . urlencode($action);
        header("Location: " . $url);
        exit;
    }

    $_SESSION['current_scene'] = $_SESSION['current_scene'] + 1;
    $place = $_SESSION['place'][$_SESSION['current_scene']];
    $action = $_SESSION['action'][$_SESSION['current_scene']];

    $url = "show_animation.html?place=" . urlencode($place) . "&action=" . urlencode($action);
    header("Location: " . $url);
    exit;
}

$id = $_GET['id'];

$con = mysqli_connect('localhost','root','','cfg') or die("connection failed");

$rows = mysqli_query($con, "select * from custom_stories where id=$id");
$row = mysqli_fetch_row($rows);

$charecter = $row[1];
$sequence = $row[2];

$sequences = explode(", ", $sequence);

$actions = array();
$places = array();

for ($i = 0; $i < count($sequences); $i++) {
    if($i%2==0){
        array_push($actions, strtolower("charecters/".$charecter. "/" . $charecter . "_". $sequences[$i] . ".gif"));
    }
    else{
        array_push($places, strtolower("places/" . $sequences[$i] . ".png"));
    }
}

$_SESSION['story_id'] = $id;
$_SESSION['place'] = $places;
$_SESSION['charecter'] = $charecter;
$_SESSION['action'] = $actions;
$_SESSION['current_scene'] = -1;

$url = "run_story.php";
header("Location: " . $url);
exit;

?>
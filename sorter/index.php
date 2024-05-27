<?php

$db = require ('db.php');
$connect = mysqli_connect($db['host'], $db['username'], $db['password'], $db['database']);
if (mysqli_connect_errno())
    print_r(mysqli_connect_error());

// set index to hashtags
if (!isset($_GET['p'])) {
    $_GET['p'] = 'tags';
}

// api
if (isset($_POST['add-channel'])) {
    $sql = "INSERT INTO `Channel`(
        `name`, `Description`, `fav`) 
        VALUES (  
            '" . htmlspecialchars($_POST['name']) . "',
            '" . htmlspecialchars($_POST['description']) . "',
            '" . $_POST['fav'] . "'
        )";
    $sql1 = "SELECT * FROM `Channel` WHERE name = '" . htmlspecialchars($_POST['name']) . "'";
    $res = mysqli_query($connect, $sql1);
    if (mysqli_num_rows($res) > 0) {
        $sql = "UPDATE `Channel` SET `Description` = '" . htmlspecialchars($_POST['description']) . "', `fav` = '" . $_POST['fav'] . "' WHERE name = '" . htmlspecialchars($_POST['name']) . "'";
    }
    mysqli_query($connect, $sql);
}

if (isset($_POST['add-post'])) {
    $post_description = $_POST['description'];
    $selected_channel = $_POST['channel'];

    $hash_pattern = '/#([^\s#]+)/u';
    if (preg_match($hash_pattern, $post_description, $matches)) {
        $hashtag = $matches[1];
    }
    if (!isset($hashtag)) {
        $hashtag = 'no_hashtag';
    }
    $sql = "SELECT id FROM `hashtags` WHERE name = '$hashtag'";
    $res = mysqli_query($connect, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $hashtag_id = $row['id'];
    } else {
        $sql = "INSERT INTO `hashtags` (`name`) VALUES ('" . htmlspecialchars($hashtag) . "')";
        mysqli_query($connect, $sql);
        $hashtag_id = mysqli_insert_id($connect);
    }
    $sql = "SELECT id, fav FROM Channel WHERE name = '$selected_channel'";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($res);
    $channel_id = $row['id'];
    $fav = $row['fav'];

    mysqli_free_result($res);

    $sql = "INSERT INTO `SMS`(
        `hashtag_id`, `channel_id`, `Description`, `save`) 
        VALUES (  
            '" . htmlspecialchars($hashtag_id) . "',
            '" . htmlspecialchars($channel_id) . "',
            '" . htmlspecialchars($_POST['description']) . "',
            '" . htmlspecialchars($fav) . "'
        )";
    mysqli_query($connect, $sql);
}

if (isset($_POST['add-field'])) {
    $sql = "INSERT INTO `Field`(
        `name`, `description`) 
        VALUES (
            '" . htmlspecialchars($_POST['field-name']) . "',
            '" . htmlspecialchars($_POST['description']) . "'
        )";
    mysqli_query($connect, $sql);

    $field_id = $connect->insert_id;

    $hashtags = $_POST['hashtags'];

    $hash_ids = [];
    foreach ($hashtags as $hashtag) {
        $sql = "SELECT id FROM `hashtags` WHERE name = '$hashtag'";
        $res = mysqli_query($connect, $sql);
        if ($row = $res->fetch_assoc()) {
            $hash_ids[] = $row['id'];
        }
    }
    foreach ($hash_ids as $hash_id) {
        $sql = "INSERT INTO `hash_connect` (`hash_id`, `field_id`) VALUES (
                '" . htmlspecialchars($hash_id) . "',
                '" . htmlspecialchars($field_id) . "'
            )";
        mysqli_query($connect, $sql);
    }
}

if (isset($_POST['update-field'])) {
    $field_id = $_POST['field_id'];

    $sql = "DELETE FROM `hash_connect` WHERE `field_id` = '$field_id'";
    mysqli_query($connect, $sql);

    $hashtags = $_POST['hashtags'];

    $hash_ids = [];
    foreach ($hashtags as $hashtag) {
        $sql = "SELECT id FROM `hashtags` WHERE name = '$hashtag'";
        $res = mysqli_query($connect, $sql);
        if ($row = $res->fetch_assoc()) {
            $hash_ids[] = $row['id'];
        }
    }
    foreach ($hash_ids as $hash_id) {
        $sql = "INSERT INTO `hash_connect` (`hash_id`, `field_id`) VALUES (
                '" . htmlspecialchars($hash_id) . "',
                '" . htmlspecialchars($field_id) . "'
            )";
        mysqli_query($connect, $sql);
    }
}



// render page
require ('header.php');
echo "<main>";
if (
    isset($_GET['p']) &&
    ($_GET['p'] == 'tags' || $_GET['p'] == 'posts' ||
        $_GET['p'] == 'channels' || $_GET['p'] == 'fields')
) {
    include ($_GET['p'] . '.php');
}
echo "</main>";
echo "<script src='https://code.jquery.com/jquery-3.3.1.slim.min.js' integrity='sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo' crossorigin='anonymous'></script>";
echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js' integrity='sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1' crossorigin='anonymous'></script>";
echo "<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js' integrity='sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM' crossorigin='anonymous'></script>";
echo "</body>";
echo "</html>";
<?php 

function redirect($url, $response_code = 301) {
    header("location: " . $url, true, $response_code);
    exit;
}

function getMediaCounts() {
    global $db;

    $sql = "SELECT type.name AS media_type, COUNT(media.media_id) AS count
            FROM media
            LEFT JOIN type ON media.type_id = type.type_id
            GROUP BY type.name";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


function getUserCount() {
    global $db;

    $sql = "SELECT COUNT(*) AS user_count FROM users";
    $stmt = $db->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['user_count'];
}



function displayErrors($errors = []) {
    if(isset($errors) && count($errors) > 0) {
        foreach ( $errors as $error ) {
            echo "<div class='alert alert-danger'>$error</div>";
        } 
    }
}

function checkLogin() {
    //check if not on login page
    if($_SERVER['REQUEST_URI'] == '/login.php' || $_SERVER['REQUEST_URI'] == '/register.php') {
        return;
    }
    if(!isset($_SESSION['login'])) {
        redirect('/login.php');
    }
}

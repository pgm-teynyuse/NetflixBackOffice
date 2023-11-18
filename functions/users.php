<?php

function getUsers($search = '') {
    global $db;

    $sql = "SELECT * FROM users";
    if($search) {
        $sql .= " WHERE firstName LIKE :search";
    }
    $stmt = $db->prepare($sql);
    if($search) {
        $stmt->bindValue(':search', "%$search%");
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getUsersDetail() {
    global $db;
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE users.user_id = $user_id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}


function updateUser($id, $firstName, $lastName, $userName, $passWord) {
    global $db;

    $stmt = $db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, userName = :userName, passWord = :passWord WHERE user_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':firstName', $firstName); 
    $stmt->bindValue(':lastName', $lastName);   
    $stmt->bindValue(':userName', $userName);   
    $stmt->bindValue(':passWord', $passWord);  
    $stmt->execute();

    $user_id = $db->lastInsertId();
}

function deleteUser($user_id) {
    global $db;

    $checkSql = "SELECT user_id FROM users WHERE user_id = :user_id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        $deleteSql = "DELETE FROM users WHERE user_id = :user_id";
        $deleteStmt = $db->prepare($deleteSql);
        $deleteStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        return true;
    } else {
        return false;
    }
}

function insertUser($firstName, $lastName, $userName, $passWord) {
    global $db;

    $stmt = $db->prepare("INSERT INTO users (firstName, lastName, userName, passWord) VALUES (:firstName, :lastName, :userName, :passWord)");
    $stmt->bindValue(':firstName', $firstName); 
    $stmt->bindValue(':lastName', $lastName);   
    $stmt->bindValue(':userName', $userName);   
    $stmt->bindValue(':passWord', $passWord); 

    $stmt->execute();
    $user_id = $db->lastInsertId();
}


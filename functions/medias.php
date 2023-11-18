<?php

function getMedias($search = '') {
    global $db;

    $sql = "SELECT media.media_id, media.name AS media_name, media.cover_url, type.name AS type_name
            FROM media
            LEFT JOIN type ON media.type_id = type.type_id";

    if ($search) {
        $sql .= " WHERE media.name LIKE :search";
    }

    $stmt = $db->prepare($sql);

    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}



function getMediaDetail() {
    global $db;
    $media_id = $_GET['id'];
    
    $sql = "SELECT media.*, type.name AS type_name 
            FROM media 
            JOIN type ON media.type_id = type.type_id
            WHERE media.media_id = $media_id";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getActorsForMedia($media_id) {
    global $db;
    $sql = "SELECT actor.actor_id, actor.firstName, actor.lastName
            FROM actor
            JOIN actor_media ON actor.actor_id = actor_media.actor_id
            WHERE actor_media.media_id = :media_id";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":media_id", $media_id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function updateMedia($id, $name, $type_id, $cover_url) {
    global $db;

    $stmt = $db->prepare("UPDATE media SET name = :name, type_id = :type_id, cover_url = :cover_url WHERE media_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':type_id', $type_id);
    $stmt->bindValue(':cover_url', $cover_url);
    $stmt->execute();
}

function insertMedia($name, $type_id, $cover_url) {
    global $db;

    $stmt = $db->prepare("INSERT INTO media (name, type_id, cover_url) VALUES (:name, :type_id, :cover_url)");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':type_id', $type_id);
    $stmt->bindValue(':cover_url', $cover_url);
    $stmt->execute();

    $media_id = $db->lastInsertId();

    return $media_id;
}

function deleteMedia($media_id) {
    global $db;

    $checkSql = "SELECT media_id FROM media WHERE media_id = :media_id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(":media_id", $media_id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        $deleteSql = "DELETE FROM media WHERE media_id = :media_id";
        $deleteStmt = $db->prepare($deleteSql);
        $deleteStmt->bindParam(":media_id", $media_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        return true;
    } else {
        return false;
    }
}

function getMediaTypes() {
    global $db;

    $sql = "SELECT * FROM type";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getAllActors() {
    global $db;
    
    $sql = "SELECT * FROM actor";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function linkActorToMedia($actor_id, $media_id) {
    global $db;

    $checkSql = "SELECT * FROM actor_media WHERE actor_id = :actor_id AND media_id = :media_id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindValue(':actor_id', $actor_id);
    $checkStmt->bindValue(':media_id', $media_id);
    $checkStmt->execute();

    if ($checkStmt->rowCount() === 0) {
        $insertSql = "INSERT INTO actor_media (actor_id, media_id) VALUES (:actor_id, :media_id)";
        $insertStmt = $db->prepare($insertSql);
        $insertStmt->bindValue(':actor_id', $actor_id);
        $insertStmt->bindValue(':media_id', $media_id);
        $insertStmt->execute();
    }
}

function unlinkActorFromMedia($actor_id, $media_id) {
    global $db;

    $stmt = $db->prepare("DELETE FROM actor_media WHERE actor_id = :actor_id AND media_id = :media_id");
    $stmt->bindValue(':actor_id', $actor_id);
    $stmt->bindValue(':media_id', $media_id);
    $stmt->execute();
}





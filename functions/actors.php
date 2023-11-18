<?php

function getActors($search = '') {
    global $db;

    $sql = "SELECT actor.actor_id, actor.firstName, actor.lastName, IFNULL(avatars.avatarUrl, 'standaard_avatar.jpg') AS avatarUrl
            FROM actor 
            LEFT JOIN avatars ON actor.actor_id = avatars.actor_id";

    if ($search) {
        $sql .= " WHERE actor.firstName LIKE :search OR actor.lastName LIKE :search";
    }

    $stmt = $db->prepare($sql);

    if ($search) {
        $stmt->bindValue(':search', "%$search%");
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getActorsDetail() {
    global $db;
    $actor_id = $_GET['id'];
    $sql = "SELECT * FROM actor WHERE actor.actor_id = $actor_id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function updateActor($id, $firstName, $lastName, $avatarUrl) {
    global $db;

    // First, check if the actor has an existing image
    $checkSql = "SELECT actor_id FROM avatars WHERE actor_id = :id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindValue(':id', $id);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        // If the actor has an existing image, update only the actor's details
        $stmt = $db->prepare("UPDATE actor SET firstName = :firstName, lastName = :lastName WHERE actor_id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->execute();
    } else {
        // If the actor doesn't have an existing image, insert a new row into the avatars table
        $stmt = $db->prepare("INSERT INTO avatars (avatarUrl, alt, actor_id) VALUES (:avatarUrl, :alt, :actor_id)");
        $stmt->bindValue(':avatarUrl', $avatarUrl);
        $stmt->bindValue(':alt', $firstName);
        $stmt->bindValue(':actor_id', $id);
        $stmt->execute();

        // Update the actor's details as well
        $stmt = $db->prepare("UPDATE actor SET firstName = :firstName, lastName = :lastName WHERE actor_id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstName', $firstName);
        $stmt->bindValue(':lastName', $lastName);
        $stmt->execute();
    }
}



function updateActorAvatar($actor_id, $avatarUrl) {
    global $db;

    $stmt = $db->prepare("UPDATE avatars SET avatarUrl = :avatarUrl WHERE actor_id = :actor_id");
    $stmt->bindValue(':avatarUrl', $avatarUrl);
    $stmt->bindValue(':actor_id', $actor_id);
    $stmt->execute();
}


function deleteActor($actor_id) {
    global $db;

    $checkSql = "SELECT actor_id FROM actor WHERE actor_id = :actor_id";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bindParam(":actor_id", $actor_id, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        $deleteSql = "DELETE FROM actor WHERE actor_id = :actor_id";
        $deleteStmt = $db->prepare($deleteSql);
        $deleteStmt->bindParam(":actor_id", $actor_id, PDO::PARAM_INT);
        $deleteStmt->execute();

        return true;
    } else {
        return false;
    }
}


function getMediaForActor($actor_id) {
    global $db;

    $sql = "SELECT media.*
            FROM media
            JOIN actor_media ON media.media_id = actor_media.media_id
            WHERE actor_media.actor_id = :actor_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":actor_id", $actor_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function insertActor($firstName, $lastName, $avatarUrl) {
    global $db;

    $stmt = $db->prepare("INSERT INTO actor (firstName, lastName) VALUES (:firstName, :lastName)");
    $stmt->bindValue(':firstName', $firstName);
    $stmt->bindValue(':lastName', $lastName);
    $stmt->execute();

    $actor_id = $db->lastInsertId();

    $stmt = $db->prepare("INSERT INTO avatars (avatarUrl, alt, actor_id) VALUES (:avatarUrl, :alt, :actor_id)");
    $stmt->bindValue(':avatarUrl', $avatarUrl);
    $stmt->bindValue(':alt', $firstName);
    $stmt->bindValue(':actor_id', $actor_id);
    $stmt->execute();
}




<?php

function get_all_users($conn) {
    $sql = "SELECT * FROM users WHERE role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(["employee"]);

    if ($stmt->rowCount() > 0) {
        $users = $stmt->fetchAll();
    } else $users = 0;

    return $users;
}

function insert_user($conn, $data) {
    $sql = "INSERT INTO users(full_name, username, password, role) VALUES(?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
    if ($stmt->rowCount() > 0) {
        $users = $stmt->fetchAll();
    } else $users = 0;

    return 1;
}

function get_user_by_id($conn, $id) {
    $sql = "SELECT * FROM users WHERE id =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
    } else $user = 0;

    return $user;
}

function update_user($conn, $data) {
    $sql = "UPDATE users SET full_name=?, username=?, password=?, role=? WHERE id=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}

function delete_user($conn, $data) {
    $sql = "DELETE FROM users WHERE id=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute($data);
}
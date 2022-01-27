<?php
include __DIR__ . '/../../includes/autoload.php';
include __DIR__ . '/../../includes/DatabaseConnection.php';
$table = new \Common\DatabaseTable($pdo, 'user_reservations', 'id');
if ($_POST['task'] === 'update'){
    $data = ['set' => ['name' => $_POST['name'], 'email' => $_POST['email'], 'phone_number' =>
    $_POST['phone'], 'apartment_address' => $_POST['apartment'], 'date' => $_POST['date'],
        'time' => $_POST['time']], 'conditions' => ['id' => $_POST['id']]];
    $table->updateValuesInDb($data);
}
if ($_POST['task'] === 'delete'){
    $table->deleteFromDb($_POST['id']);
}
$link = 'http://' . $_SERVER['HTTP_HOST'];
header('location: ' . $link);
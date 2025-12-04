<?php

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    $data = $_POST;
}

$name = trim($data['name'] ?? '');
$contact = trim($data['contact'] ?? '');

$errors = [];

if (empty($name)) {
    $errors['name'] = 'Имя обязательно для заполнения';
}

if (empty($contact)) {
    $errors['contact'] = 'Контактные данные обязательны для заполнения';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['errors' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

echo json_encode(['message' => 'Заявка успешно отправлена'], JSON_UNESCAPED_UNICODE);


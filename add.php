<?php

include(__DIR__ . '/db.php');

function handle_add() {
    global $pdo;

    $message = '';
    $messageClass = '';

    $row = [
        'surname'  => '',
        'name'     => '',
        'lastname' => '',
        'gender'   => '',
        'date'     => '',
        'phone'    => '',
        'location' => '',
        'email'    => '',
        'comment'  => ''
    ];

    $button = 'Добавить';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $surname  = $_POST['surname'] ?? '';
        $name     = $_POST['name'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $gender   = $_POST['gender'] ?? '';
        $birthdate = $_POST['date'] ?? '';
        $phone    = $_POST['phone'] ?? '';
        $location = $_POST['location'] ?? '';
        $email    = $_POST['email'] ?? '';
        $comment  = $_POST['comment'] ?? '';

        if ($surname === '' || $name === '') {
            $message = 'Ошибка: фамилия и имя обязательны';
            $messageClass = 'text-danger';
        } else {

            // Добавляем в БД
            $stmt = $pdo->prepare("
                INSERT INTO contacts (
                    surname, name, lastname, gender, birthdate, phone, location, email, comment
                ) VALUES (
                    :surname, :name, :lastname, :gender, :birthdate, :phone, :location, :email, :comment
                )
            ");

            $ok = $stmt->execute([
                ':surname'  => $surname,
                ':name'     => $name,
                ':lastname' => $lastname,
                ':gender'   => $gender,
                ':birthdate'=> $birthdate,
                ':phone'    => $phone,
                ':location' => $location,
                ':email'    => $email,
                ':comment'  => $comment
            ]);

            if ($ok) {
                $message = 'Запись добавлена';
                $messageClass = 'text-success';

                foreach ($row as $key => $value) {
                    $row[$key] = '';
                }
            } else {
                $message = 'Ошибка: запись не была добавлена';
                $messageClass = 'text-danger';
            }
        }
    }

    ob_start();

    echo '<div class="form-wrap"><h3>Добавить запись</h3>';

    if ($message !== '') {
        echo '<div class="' . $messageClass . '">'
            . $message .
            '</div>';
    }

    include(__DIR__ . '/form.php');

    echo '</div>';

    return ob_get_clean();
}

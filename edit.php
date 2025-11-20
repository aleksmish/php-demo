<?php

include(__DIR__ . '/db.php');

function handle_edit() {
    global $pdo;
    $message = '';
    $messageClass = '';

    $rows = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

    $selectedId = null;
    if (isset($_GET['id'])) $selectedId = (int)$_GET['id'];
    if (isset($_POST['id'])) $selectedId = (int)$_POST['id'];

    if (!$selectedId && count($rows) > 0) {
        $selectedId = (int)$rows[0]['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button']) && $selectedId) {
        $surname = $_POST['surname'] ?? '';
        $name = $_POST['name'] ?? '';
        $lastname = $_POST['lastname'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $birthdate = $_POST['date'] ?? null;
        $phone = $_POST['phone'] ?? '';
        $location = $_POST['location'] ?? '';
        $email = $_POST['email'] ?? '';
        $comment = $_POST['comment'] ?? '';

        if ($surname === '' || $name === '') {
            $message = 'Ошибка: фамилия и имя обязательны';
            $messageClass = 'text-danger';
        } else {
            $stmt = $pdo->prepare("UPDATE contacts SET surname=:surname, name=:name, lastname=:lastname, gender=:gender, birthdate=:birthdate, phone=:phone, location=:location, email=:email, comment=:comment WHERE id=:id");
            $ok = $stmt->execute([
                ':surname'=>$surname, ':name'=>$name, ':lastname'=>$lastname, ':gender'=>$gender,
                ':birthdate'=>$birthdate, ':phone'=>$phone, ':location'=>$location, ':email'=>$email, ':comment'=>$comment,
                ':id'=>$selectedId
            ]);
            if ($ok) {
                $message = 'Запись обновлена';
                $messageClass = 'text-success';
            } else {
                $message = 'Ошибка: запись не обновлена';
                $messageClass = 'text-danger';
            }

            $rows = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    $row = ['surname'=>'','name'=>'','lastname'=>'','gender'=>'','date'=>'','phone'=>'','location'=>'','email'=>'','comment'=>''];
    if ($selectedId) {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id=:id");
        $stmt->execute([':id'=>$selectedId]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r) {
            $row = [
                'surname'=>$r['surname'],
                'name'=>$r['name'],
                'lastname'=>$r['lastname'],
                'gender'=>$r['gender'],
                'date'=>$r['birthdate'],
                'phone'=>$r['phone'],
                'location'=>$r['location'],
                'email'=>$r['email'],
                'comment'=>$r['comment']
            ];
        }
    }

    ob_start();
    echo '<div class="div-edit"><h3>Редактировать запись</h3><ul>';
    foreach ($rows as $it) {
        $isCurrent = ($it['id'] == $selectedId);
        $style = $isCurrent ? 'class="currentRow"' : '';
        echo '<li ' . $style . '><a href="index.php?action=edit&id=' . $it['id'] . '">' . $it['surname'] . ' ' . $it['name'].'</a></li>';
    }
    echo '</ul></div>';

    if ($message !== '') {
        echo '<div class="' . $messageClass . '">' . $message . '</div>';
    }

    $button = 'Сохранить';
    include(__DIR__ . '/form.php');

    return ob_get_clean();
}

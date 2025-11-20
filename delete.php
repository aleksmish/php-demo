<?php

include(__DIR__ . '/db.php');

function handle_delete() {
    global $pdo;
    $message = '';

    $rows = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];

        $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $s = $stmt->fetchColumn();
        if ($s !== false) {
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id=:id");
            $stmt->execute([':id'=>$id]);
            $message = 'Запись с фамилией '. $s . ' удалена';
        } else {
            $message = 'Запись не найдена';
        }

        $rows = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    ob_start();
    echo '<div class="div-edit"><h3>Удалить запись</h3>';
    if ($message !== '') {
        echo '<div class="success" style="padding:8px; margin:10px 0;">'.htmlspecialchars($message).'</div>';
    }
    echo '<ul>';
    foreach ($rows as $r) {
        $initials = mb_substr($r['name'],0,1).'.'.(isset($r['lastname']) && $r['lastname']!=='' ? mb_substr($r['lastname'],0,1).'.' : '');
        echo '<li><a href="index.php?action=delete&id='.$r['id'].'" onclick="return confirm(\'Удалить запись '.$r['surname'].'?\')">'.htmlspecialchars($r['surname'].' '.$initials).'</a></li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
}

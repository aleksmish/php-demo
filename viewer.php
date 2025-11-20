<?php

include(__DIR__ . '/db.php');

function render_viewer($sort = 'added', $page = 1) {
    global $pdo;
    $perPage = 10;
    $offset = ($page - 1) * $perPage;

    switch ($sort) {
        case 'surname':
            $order = "surname ASC";
            break;
        case 'birthdate':
            $order = "birthdate ASC";
            break;
        case 'added':
        default:
            $order = "id ASC";
            break;
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $total = (int)$stmt->fetchColumn();
    $pages = max(1, (int)ceil($total / $perPage));

    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $order LIMIT :lim OFFSET :off");
    $stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<section class="viewer">';
    $html .= '<h2>Список контактов</h2>';
    $html .= '<table class="table table-light table-striped" border="0" cellpadding="8" cellspacing="0"><thead><tr>'
        . '<th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th>'
        . '<th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th>'
        . '</tr></thead><tbody>';
    if (!$rows) {
        $html .= '<tr><td colspan="9">Записей не найдено.</td></tr>';
    } else {
        foreach ($rows as $r) {
            $html .= '<tr>'
                . '<td>'.$r['surname'].'</td>'
                . '<td>'.$r['name'].'</td>'
                . '<td>'.$r['lastname'].'</td>'
                . '<td>'.$r['gender'].'</td>'
                . '<td>'.$r['birthdate'].'</td>'
                . '<td>'.$r['phone'].'</td>'
                . '<td>'.$r['location'].'</td>'
                . '<td>'.$r['email'].'</td>'
                . '<td>'.$r['comment'].'</td>'
                . '</tr>';
        }
    }
    $html .= '</tbody></table>';

    if ($pages > 1) {
        $html .= '<ul class="pagination">';
        for ($i = 1; $i <= $pages; $i++) {
            $active = ($i === $page) ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '"><a class="page-link" href="index.php?action=view&sort=' . $sort . '&page=' . $i . '">' . $i . '</a></li>';
        }
        $html .= '</ul>';
    }

    $html .= '</section>';
    return $html;
}

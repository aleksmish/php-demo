<?php

function render_menu($activeMain = 'view', $activeSub = 'added') {
    $items = [
        'view' => 'Просмотр',
        'add' => 'Добавление записи',
        'edit' => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '<nav style="width:100%;"><ul class="mainmenu pagination">';
    foreach ($items as $key => $label) {
        $cls = ($key === $activeMain) ? 'active' : '';
        $html .= '<li class="page-item "><a class="page-link '. $cls .'" href="index.php?action='. $key . '">'. $label . '</a></li>';
    }
    $html .= '</ul>';

    if ($activeMain === 'view') {
        $sub = [
            'added' => 'По добавлению',
            'surname' => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        $html .= '<ul class="mainmenu pagination">';
        foreach ($sub as $skey => $slabel) {
            $scls = ($skey === $activeSub) ? 'active' : '';

            $html .= '<li class="page-item"><a class="page-link '. $scls .'" href="index.php?action=view&sort=' . $skey . '">' . $slabel . '</a></li>';
        }
        $html .= '</ul>';
    }

    $html .= '</nav>';
    return $html;
}

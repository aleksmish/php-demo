<?php

ini_set('display_errors', 1);

include(__DIR__ . '/db.php');
include(__DIR__ . '/menu.php');
include(__DIR__ . '/viewer.php');
include(__DIR__ . '/add.php');
include(__DIR__ . '/edit.php');
include(__DIR__ . '/delete.php');

$action = $_GET['action'] ?? $_POST['action'] ?? 'view';

$sort = $_GET['sort'] ?? 'added'; 
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Записная книжка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="container-md">
    <header>
        <?php
            echo render_menu($action, $action === 'view' ? $sort : null);
        ?>
    </header>

    <main>
        <?php
        switch ($action) {
            case 'add':
                echo handle_add();
                break;
            case 'edit':
                echo handle_edit();
                break;
            case 'delete':
                echo handle_delete();
                break;
            case 'view':
            default:
                echo render_viewer($sort, $page);
                break;
        }
        ?>
    </main>

    <footer>
        <div style="text-align:center">Записная книжка — учебный проект</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

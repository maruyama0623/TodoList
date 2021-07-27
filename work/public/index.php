<?php

require_once(__DIR__ . '/../app/config.php');

use MyApp\Database;
use MyApp\Todo;
use MyApp\Utils;


/*データベース（PDO）設定*/ 
$pdo = Database::getInstance();

//Todoクラスのインスタンス
$todo = new Todo($pdo);
//CRUD処理をする
$todo->processPost();
//CRUD処理の結果を配列に並べる→後にforeachで結果を表示する
$todos = $todo->getAll();

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>My Todos</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>
  <main>
    <header>
    <h1>Todos</h1>
    <form action="?action=purge" method="post" class="">
      <span class="purge">purge</span>
      <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
    </form>
    </header>

    <form action="?action=add" method="post">
      <input type="text" name="title" placeholder="type new todo.">
      <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
    </form>

    <ul>
      <?php foreach ($todos as $todo) : ?>
        <li>
          <input type="checkbox" 
          data-id="<?= Utils::h($todo->id); ?>" 
          data-token="<?= Utils::h($_SESSION['token']); ?>" 
          <?= $todo->is_done ? 'checked' : ''; ?>>

          <span><?= Utils::h($todo->title); ?></span>

          <form action="?action=delete" method="post" class="delete-form">
            <span class="delete">×</span>
            <input type="hidden" name="id" value="<?= Utils::h($todo->id); ?>">
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
          </form>


        </li>
      <?php endforeach; ?>
    </ul>
  </main>

  <script src="./js/main.js"></script>
</body>

</html>
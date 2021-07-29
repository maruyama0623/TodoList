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
  <main data-token="<?= Utils::h($_SESSION['token']); ?>">
    <header>
      <h1>Todos</h1>
      <span class="purge">purge</span>
    </header>

    <form>
      <input type="text" name="title" placeholder="type new todo.">
    </form>

    <ul>
      <?php foreach ($todos as $todo) : ?>
        <li data-id="<?= Utils::h($todo->id); ?>"><!-- カスタムデータ属性 data-id=""を使用する -->
          <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
          <span><?= Utils::h($todo->title); ?></span>
          <span class="delete">×</span>
        </li>
      <?php endforeach; ?>
    </ul>
  </main>

  <script src="./js/main.js"></script>
</body>

</html>
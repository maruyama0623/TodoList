<?php
namespace MyApp;
class Todo
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        /*トークンの生成*/
        Token::create();
    }

    public function processPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //  トークンチェック
            Token::validate();
            $action = filter_input(INPUT_GET, 'action');

            switch ($action) {
                case 'add':
                    $id = $this->add();
                    header('Content-Type: application/json');
                    echo json_encode(['id' => $id]);
                    break;
                case 'toggle':
                    $this->toggle();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'purge':
                    $this->purge();
                    break;
                default:
                    exit;
            }

            // header('Location: ' . SITE_URL);サイトを読み込み
            exit;
        }
    }

    private function add()
    {
        $title = trim(filter_input(INPUT_POST, 'title'));
        if ($title === '') {
            return;
        }

        $stmt = $this->pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }


    private function toggle()
    {
        $id = filter_input(INPUT_POST, 'id');
        if (empty($id)) {
            return;
        }
        $stmt = $this->pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    private function delete()
    {
        $id = filter_input(INPUT_POST, 'id');
        if (empty($id)) {
            return;
        }
        $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id = :id");
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

    //pdoに格納されたデータの中でチェックが入っている項目を一括削除
    private function purge()
    {
        $this->pdo->query("DELETE FROM todos WHERE is_done = 1");
    }

    //pdoに格納されているデータを配列で返す
    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY id DESC");
        $todos = $stmt->fetchAll();
        return $todos;
    }
}

<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $status = 0;
        $stmt = $pdo->prepare("INSERT INTO tb_task (name, description, status) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $status]);
    } elseif ($action == 'load') {
        $stmt = $pdo->query("SELECT * FROM tb_task ORDER BY id DESC");
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tasks as $task) {
            $taskClass = $task['status'] ? 'task-completed' : '';
            echo "<div class='list-group-item {$taskClass}'>
                    <div>
                        <strong>{$task['name']}</strong><br>
                        {$task['description']}
                    </div>
                    <div>
                        <button class='btn btn-success complete-task' data-id='{$task['id']}'>✔</button>
                        <button class='btn btn-warning edit-task' data-id='{$task['id']}'>✎</button>
                        <button class='btn btn-danger delete-task' data-id='{$task['id']}'>✖</button>
                    </div>
                </div>";
        }
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM tb_task WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action == 'complete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("UPDATE tb_task SET status = 1 WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $stmt = $pdo->prepare("UPDATE tb_task SET name = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $description, $id]);
    }
}
?>

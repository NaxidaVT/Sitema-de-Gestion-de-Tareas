$(document).ready(function () {
    loadTasks();

    $('#taskForm').submit(function (e) {
        e.preventDefault();
        let taskName = $('#taskName').val();
        let taskDescription = $('#taskDescription').val();

        $.ajax({
            url: 'tasks.php',
            type: 'POST',
            data: { action: 'add', name: taskName, description: taskDescription },
            success: function () {
                $('#taskForm')[0].reset();
                loadTasks();
            }
        });
    });

    function loadTasks() {
        $.ajax({
            url: 'tasks.php',
            type: 'POST',
            data: { action: 'load' },
            success: function (response) {
                $('#taskList').html(response);
                addEventListeners();
            }
        });
    }

    function addEventListeners() {
        $('.delete-task').click(function () {
            let taskId = $(this).data('id');
            $.ajax({
                url: 'tasks.php',
                type: 'POST',
                data: { action: 'delete', id: taskId },
                success: function () {
                    loadTasks();
                }
            });
        });

        $('.complete-task').click(function () {
            let taskId = $(this).data('id');
            $.ajax({
                url: 'tasks.php',
                type: 'POST',
                data: { action: 'complete', id: taskId },
                success: function () {
                    loadTasks();
                }
            });
        });

        $('.edit-task').click(function () {
            let taskId = $(this).data('id');
            let taskName = prompt("Editar nombre de la tarea:");
            let taskDescription = prompt("Editar descripción de la tarea:");
            if (taskName && taskDescription) {
                $.ajax({
                    url: 'tasks.php',
                    type: 'POST',
                    data: { action: 'edit', id: taskId, name: taskName, description: taskDescription },
                    success: function () {
                        loadTasks();
                    }
                });
            }
        });
    }
});

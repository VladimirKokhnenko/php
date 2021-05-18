<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer</title>
    <link rel="stylesheet" href="resources/styles/styles-for-create-or-edit.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" />
</head>
<body>

    <?php
        echo "<form action=\"index.php\">"
        . "<div>"
        . "<button>Year</button>"
        . "</div>"
        . "</form>";
    ?>

    <?php
        require_once "resources/php/task.php";
        require_once "resources/php/work-with-task.php";

        echo "<form>";
        echo "<div id=\"container-create\">";

        if(!isset($_POST['create']) && !isset($_POST['edit']) ) return;

        if(isset($_POST['create'])) {
            $data = $_POST['create'];
            echo WorkWithTask::createTask($data);
        } else if(isset($_POST['edit'])) {
            $data = $_POST['edit'];
            echo WorkWithTask::editTask($data);
        }
        echo "<div>";
        echo "</form>";
    ?>

</body>
</html>
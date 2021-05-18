<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer</title>
    <link rel="stylesheet" href="resources/styles/styles-for-week.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" />
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
        require_once "resources/php/week.php";

        echo "<form>";
            echo "<div id=\"grid-container-week\">";
            
            if(!isset($_POST['week']) && !isset($_POST['day']) && !isset($_POST['del']) && !isset($_POST['okCreate']) && !isset($_POST['okEdit'])) return;
            
            if(isset($_POST['week'])) {
                $data = $_POST['week'];
                echo Week::getWeek($data, 'w');
            } else if(isset($_POST['day'])) {
                $data = $_POST['day'];
                echo Week::getWeek($data, 'd');
            } else if(isset($_POST['del'])) {
                $data = $_POST['del'];
                list($w,$d,$m,$y,$flagDayOrWeek,$t) = explode('/', $data);
                Task::delTask($w, $d, $m, $y, $flagDayOrWeek, $t);
                echo Week::getWeek($data, $flagDayOrWeek);
            } else if(isset( $_POST['okCreate'])) {
                $data = $_POST['okCreate'];
                $inputTime = $_POST['inputTime'];
                $inputName = $_POST['inputName'];
                $inputDescription = $_POST['inputDescription'];
                list($w, $d, $m, $y, $flagDayOrWeek) = explode('/',$data);
                Task::createTask($data, $inputTime, $inputName, $inputDescription);

                if($flagDayOrWeek == 'w') {
                    echo Week::getWeek($data, 'w');
                } else if($flagDayOrWeek == 'd') {
                    echo Week::getWeek($data, 'd');
                }
            }else if(isset( $_POST['okEdit'])) {
                $data = $_POST['okEdit'];
                $inputTime = $_POST['inputTime'];
                $inputName = $_POST['inputName'];
                $inputDescription = $_POST['inputDescription'];
                list($w, $d, $m, $y, $flagDayOrWeek, $id) = explode('/',$data);
                Task::editTask($inputTime, $inputName, $inputDescription, $id);

                if($flagDayOrWeek == 'w') {
                    echo Week::getWeek($data, 'w');
                } else if($flagDayOrWeek == 'd') {
                    echo Week::getWeek($data, 'd');
                }
            }
            
            echo "<div>";
        echo "</form>";
    ?>
    <script src="resources/js/jquery.min.js"></script>
    <script src="resources/js/validation-user-input.js"></script>
</body>
</html>
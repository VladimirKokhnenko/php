<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer</title>
    <!-- <link rel="stylesheet" href="resources/styles/styles.css" type="text/css"> -->
    <!-- <link rel="stylesheet" href="resources/styles/styles-for-year.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" />  -->
    <!-- Тогда для браузера, при каждом запросе страницы,
    будет новая ссылка (которая будет отличаться от значения в cache) на тот же файл, и он будет его заново скачивать и рендерить. -->
    <link rel="stylesheet" href="resources/styles/styles-for-month.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" /> 
</head>
<body>
    
    <?php
        echo "<form action=\"index.php\">"
        . "<div>"
        . "<button>Year</button>"
        . "</div>"
        . "</form>";
    ?>
            
    <form>
        <div id="grid-container-month">
            <?php
                require_once "resources/php/month.php";
                require_once "resources/php/year.php";
                
                if(!isset($_POST['month'])) return;
                $m = $_POST['month'];

            

                echo "<div id=\"grid-item-button\">";
                echo Month::createButtonPrevMonth($m);
                echo "</div>";
                
                echo "<div id=\"grid-item-month\">";
                echo Month::generateMonth($m);
                echo "</div>";

                echo "<div id=\"grid-item-button\">";
                echo Month::createButtonNextMonth($m);
                echo "</div>";
            ?>

        </div>
    
    </form>
    
</body>
</html>
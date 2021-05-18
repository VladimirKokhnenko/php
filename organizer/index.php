<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer</title>
    <!-- <link rel="stylesheet" href="resources/styles/styles.css" type="text/css"> -->
    <link rel="stylesheet" href="resources/styles/styles-for-year.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" />
    <!-- Тогда для браузера, при каждом запросе страницы,
    будет новая ссылка (которая будет отличаться от значения в cache) на тот же файл, и он будет его заново скачивать и рендерить. -->
    <!-- <link rel="stylesheet" href="resources/styles/styles-for-month.css?t=<?php echo(microtime(true).rand()); ?>" type="text/css" />  -->
</head>
<body>

    <form>
        <div id="grid-container-year">
            <?php
                require_once "resources/php/year.php";
                Year::generateYear();
            ?>
        </div>

    </form>

</body>
</html>
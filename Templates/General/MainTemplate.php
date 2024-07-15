<?php

$title = "Главная";

?>

<header>
    <h1>Добро пожаловать на cloud-storage.local</h1>
</header>
<main>
    <p>
        <?php
        if ($email) {
            echo $email;
            echo "<br>";
            echo "<a href='http://www.cloud-storage.local/logout'>Выйти</a>";
        } else {
            echo "<a href='http://www.cloud-storage.local/login'>Войти</a>";
        }
        ?>
    </p>
</main>
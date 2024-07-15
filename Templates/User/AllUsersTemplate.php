<header>
    <h1>Список пользователей cloud-storage.local</h1>
</header>
<main>
    <p>
        <ul>
        <?php
        $result = "";
        foreach ($data as $user) {
            $result .= "<li><b>" . 
            $user['id'] . " " . 
            $user['email'] . " " . 
            $user['age'] . " " . 
            $user['sex'] . "</b></li>";
        }

        echo $result;
        ?>
        </ul>
    </p>
</main>
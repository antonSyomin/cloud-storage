<header>
    <h1>Изменить данные пользователя <?= $email ?></h1>
</header>
<main>
    <p>
        <form action="http://www.cloud-storage.local/users/update" method="POST">
            <input type="text" name="email" placeholder="email">
            <input type="text" name="age" placeholder="age">
            <input type="submit" value="send">
        </form>
    </p>
</main>


<header>
    <h1>Изменить данные пользователя</h1>
</header>
<main>
    <p>
        <form action="http://www.cloud-storage.local/admin/users/update" method="POST">
            <input type="text" name="email" placeholder="email">
            <input type="text" name="age" placeholder="age">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="send">
        </form>
    </p>
</main>


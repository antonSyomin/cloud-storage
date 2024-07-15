<header>
    <h1>Смена пароля</h1>
</header>
<main>
    <p>
    <form action="http://www.dev-cloud-storage.local/reset_password/form" method="POST">
            <input type="password" name="old_pass" placeholder="Старый пароль">
            <input type="password" name="new_pass" placeholder="Новый пароль">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit">
        </form>
    </p>
</main>


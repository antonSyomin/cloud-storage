<header>
    <h1>Изменить имя файла</h1>
</header>
<main>
    <p>
        <form action="http://www.dev-cloud-storage.local/files/rename" method="POST">
            <input type="text" name="title" placeholder="Новое название">
            <input type="hidden" name="id" value="<?= $_GET['id']?>">
            <input type="submit" value="send">
        </form>
    </p>
</main>


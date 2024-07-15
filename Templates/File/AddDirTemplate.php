<header>
    <h1>Добавить папку</h1>
</header>
<main>
    <p>
        <form action="http://www.dev-cloud-storage.local/directories/add" enctype="multipart/form-data" method="POST">
            <input type="text" name="dirTitle"/>
            <input type="hidden" name="id" value="<?= $userId ?>">
            <input type="submit" value="загрузить">
        </form>
    </p>
</main>


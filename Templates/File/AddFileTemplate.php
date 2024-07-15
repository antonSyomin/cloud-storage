<header>
    <h1>Добавить файл</h1>
</header>
<main>
    <p>
        <form action="http://www.cloud-storage.local/files/add" enctype="multipart/form-data" method="POST">
            <input type="file" name="upload_file"/>
            <input type="hidden" name="id" value="<?= $userId ?>">
            <input type="submit" value="загрузить">
        </form>
    </p>
</main>


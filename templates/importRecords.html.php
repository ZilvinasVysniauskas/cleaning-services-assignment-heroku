<div class="container">
    <form action="" method="post" enctype="multipart/form-data">
        <p>Choose csv file to import</p>
        <input type="file" name="csv">
        <input type="submit">
    </form>
    <div>
        <?php if (!empty($messages)):?>
            <?php foreach ($messages as $message):?>
                <p><?=$message?></p>
            <?php endforeach;?>
        <?php endif; ?>
    </div>
</div>


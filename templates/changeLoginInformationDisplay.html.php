<div class="container">
    <h3>Change password</h3>
    <form action="" method="post">
        <div>
            <div>
                <label for="">Enter old password</label>
            </div>
            <input type="password" name="adminOldPassword">
        </div>
        <div>
            <div>
                <label for="">Enter new password</label>
            </div>

            <input type="password" name="adminNewPassword">
        </div>
        <div>
            <div>
                <label for="">Repeat password</label>
            </div>
            <input type="password" name="adminNewPasswordRepeat">
        </div>

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
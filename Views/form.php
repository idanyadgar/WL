<form action="?do=login" method="post">
    username: <input type="text" name="username" value="<?= $model->username ?>" /><?=$model->getError('username') ?>
    <br />
    password: <input type="password" name="password"
                     value="<?= $model->password ?>" /><?=$model->getError('password') ?><br />
    <input type="submit" value="login" />
</form>
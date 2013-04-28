<?php
/**
 * @var Models\RegisterForm $model
 * @var System\HtmlHelper   $html
 * @var stdClass            $viewBag
 */
?>
<style>
    label {
        display: inline-block;
        width: 150px;
        cursor: pointer;
    }
</style>
<h1>Register form</h1>

<form action="" method="post">
    <?= $html->labelFor('username') ?> 
    <?= $html->textBoxFor('username') ?> 
    <?= $html->validationMessage('username') ?><br />

    <?= $html->labelFor('password') ?> 
    <?= $html->textBoxFor('password') ?> 
    <?= $html->validationMessage('password') ?><br />

    <?= $html->labelFor('rePassword') ?> 
    <?= $html->textBoxFor('rePassword') ?> 
    <?= $html->validationMessage('rePassword') ?><br />

    <?= $html->labelFor('birthday') ?> 
    <?= $html->textBoxFor('birthday') ?> 
    <?= $html->validationMessage('birthday') ?><br />

    <?= $html->labelFor('gender') ?> 
    <?= $html->radioGroupFor('gender') ?> 
    <?= $html->validationMessage('gender') ?><br />

    <?= $html->labelFor('languages') ?> 
    <?= $html->checkBoxGroupFor('languages') ?> 
    <?= $html->validationMessage('languages') ?><br />

    <?= $html->checkBoxGroupFor('agree') ?> 
    <?= $html->validationMessage('agree') ?><br />
    <br />

    <input type="submit" value="Register" />
</form>
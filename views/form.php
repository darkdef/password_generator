<?php
/* @var int $length */
/* @var array $types */
/* @var string $error */
/* @var string $password */
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>Password generator</title>
    <style>
        html, body {
            font: 14px Tahoma, Verdana, Arial;
        }
        h1 {
            text-align: center;
        }
        .password-block {
            margin: 0 auto;
            width: 40em;
        }
        form {
            display: block;
            margin: 2em;
            padding: 1em;
            border: 1px solid #ccc;
        }
        label {
            display: block;
            margin: 0.5em 0;
        }
        p {
            text-align: center;
        }
        .error {
            font-weight: bold;
            color: red;
        }
        .password {
            font-weight: normal;
            color: green;
        }
        button {
            padding: 0.5em 1em;
        }
    </style>
</head>
<body>

<div class="password-block">
    <h1>Password generator</h1>

    <form method="post">
        <label>
            Type number of symbols
            <input type="number" name="length" min="1" max="128" value="<?=isset($length) && intval($length) ? $length : 8?>" />
        </label>
        <label>
            <input type="checkbox" name="types[number]" value="1" <?=!empty($types['number'])?'checked':''?> /> Numbers without `0` and `1`
        </label>
        <label>
            <input type="checkbox" name="types[upper]" value="1" <?=!empty($types['upper'])?'checked':''?> /> Big letters without `O`
        </label>
        <label>
            <input type="checkbox" name="types[lower]" value="1" <?=!empty($types['lower'])?'checked':''?> /> Small letters without `o` and `l`
        </label>
        <button type="submit">Generate</button>
    </form>

    <?php if (!empty($error)):?>
        <p class="error"><?=$error?></p>
    <?php endif;?>
    <?php if (!empty($password)):?>
        <p class="password">Generated password: <strong><?=$password?></strong></p>
    <?php endif;?>
</div>

</body>
</html>
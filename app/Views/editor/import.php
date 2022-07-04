<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Form</title>
</head>
<body>
<?php
if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}
if(!isset($errors)){
    $errors = array();
}
?>
<?php foreach ($errors as $error): ?>
    <li><?= esc($error) ?></li>
<?php endforeach ?>

<?= form_open_multipart(route_to('editor.import')) ?>

<input type="file" name="file" size="200" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>
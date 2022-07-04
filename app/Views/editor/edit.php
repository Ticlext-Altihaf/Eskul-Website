<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $name == "" ? "Add" : "Editor" ?></title>
</head>
<body>
<h1><?php echo $name == "" ? "Add" : "Editor" ?></h1>
<?php

if (isset($error)) {
    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}
if (!isset($errors)) {
    $errors = array();
}
?>
<?php foreach ($errors as $key => $value): ?>
    <li><?= esc($key) ?>: <?= esc($value) ?></li>
<?php endforeach ?>

<?= form_open_multipart($route) ?>
<br>
<label>
    Nama Organisasi
    <input type="text" name="display_name" value="<?= $display_name ?>"/>
</label>
<br>
<label>
    Nama Pembina
    <input type="text" name="coach_name" value="<?= $coach_name ?>"/>
</label>
<br>
<label>
    Nama Pimpinan
    <input type="text" name="chairman_name" value="<?= $chairman_name ?>" />
</label>
<br>
<label>
    Nama Wakil Pimpinan
    <input type="text" name="vice_chairman_name" value="<?= $vice_chairman_name ?>" />
</label>
<br>
<label>
    Jadwal Kegiatan
    <select name="timetable">
        <?php foreach ($timetables as $time): ?>
            <option value="<?= $time ?>" <?= $time == $timetable ? 'selected' : '' ?>><?= $time ?></option>
        <?php endforeach ?>
    </select>
</label>
<br>
<label>
    Visi
    <br>
    <textarea name="vision"><?= $vision ?></textarea>
</label>
<br>
<label>
    Misi
    <br>
    <textarea name="mission"><?= $mission ?></textarea>
</label>
<br>
<label>
    Program Kerja
    <br>
    <textarea name="work_program"><?= $work_program ?></textarea>
</label>
<br>
<label>
    Icon Organisasi
    <input type="file" name="icon" size="20" />
</label>
<br>
<label>
    Instagram
    <input type="text" name="instagram" value="<?= $instagram ?>" />
</label>
<br>


<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>
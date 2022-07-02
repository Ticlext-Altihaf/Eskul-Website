<html>
<head>
    <title>Editor</title>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
        }
        .styled-table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        .styled-table tbody tr:nth-of-type(even) {
            background-color: #f3f3f3;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid #009879;
        }
        .styled-table tbody tr.active-row {
            font-weight: bold;
            color: #009879;
        }
    </style>
</head>
<body>
<h1>
    <?= esc($role) ?> <?= esc($name) ?>
</h1>
<button>
    <a href="<?= base_url('/admin/manage/club/add') ?>">Add</a>
</button>
<table class="styled-table">
    <?php
    foreach ($keys_field as $key => $value) {
        echo "<th>$value</th>";
    }
    ?>
    <th>Edit</th>
    <th>Delete</th>
    <?php
    foreach ($clubs as $no => $values) {
        echo "<tr>";
        foreach ($values as $key => $value) {
            echo "<td>$value</td>";
        }
        echo "<td><a href='" . base_url('/admin/manage/club/edit/' . $values['name']) . "'>Edit</a></td>";
        echo "<td><a href='" . base_url('/admin/manage/club/delete/' . $values['name']) . "'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>

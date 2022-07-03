<html>
<head>
    <title>Editor</title>
    <style>
        .styled-table {
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            white-space:nowrap;

            table-layout: fixed;
        }
        .styled-table thead tr {
            background-color: #009879;
            color: #ffffff;
            text-align: left;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            width: 10%;
            overflow: hidden;

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

<button>
    <a href="<?= route_to("editor.add") ?>">Add</a>
    <a href="<?= route_to("editor.import") ?>">Import</a>
    <a href="<?= route_to("editor.delete.all") ?>">Delete All</a>
</button>
<table class="styled-table">
    <?php
    foreach ($keys_field as $key => $value) {
        echo "<th>$value</th>";
    }
    ?>
    <th>Edit</th>
    <th>Delete</th>
    <th>View</th>
    <?php
    foreach ($clubs as $no => $values) {
        echo "<tr>";
        foreach ($values as $key => $value) {
            echo "<td>$value</td>";
        }
        echo "<td><a href='" . route_to("editor.edit", $values['name']) . "'>Edit</a></td>";
        echo "<td><a href='" . route_to("editor.delete", $values['name']) . "'>Delete</a></td>";
        echo "<td><a target='_blank' href='" . base_url($values['name']) . "'>View</a></td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>

<html lang="en" data-lt-installed="true">
<head>

    <meta charset="UTF-8">

    <link rel="apple-touch-icon" type="image/png"
          href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon"
          href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

    <link rel="mask-icon" type="image/x-icon"
          href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg"
          color="#111">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin Auth Manage</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


    <style>
        * {
            box-sizing: border-box;
        }

        html.open, body.open {
            height: 100%;
            overflow: hidden;
        }

        html {
            padding: 40px;
            font-size: 62.5%;
        }

        body {
            padding: 20px;
            background-color: #5BB9B8;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            color: #fff;
            font-size: 1.6rem;
            font-family: 'Lato', sans-serif;
        }

        p {
            text-align: center;
            margin: 20px 0 60px;
        }

        main {
            background-color: #2C3845;
        }

        h1 {
            text-align: center;
            font-weight: 300;
        }

        table {
            display: block;
        }

        tr, td, tbody, tfoot {
            display: block;
        }

        thead {
            display: none;
        }

        tr {
            padding-bottom: 10px;
        }

        td {
            padding: 10px 10px 0;
            text-align: center;
        }

        td:before {
            content: attr(data-title);
            color: #7a91aa;
            text-transform: uppercase;
            font-size: 1.4rem;
            padding-right: 10px;
            display: block;
        }

        table {
            width: 100%;
        }

        th {
            text-align: left;
            font-weight: 700;
        }

        thead th {
            background-color: #202932;
            color: #fff;
            border: 1px solid #202932;
        }

        tfoot th {
            display: block;
            padding: 10px;
            text-align: center;
            color: #b8c4d2;
        }

        .button {
            line-height: 1;
            display: inline-block;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 5px;
            color: #fff;
            padding: 8px;
            background-color: #4b908f;
        }

        .select {
            padding-bottom: 20px;
            border-bottom: 1px solid #28333f;
        }

        .select:before {
            display: none;
        }

        .detail {
            background-color: #BD2A4E;
            width: 100%;
            height: 100%;
            padding: 40px 0;
            position: fixed;
            top: 0;
            left: 0;
            overflow: auto;
            -moz-transform: translateX(-100%);
            -ms-transform: translateX(-100%);
            -webkit-transform: translateX(-100%);
            transform: translateX(-100%);
            -moz-transition: -moz-transform 0.3s ease-out;
            -o-transition: -o-transform 0.3s ease-out;
            -webkit-transition: -webkit-transform 0.3s ease-out;
            transition: transform 0.3s ease-out;
        }

        .detail.open {
            -moz-transform: translateX(0);
            -ms-transform: translateX(0);
            -webkit-transform: translateX(0);
            transform: translateX(0);
        }

        .detail-container {
            margin: 0 auto;
            padding: 40px;
            max-width: 500px;
        }

        dl {
            margin: 0;
            padding: 0;
        }

        dt {
            font-size: 2.2rem;
            font-weight: 300;
        }

        dd {
            margin: 0 0 40px 0;
            font-size: 1.8rem;
            padding-bottom: 5px;
            border-bottom: 1px solid #ac2647;
            box-shadow: 0 1px 0 #c52c51;
        }

        .close {
            background: none;
            padding: 18px;
            color: #fff;
            font-weight: 300;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 4px;
            line-height: 1;
            font-size: 1.8rem;
            position: fixed;
            right: 40px;
            top: 20px;
            -moz-transition: border 0.3s linear;
            -o-transition: border 0.3s linear;
            -webkit-transition: border 0.3s linear;
            transition: border 0.3s linear;
        }

        .close:hover, .close:focus {
            background-color: #a82545;
            border: 1px solid #a82545;
        }

        @media (min-width: 460px) {
            td {
                text-align: left;
            }

            td:before {
                display: inline-block;
                text-align: right;
                width: 140px;
            }

            .select {
                padding-left: 160px;
            }
        }

        @media (min-width: 720px) {
            table {
                display: table;
            }

            tr {
                display: table-row;
            }

            td, th {
                display: table-cell;
            }

            tbody {
                display: table-row-group;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }

            td {
                border: 1px solid #28333f;
            }

            td:before {
                display: none;
            }

            td, th {
                padding: 10px;
            }

            tr:nth-child(2n+2) td {
                background-color: #242e39;
            }

            tfoot th {
                display: table-cell;
            }

            .select {
                padding: 10px;
            }
        }

        .danger {
            background-color: #f44336;
        }
    </style>
    <link rel="stylesheet" href="/assets/css/login.css">
    <script>
        function post(data) {
            //check if str
            if (typeof (data) == 'string') {
                data = {
                    'action': data
                }
            }
            let req = new XMLHttpRequest();
            req.open('POST', '');
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(JSON.stringify(data));
            req.onload = function () {
                const obj = JSON.parse(req.responseText);
                if (req.status === 200) {
                    alert(obj.message);
                    location.reload();
                } else {
                    if(obj.errors){
                        for (let [key, value] of Object.entries(obj.errors)) {
                            alert(key + ': ' + value);
                        }
                    }
                    alert('Error ' + req.status + ': ' + obj.message);
                }
            }
        }

    </script>
    <style>
        form {
            height: 80%;
            width: 30%;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -55%);
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgb(8 7 16 / 60%);
            padding: 50px 35px;
        }
        label {
            display: block;
            margin-top: 1px;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>

<body>
<h1>
    Auth List <?= esc($type) ?>
</h1>
<!-- check for errors -->
<?php if (isset($errors) && !empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $key => $value): ?>
                <li><?= esc($key) ?>: <?= esc($value) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post" id="form-add" hidden="hidden" action="<?= route_to("admin.add")?>">
    <label for="username">Username</label>
    <input type="text" placeholder="Username" id="username" name="username">

    <label for="password">Password</label>
    <input type="text" placeholder="Password" id="password" name="password">

    <label for="role">Role</label>
    <select name="role" id="role">

        <?php foreach ($roles as $role => $index): ?>
            <option value="<?= $role ?>"><?= $role ?></option>
        <?php endforeach; ?>
    </select>

    <label for="admin_club">Admin Club</label>
    <select name="admin_club" id="admin_club">
        <option value="" selected>None</option>
        <?php foreach ($clubs as $club): ?>
            <option value="<?= $club['name'] ?>"><?= $club['name'] ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" id="action" name="action" hidden value="add"/>

    <!-- Check for session errors -->
    <?php if($error): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <button>Add</button>

</form>
<main>
    <table>
        <thead>
        <tr>
            <th>
                Username
            </th>
            <th>
                Role
            </th>
            <th>
                Admin Club
            </th>
            <th>
                Action
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th colspan="3">
                <button class="button" onclick="
                const a =document.getElementById('form-add');
                a.hidden = !a.hidden;

"> Add </button>
            </th>
            <th colspan="1">
                <button class="button danger" id="delete-all"
                        onclick="
                if(confirm('Are you sure you want to delete all?')){
                    post({
                        'action': 'delete-all'
                    })
                }">Delete All
                </button>
            </th>

        </tr>
        </tfoot>
        <tbody>
        <?php
        foreach ($admins as $admin) {
            echo '<tr>';
            echo '<td data-title="username">' . $admin['username'] . '</td>';
            echo '<td data-title="role">' . $admin['role'] . '</td>';
            echo '<td data-title="admin-club">' . $admin['admin_club'] . '</td>';
            echo '<td>';
            //echo '<a href="edit/' . $admin['username'] . '" class="button">Edit</a>';//too lazy implement later

            echo '<a href="'. route_to('admin.delete', $admin['username'])   . '" class="button danger">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>

        </tbody>
    </table>
</main>


</body>
</html>
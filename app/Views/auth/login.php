<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Admin Login</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<form method="post" action="<?php echo base_url('/login'); ?>">
    <h3>Login</h3>

    <label for="username">Username</label>
    <input type="text" placeholder="Username" id="username" name="username">

    <label for="password">Password</label>
    <input type="password" placeholder="Password" id="password" name="password">

    <!-- Check for session errors -->
    <?php if($error): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <button>Log In</button>

</form>
</body>
</html>

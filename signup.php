<?php
include 'connection.php';

$errorMsg = "";

if(isset($_POST['sign'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    $pass = password_hash($password, PASSWORD_DEFAULT);

    // Check if username already exists
    $usernameCheckQuery = "SELECT * FROM login WHERE name='$username'";
    $usernameCheckResult = mysqli_query($connection, $usernameCheckQuery);
    $numUsername = mysqli_num_rows($usernameCheckResult);

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM login WHERE email='$email'";
    $emailCheckResult = mysqli_query($connection, $emailCheckQuery);
    $numEmail = mysqli_num_rows($emailCheckResult);

    if($numUsername > 0 && $numEmail > 0) {
        $errorMsg = "Account already exists";
    } elseif($numUsername > 0) {
        $errorMsg = "Username already taken";
    } elseif($numEmail > 0) {
        $errorMsg = "Email already exists";
    } else {
        $query = "INSERT INTO login(name, email, password, gender) VALUES('$username', '$email', '$pass', '$gender')";
        $query_run = mysqli_query($connection, $query);
        if($query_run) {
            header("location:signin.php");
        } else {
            echo '<script type="text/javascript">alert("data not saved")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="loginstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
    body {
        background-image: url('img/login1.jpg');
        background-size: 140%; 
        background-repeat: no-repeat;
        background-position: center;
    }
    .container {
        background-color: transparent;
    }
    .error-msg {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
</style>
</head>
<body>

    <div class="container" >
        <div class="regform" >
            <form action="" method="post">
                <p class="logo"> <b style="color: #06C167;">Food Donate</b></p>
                <p id="heading">Create your account</p>
                <div class="input">
                    <label class="textlabel" for="name">User name</label><br>
                    <input type="text" id="name" name="name" required/>
                    <div class="error-msg"><?php echo $errorMsg == "Username already taken" ? $errorMsg : ""; ?></div>
                </div>
                <div class="input">
                    <label class="textlabel" for="email">Email</label>
                    <input type="email" id="email" name="email" required/>
                    <div class="error-msg"><?php echo $errorMsg == "Email already exists" ? $errorMsg : ""; ?></div>
                </div>
                <label class="textlabel" for="password">Password</label>
                <div class="password">
                    <input type="password" name="password" id="password" required/>
                    <i class="uil uil-eye-slash showHidePw" id="showpassword"></i>                
                </div>
                <div class="radio">
                    <input type="radio" name="gender" id="male" value="male" required/>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="female">
                    <label for="female">Female</label>
                </div>
                <?php if($errorMsg == "Account already exists") { ?>
                <div class="error-msg" style="text-align: center;"><?php echo $errorMsg; ?></div>
                <?php } ?>
                <div class="btn">
                    <button type="submit" name="sign">Continue</button>
                </div>
                <div class="signin-up">
                    <p style="font-size: 20px; text-align: center;">Already have an account? <a href="signin.php"> Sign in</a></p>
                </div>
            </form>
        </div>
    </div>

    <script src="admin/login.js"></script>
</body>
</html>

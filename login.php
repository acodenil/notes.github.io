<?php
$server1 = "localhost";
$username1 = "root";
$password1 = "";
$database1 = "notes";

$con = mysqli_connect($server1, $username1, $password1, $database1);

if (!$con)
    die("Not CONNECTED");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // echo "post hua";
    if (isset($_POST['username'])) {
        // echo "idhar aaya";
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT `username` FROM `users`";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows(($result))==0){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>No User Exist </strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";        
        }
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['username'] == $username) {
                $sql = "SELECT `password` FROM `users` WHERE `username`='$username'";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row['password'] = $password) {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Logged In </strong>Successfully
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                    echo "<script>window.location='index.php'</script>";
                }
            } else {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Try Again </strong>Username Not Found
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        }
    } elseif (isset($_POST['usernamesignup'])) {
        
        $username = $_POST['usernamesignup'];
        $password = $_POST['passwordsignup'];
        $sql = "SELECT `username` FROM `users`";
        $result = mysqli_query($con, $sql);
        $flag = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['username'] == $username) {
                echo"<script>alert('Username Taken ! Try Something Else ')</script>";
                $flag = 1;
                break;
            }
        }
        if (!$flag) {
            $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
            $result = mysqli_query($con, $sql);
            
            if ($result) {
                echo "<div class='alert alert-success alert-dismissible fade show' id='as' role='alert'>
                <strong>Registered </strong>Successfully
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            } else
            $fail_alert = true;
        }
        else
        echo "<script>window.location='login.php'</script>";

    } else {
        // echo "else me";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script>
    </script>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="logo.jpg" alt="">
        </div>
        <div class="right">
            <div class="header ">
                <h1 id="test">NOTES</h1>
                <div class="sign">
                    <button class="btn2 login" onclick="login()">LOGIN</button>
                    <button class="btn2 signup" onclick="signup()">SIGNUP</button>
                </div>
            </div>
            <div class="formdiv">
                <form action="" method="post">
                    <div class="login_input">
                        <input required type="text" name="username" id="username" class="formrow" placeholder="Username">
                    </div>
                    <div class="login_input">
                        <input type="password" name="password" id="password" class="formrow"
                            placeholder="Password">
                    </div>
                    <div class="login_input">
                        <button class="formrow btn1" id="loginbtn">Login</button>
                    </div>
                </form>

                <form action="" method="post">
                    <div class="signup_input">
                        <input required type="text" name="usernamesignup" id="usernamesignup" class="formrow" placeholder="New Username">
                    </div>
                    <div class="signup_input">
                        <input required type="password" name="passwordsignup" id="passwordsignup" class="formrow"
                            placeholder="New Password">
                    </div>
                    <div class="signup_input">
                        <button class="formrow btn1" id="signupbtn">Sign Up</button>
                    </div>
                </form>
            </div>
            <!-- <div class="register">
                Don't have an account ? <a href="regpage.php" id="reglink">Register</a>
            </div> -->
        </div>
    </div>
    <script>
        function signup(){
            // a='';
            // console.log(a);
            <?php
            //  echo $_POST;
             ?>
            // b=document.getElementById("test").innerHTML=a;
            // console.log(b);
            signups=document.getElementsByClassName("signup_input");
            Array.from(signups).forEach((element) => {
                element.style.display="block";
                console.log(element.style);
            });

            logins=document.getElementsByClassName("login_input");
            Array.from(logins).forEach(element => {
                element.style.disabled="true";
                element.style.display="none";
            });
        }
        function login(){
            logins=document.getElementsByClassName("login_input");
            Array.from(logins).forEach((element) => {
                element.style.display="block";
                // console.log(element.style);
            });
            signups=document.getElementsByClassName("signup_input");
            Array.from(signups).forEach(element => {
                element.style.display="none";
            });
        }

        setTimeout(function () { 
         $('#as').alert('Close'); 
         console.log("hello");
      }, 1000);
    </script>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
session_start();

include("../database/connection.php"); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        // Retrieve form data
        $fullname = $_POST['signup_fullname'];
        $email = $_POST['signup_email'];
        $password = $_POST['signup_password'];
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // If validation passes, insert the user data into the database
        $sql = "INSERT INTO login (fullname, email, password , roll) VALUES ('$fullname', '$email', '$hashedPassword' , 'user')";
        if (mysqli_query($conn, $sql)) {
            // User registration successful
            $_SESSION['fullname'] = $fullname;
            $_SESSION['email'] = $email;
            if (isset($product_id)) {
                header("Location: single-product.php?id=" . $product_id);
            } else {
                header("Location: index.php");
                exit(); // Optional: Add an exit() statement to terminate the current script execution
            }
        } else {
            // User registration failed
            // Handle the error or redirect to an error page
            echo "Error: " . mysqli_error($conn);
        }
    }

    if (isset($_POST['login'])) {
        $email = $_POST['login_email'];
        $password = $_POST['login_password'];
        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            // Rest of your code...
        }
        $sql = "SELECT password , roll , fullname FROM login WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);


                $hashedPasswordFromDatabase = $row['password'];

                $roll = $row['roll'];
                $name = $row['fullname'];



                // Verify the password
                if (password_verify($password, $hashedPasswordFromDatabase)) {

                    if ($roll == 'admin') {
                        $_SESSION['email'] = $email;
                        $_SESSION['fullname'] = $name;

                        header("Location: ../admin/index.php");
                        exit();
                    }
                    if ($roll == 'user') {
                        $_SESSION['email'] = $email;
                        $_SESSION['fullname'] = $name;
                       
                        if (isset($product_id)) {
                          
                            header("Location: single-product.php?id=" . $product_id);
                        } else {
                            header("Location: index.php");
                         
                        }

                        exit();
                    }
                } else {
                    $message = "Password is incorrect";
                }
            } else {
                $message = " No matching email found in the database";
            }
        } else {
            $message = "Query execution error";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login/SignUp page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="./assets/css/login.css">

</head>

<body>

    <div class="wrapper">
        <div class="headline">
            <h2>Empowering women's fashion entrepreneurship effortlessly. Welcome to Phulkari eva.</h2>
        </div>
        <div class="signup">
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                    ?>
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input type="text" name="signup_fullname" placeholder="Full name" required="">
                </div>
                <div class="form-group">
                    <input type="email" name="signup_email" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="signup_password" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn" name="signup">SIGN UP</button>
                <div class="error-message"><?php if (isset($message)) {
                                                print_r($message);
                                            }  ?></div>
                <div class="account-exist">
                    Already have an account? <a href="#" id="login">Login</a>
                </div>
                <div class="account-exist">
                <a href="./index.php"> Back to website </a>
                </div>
            </form>
        </div>
        <div class="signin">
            <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                    ?>
                        <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <input type="email" name="login_email" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="login_password" placeholder="Password" required="">
                </div>
                <div class="forget-password">
                    <div class="check-box">
                        <!-- <input type="checkbox" id="checkbox" name="remember_me"> -->
                        <!-- <label for="checkbox">Remember me</label> -->
                    </div>
                    <a href="#">Forget password?</a>
                </div>
                <button type="submit" class="btn" name="login">LOGIN</button>
                <div class="error-message"><?php if (isset($message)) {
                                                print_r($message);
                                            }  ?></div>
                <div class="account-exist">
                    Create a new account? <a href="#" id="signup">Signup</a>
                </div>
                <div class="account-exist">
                <a href="./index.php"> Back to website </a>
                </div>
            </form>

        </div>

    </div>

    <script src="./assets/js/login.js"></script>
</body>

</html>
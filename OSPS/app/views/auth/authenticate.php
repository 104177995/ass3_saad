<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSPS - Authenticate</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/style.css">
</head>
<body>
    <div class="cont">
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo '<script>alert("' . htmlspecialchars($_SESSION['message']) . '");</script>';
            unset($_SESSION['message']);
        }
        ?>
        <div class="form sign-in" id="sign-in-form">
            <h2>Welcome</h2>
            <form action="../../controllers/AuthController.php" method="POST">
                <label>
                    <span>Email</span>
                    <input type="email" name="email" required />
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password" required />
                </label>
                <div class="signInBut">
                    <button type="submit" class="submit" name="action" value="sign-in" class="signInBut">Sign In</button>
                </div>
            </form>
        </div>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <h3>Don't have an account? Please Sign up!</h3>
                </div>
                <div class="img__text m--in">
                    <h3>If you already have an account, just sign in.</h3>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up" id="sign-up-form">
                <h2>Create your Account</h2>
                <form action="../../controllers/AuthController.php" method="POST">
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required />
                    </label>
                    <label>
                        <span>Password</span>
                        <input type="password" name="password" required />
                    </label>
                    <div class="signInBut">
                        <button type="submit" class="submit" name="action" value="sign-up">Sign Up</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });
    </script>
</body>
</html>

<?php
include('./database/config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #222;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 600px;
            margin: 0 auto;
            padding: 50px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 36px;
            color: #b38bff;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-size: 18px;
        }

        input {
            padding: 12px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #555;
        }

        button {
            padding: 10px;
            background-color: #b38bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.2s ease-in-out;
        }

        button:hover {
            background-color: #8c5fb2;
        }

        a {
            text-decoration: none;
            color: #b38bff;
            font-size: 18px;
            transition: color 0.2s ease-in-out;
        }

        a:hover {
            color: #8c5fb2;
        }

        p {
            text-align: center;
            margin: 8px;
        }

        .box {
            display: flex;
            position: relative;
        }

        .box input {
            width: 100%;
        }

        .eye {
            font-size: 20px;
            position: absolute;
            right: 10px;
            top: 12px;
            cursor: pointer;
        }

        .eye.disabled {
            display: none;
        }
    </style>


</head>

<body>

    <div class="container">

        <div class="form-container" id="login-form">
            <h1>Login</h1>
            <form action="" method="POST">
                <label for="username">Email</label>
                <input type="email" id="username" name="email" required>

                <label for="password">Password</label>
                <div class="box">
                    <input type="password" id="password" name="password" required>
                    <ion-icon name="eye-off-outline" class="eye disabled" id="eye_off"></ion-icon>
                    <ion-icon name="eye-outline" class="eye disabled" id="eye_show"></ion-icon>
                </div>
                <button type="submit" name="login_btn">Login</button>
            </form>

            <?php

            if (isset($_POST['login_btn'])) {

                $email_post    = $_POST['email'];
                $password_post = $_POST['password'];

                // lay user va password trong database
                $sql  = "SELECT * FROM tbl_user WHERE email = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email_post]);
                $row = $stmt->rowCount();

                if ($row < 1) {
                    echo '<span style="color:red;">Tài khoảng email này chưa đăng ki</span>';
                } else {
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $username_database = $row['user_name'];
                        $email_database    = $row['email'];
                        $password_database = $row['password'];
                    }

                    // so sánh với mã hash trong database
                    if ($email_post == $email_database && $password_post == $password_database) {
                        $_SESSION['user'] = [$username_database, $email_post];

                        header('location: ./admin/index.php');
                    } else {
                        echo '<span style="color: red;">Tên đăng nhập hoặc mật khẩu không chính xác!</span>';
                    }
                }
            }

            ?>


        </div>

    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        const eye_off = document.getElementById("eye_off");
        let eye_show = document.getElementById("eye_show");
        let password = document.getElementById("password");


        password.addEventListener("input", () => {
            eye_off.classList.remove("disabled");

            eye_off.onclick = function () {
                if (password.type = password.type == 'password') {
                    password.type = 'text';
                    eye_off.classList.add("disabled");
                    eye_show.classList.remove("disabled");
                } else {
                    password.type = 'password';
                    eye_show.classList.add("disabled");
                    eye_off.classList.remove("disabled");
                }
            }

            eye_show.onclick = function () {
                if (password.type = password.type == 'text') {
                    password.type = 'password';
                    eye_show.classList.add("disabled");
                    eye_off.classList.remove("disabled");
                } else {
                    password.type = 'text';
                    eye_show.classList.remove("disabled");
                    eye_off.classList.add("disabled");
                }
            }

        })
    </script>
</body>

</html>
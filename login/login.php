<!DOCTYPE html>
<html lang="en">
<?php
require_once('../database/config.php');
require_once('../database/dbhelper.php');
?>



<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
   

    <link rel="stylesheet" href="header.css">

    <title>Đăng nhập</title>
</head>

<body>
    <div id="wrapper" style="padding-bottom: 4rem;">
        <header>
            <div class="container">
                <section class="logo">
                <a href="../index.php"><img src="../images/logo.svg" alt="" width="60%"></a>
                </section>
                <nav>
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li class="nav-cha">
                            <a href="../thucdon.php?page=thucdon">Thực đơn</a>
                            <ul class="nav-con">
                                <?php
                                $sql = "SELECT * FROM category";
                                $result = executeResult($sql);
                                foreach ($result as $item) {
                                    echo '<li><a href="../thucdon.php?id_category=' . $item['id'] . '">' . $item['name'] . '</a></li>';
                                }
                                ?>
                                <!-- <li><a href="thucdon.php?page=trasua">Trà sữa</a></li>
                                <li><a href="thucdon.php?page=monannhe">Món ăn nhẹ</a></li>
                                <li><a href="thucdon.php?page=banhmi">Bánh mì</a></li>
                                <li><a href="thucdon.php?page=caphe">Cà phê</a></li> -->
                            </ul>
                        </li>
                        <li><a href="../about.php">Về chúng tôi</a></li>
                        <li><a href="../sendMail.php">Liên hệ</a></li>
                    </ul>
                </nav>
                <section class="menu-right">
                    <div class="cart">
                        <a href="../cart.php"><img src="../images/icon/cart.svg" alt=""></a>
                        <?php
                        $cart = [];
                        if (isset($_COOKIE['cart'])) {
                            $json = $_COOKIE['cart'];
                            $cart = json_decode($json, true);
                        }
                        $count = 0;
                        foreach ($cart as $item) {
                            $count += $item['num']; // đếm tổng số item
                        }
                        ?>
                    </div>
                    <div class="login">
                        <?php
                        if (isset($_COOKIE['username'])) {
                            echo '<a style="color:black;" href="">' . $_COOKIE['username'] . '</a>
                            <div class="logout">
                                <a href="changePass.php"><i class="fas fa-exchange-alt"></i>Đổi mật khẩu</a> <br>
                                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                            </div>
                            ';
                        } else {
                            echo '<a href="login.php"">Đăng nhập</a>';
                        }

                        ?>


                    </div>
                </section>
            </div>
        </header>
        <div class="container">
            <form action="login.php" method="POST">
                <h1 style="text-align: center;">Đăng nhập hệ thống</h1>
                <div class="form-group">
                    <label for="">Tài khoản:</label>
                    <input type="text" name="username" class="form-control" placeholder="Tài khoản">
                </div>
                <div class="form-group">
                    <label for="">Mật khẩu:</label>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                </div>
                <a href="forget.php">Quên mật khẩu</a>
                <div style="padding-top: 5px;" class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Đăng nhập">
                    <p style="padding-top: 1rem;">Bạn chưa có tài khoản? <a href="reg.php">Đăng ký</a></p>
                </div>
            </form>
        </div>
    </div>
    <?php
require_once('../database/config.php');
require_once('../database/dbhelper.php');
if (isset($_POST["submit"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = trim(strip_tags($_POST["username"]));
    $password = trim(strip_tags($_POST["password"]));
    // $password = md5($password); // Thay thế bằng cơ chế mã hóa mạnh hơn nếu cần.

    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $user = mysqli_query($con, $sql);

    if ($username === 'Admin' && $password === '1010') {
        // Đăng nhập admin
        echo '<script>
            alert("Đăng nhập Admin thành công!"); 
            window.location = "http://localhost/coffeeshop/admin/index.php";
        </script>';
        session_start();
        setcookie("username", $username, time() + 30 * 24 * 60 * 60, '/');
        setcookie("password", $password, time() + 30 * 24 * 60 * 60, '/');
    } else if (mysqli_num_rows($user) > 0) {
        // Đăng nhập user bình thường
        echo '<script>
            alert("Đăng nhập thành công!"); 
            window.location = "../index.php";
        </script>';
        session_start();
        setcookie("username", $username, time() + 30 * 24 * 60 * 60, '/');
        setcookie("password", $password, time() + 30 * 24 * 60 * 60, '/');
    } else {
        // Sai tài khoản hoặc mật khẩu
        echo '<script>
            alert("Tài khoản và mật khẩu không chính xác!"); 
            window.location = "login.php";
        </script>';
    }
}
?>

</body>

</html>
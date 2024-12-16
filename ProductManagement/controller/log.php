<?php
session_start();
?>
<?php
        include '../connection.php';

        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);

                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['firstname'] = $user['firstname'];
                    $_SESSION['email'] = $user['email'];
                

                    if ($user['role'] == 'store_manager') {
                        header("Location: ../views/admin_page.php");
                    } else {
                        header("Location: home2.php");
                    }
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No user found with this email.";
            }
        }
        ?>
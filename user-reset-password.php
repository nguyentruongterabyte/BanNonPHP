<?php 
include "connect.php";

if ($_GET['key'] && $_GET['reset']) {
    $email = $_GET['key'];
    $pass = $_GET['reset'];

    $query = "SELECT `email`, `password` FROM `user` WHERE `email` = '$email' AND `password` = '$pass'";
    $data = mysqli_query($conn, $query);

    if ($data == true) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Change Password</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 400px;
                    margin: 50px auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                h2 {
                    text-align: center;
                }
                form {
                    margin-top: 20px;
                }
                .form-group {
                    margin-bottom: 20px;
                }
                label {
                    display: block;
                    margin-bottom: 5px;
                }
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                }
                input[type="submit"] {
                    width: 100%;
                    padding: 10px;
                    border: none;
                    border-radius: 5px;
                    background-color: #007bff;
                    color: #fff;
                    cursor: pointer;
                }
                input[type="submit"]:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h2>Change Password</h2>
                <form id="changePasswordForm" method="POST" action="user-submit-new-password.php" onsubmit="return validatePassword()">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Retype Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" required>
                        <span id="passwordError" style="color: red; display: none;">Passwords do not match!</span>
                    </div>
                    <input type="hidden" name="key" value="<?php echo $email; ?>">
                    <input type="hidden" name="reset" value="<?php echo $pass; ?>">
                    <input type="submit" name="submit_password" value="Submit">
                </form>
            </div>

            <script>
                function validatePassword() {
                    var newPassword = document.getElementById("password").value;
                    var confirmPassword = document.getElementById("confirm_password").value;

                    if (newPassword != confirmPassword) {
                        document.getElementById("passwordError").style.display = "inline";
                        return false;
                    } else {
                        document.getElementById("passwordError").style.display = "none";
                        return true;
                    }
                }
            </script>
        </body>
        </html>
        <?php
    }
}

?>
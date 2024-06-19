<?php
require_once '../includes/db.php';

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE Email = '$email'";
    $result = mysqli_query($link, $sql);
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if(password_verify($password, $row['Password'])){
            $_SESSION['id'] = $row['UserID'];
            $_SESSION['role'] = $row['RoleID'];
            $_SESSION['name'] = $row['Name'];
            
            if ($row['RoleID'] == '1') {
                header("location: ../admin/index.php");
            } elseif ($row['RoleID'] == '2') {
                header("location: ../organizer/index.php");
            } else {
                header("location: ../user/index.php");
            }
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<?php include('../includes/header.php'); ?>
<main class="form-container">
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form action="login.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Login">
    </form>
</main>
<?php include('../includes/footer.php'); ?>

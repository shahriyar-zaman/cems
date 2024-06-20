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
            
            // Set session variables
            $_SESSION['id'] = $row['UserID'];
            $_SESSION['role'] = $row['RoleID'];
            $_SESSION['name'] = $row['Name']; // Assuming the column name is 'Name'

            // Redirect based on role
            if ($row['RoleID'] == '1') {
                header("location: ../admin/index.php");
            }
            elseif ($row['RoleID'] == '2') {
                header("location: ../organizer/index.php");
            } 
            else {
                header("location: ../user/index.php");
            }
        } 
        else {
            echo "Invalid password.";
        }
    } 
    else {
        echo "No account found with that email.";
    }
}
?>

<?php include('../includes/header.php'); ?>
<div class="form-container">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <label>Email:</label>
        <input type="email" name="email" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <input type="submit" value="Login">
    </form>
</div>
<?php include('../includes/footer.php'); ?>

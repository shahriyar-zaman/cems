<?php
require_once '../includes/db.php';

$registration_success = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];
    $department_id = $_POST['department_id'];
    $contact_number = $_POST['contact_number'];

    $sql = "INSERT INTO users (Name, Email, Password, RoleID, DepartmentID, ContactNumber) 
            VALUES ('$name', '$email', '$password', $role_id, $department_id, '$contact_number')";
    if(mysqli_query($link, $sql)){
        $registration_success = true;
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($link);
    }
}

$sql_roles = "SELECT * FROM roles";
$result_roles = mysqli_query($link, $sql_roles);

$sql_departments = "SELECT * FROM departments";
$result_departments = mysqli_query($link, $sql_departments);

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Register</h2>
    <?php if($registration_success): ?>
        <div class="success-message">
            <p>Registration successful! <a href="login.php">Click here to login</a>.</p>
        </div>
    <?php else: ?>
        <form action="register.php" method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Role:</label>
            <select name="role_id" required>
                <?php while ($row_roles = mysqli_fetch_array($result_roles)): ?>
                    <option value="<?php echo $row_roles['RoleID']; ?>"><?php echo $row_roles['RoleName']; ?></option>
                <?php endwhile; ?>
            </select>
            <label>Department:</label>
            <select name="department_id" required>
                <?php while ($row_departments = mysqli_fetch_array($result_departments)): ?>
                    <option value="<?php echo $row_departments['DepartmentID']; ?>"><?php echo $row_departments['DepartmentName']; ?></option>
                <?php endwhile; ?>
            </select>
            <label>Contact Number:</label>
            <input type="text" name="contact_number" required>
            <input type="submit" value="Register">
        </form>
    <?php endif; ?>
</div>

<?php include('../includes/footer.php'); ?>

<style>
    a {
        color: white;
        text-decoration: none;
    }
</style>

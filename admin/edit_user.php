<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

$user_id = $_GET['id'];

// Fetch user details
$sql = "SELECT * FROM users WHERE UserID = $user_id";
$result = mysqli_query($link, $sql);
$user = mysqli_fetch_array($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role_id = $_POST['role_id'];
    $department_id = $_POST['department_id'];

    $sql_update = "UPDATE users SET Name='$name', Email='$email', RoleID='$role_id', DepartmentID='$department_id' WHERE UserID = $user_id";
    
    if (mysqli_query($link, $sql_update)) {
        header("location: manage_users.php");
    } else {
        echo "ERROR: Could not execute $sql_update. " . mysqli_error($link);
    }
}

// Fetch roles and departments for the dropdowns
$sql_roles = "SELECT * FROM roles";
$result_roles = mysqli_query($link, $sql_roles);

$sql_departments = "SELECT * FROM departments";
$result_departments = mysqli_query($link, $sql_departments);

include('../includes/header.php');
?>

<div class="form-container">
    <h2>Edit User</h2>
    <form action="edit_user.php?id=<?php echo $user_id; ?>" method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['Name']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['Email']; ?>" required>
        
        <label>Role:</label>
        <select name="role_id" required>
            <?php while ($row_roles = mysqli_fetch_array($result_roles)): ?>
                <option value="<?php echo $row_roles['RoleID']; ?>" <?php if ($user['RoleID'] == $row_roles['RoleID']) echo 'selected'; ?>><?php echo $row_roles['RoleName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <label>Department:</label>
        <select name="department_id" required>
            <?php while ($row_departments = mysqli_fetch_array($result_departments)): ?>
                <option value="<?php echo $row_departments['DepartmentID']; ?>" <?php if ($user['DepartmentID'] == $row_departments['DepartmentID']) echo 'selected'; ?>><?php echo $row_departments['DepartmentName']; ?></option>
            <?php endwhile; ?>
        </select>
        
        <input type="submit" value="Update User">
    </form>
</div>

<?php include('../includes/footer.php'); ?>

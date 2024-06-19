<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("location: ../public/login.php");
    exit;
}

// Fetch users
$sql = "SELECT users.*, roles.RoleName, departments.DepartmentName FROM users 
        JOIN roles ON users.RoleID = roles.RoleID 
        JOIN departments ON users.DepartmentID = departments.DepartmentID";
$result = mysqli_query($link, $sql);

?>

<?php include('../includes/header.php'); ?>
<h2>Manage Users</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Department</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_array($result)): ?>
        <tr>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['RoleName']; ?></td>
            <td><?php echo $row['DepartmentName']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $row['UserID']; ?>">Edit</a>
                <a href="delete_user.php?id=<?php echo $row['UserID']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php include('../includes/footer.php'); ?>

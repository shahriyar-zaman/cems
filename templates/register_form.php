<form action="register.php" method="post">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <label>Role:</label>
    <select name="role_id" required>
        <?php while ($row_roles = mysqli_fetch_array($result_roles)): ?>
            <option value="<?php echo $row_roles['RoleID']; ?>"><?php echo $row_roles['RoleName']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>
    <label>Department:</label>
    <select name="department_id" required>
        <?php while ($row_departments = mysqli_fetch_array($result_departments)): ?>
            <option value="<?php echo $row_departments['DepartmentID']; ?>"><?php echo $row_departments['DepartmentName']; ?></option>
        <?php endwhile; ?>
    </select>
    <br>
    <label>Contact Number:</label>
    <input type="text" name="contact_number" required>
    <br>
    <input type="submit" value="Register">
</form>

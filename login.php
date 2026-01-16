<!DOCTYPE html>
<html>
<head>
    <title>KMC Login</title>
    <style>
        body { font-family: Arial; background:#f2f2f2; }
        .login-box {
            width:350px; margin:100px auto; padding:20px;
            background:#fff; border-radius:8px;
        }
        input, select {
            width:100%; padding:10px; margin:8px 0;
        }
        button {
            width:100%; padding:10px;
            background:#2c7be5; color:#fff; border:none;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h3>Kamrunnahar Medical Center</h3>

    <form method="post" action="login_action.php">
        <label>Role</label>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="manager">Manager</option>
            <option value="counter">Counter</option>
            <option value="lab">Laboratory</option>
            <option value="doctor">Doctor</option>
        </select>

        <input type="text" name="username" placeholder="User ID" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

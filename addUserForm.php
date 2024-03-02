<div id="addForm" class="p-4">
    <button class="btn btn-sm btn-danger close-btn">&times;</button>
    <h4 class="mb-3">Add New User</h4>
    <form method="post" action="processRegistration.php">
        <div class="form-group">
            <label for="Username">Username</label>
            <input type="text" class="form-control" name="Username" id="Username" required>
            <input type="hidden" class="form-control" name="Control" value="Control" id="Control" required>

        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" name="Email" id="Email" required>
        </div>
        <div class="form-group">
            <label for="Role">Role</label>
            <select class="form-control" id="Role" name="Role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control" name="Password" id="Password" required>
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
    </form>
</div>
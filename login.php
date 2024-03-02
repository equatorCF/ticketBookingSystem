<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body  class="bg-primary">
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">User Login</h2>
                        <form action="processLogin.php" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="Username" name="Username" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Email:</label>
                                <input type="text" class="form-control" id="Email" name="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="Password" name="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            <p class="mt-3 text-center">Not yet had account? <a href="register.php">Register Now</a></p>     
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

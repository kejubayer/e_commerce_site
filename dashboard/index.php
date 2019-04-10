<?php
$title = 'Admin Login';
$message = false;
$type = 'success';

if (isset($_POST['login'])) {
    $email = strtolower(trim($_POST['email']));
    $password = trim($_POST['password']);

    // check if user exists with the email address
    require_once '../database/connection.php';


    $query = 'SELECT id, email, password, role FROM users WHERE email=:email';
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password']) === true) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $message = 'User logged in.';

            header('Location: users.php');
        } else {
            $message = 'Invalid credentials.';
            $type = 'danger';
        }
    } else {
        $message = 'User not found.';
        $type = 'danger';
    }
}
require_once 'partials/_header.php';
?>
<div class="container">
    <?php if ($message): ?>
        <div class="alert alert-<?php echo $type; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form class="form-signin" action="" method="post" enctype="multipart/form-data">
        <h1 class="h3 mb-3 font-weight-normal">Admin Login</h1>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required
               autofocus>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" id="username" class="form-control" placeholder="Username" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button>
    </form>
</div>
<?php require_once 'partials/_footer.php'; ?>
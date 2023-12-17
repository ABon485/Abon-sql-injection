<?php
require_once 'templates/header.php';

$db = new PDO("mysql:host=localhost;dbname=practice_security", "root", "");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT username, credit_card_number FROM userdata WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->execute(['username' => $username]);
    $user = $statement->fetch();

    if (!$user || $user['password'] != $password) {
        echo '<div class="text-danger">Wrong username or password!</div>';
    } else {
?>
        <div class="card m-3">
            <div class="card-header">
                <span><?php echo htmlspecialchars($user['username']); ?></span>
            </div>
            <div class="card-body">
                <p class="card-text">Your credit card number: <?php echo htmlspecialchars($user['credit_card_number']); ?></p>
            </div>
        </div>
        <hr>
<?php
    }
}
?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>
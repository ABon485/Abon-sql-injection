<?php
require_once 'templates/header.php';
?>

<?php
$servername = "localhost";
$username = "root";
$database = "practice_security";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) :
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT username, credit_card_number FROM userdata WHERE username=:username and password=:password";
    $statement = $conn->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);

    $statement->execute();
    $list_of_users = $statement->fetchAll();

    if (count($list_of_users) == 0) :
        ?>
        <div class="text-danger">Wrong username or password !</div>
    <?php
    else :
        foreach ($list_of_users as $user) :
            ?>
            <div class="card m-3">
                <div class="card-header">
                    <span><?php echo $user['username'] ?></span>
                </div>
                <div class="card-body">
                    <p class="card-text">Your credit card number: <?php echo $user['credit_card_number']; ?></p>
                </div>
            </div>
            <hr>
        <?php
        endforeach;
    endif;
endif;
?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>
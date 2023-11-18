<?php
require_once '../../app.php';
include_once "$dir/partial/header.php";

$id = $_GET['id'] ?? 0;

$user = ($id) ? getUsersDetail($id) : null;

if (count($_POST)) {
    $errors = [];
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = $_POST['lastName'];
    $userName = $_POST['userName'];
    $passWord = $_POST['passWord'];
    if (!$firstName) {
        $errors[] = 'firstName is required';
    }

    if (isset($_POST['delete_user'])) {
        if ($id) {
            deleteUser($id);
            header('Location: users.php');
            exit;
        }
    } else {
        if (count($errors) == 0) {
            if ($id) {
                // Update user
                updateUser($id, $firstName, $lastName, $userName, $passWord, $avatarUrl);
            } else {
                $id = insertUser($firstName, $lastName, $userName, $passWord, $avatarUrl);
            }
            header('Location: users.php?');
            exit;
        }
    }
}


?>
<div class="container mt-4">   
<div class="d-flex align-middle align-text-middle justify-content-between p-2 bg-dark">
    <h1 style="line-height: normal;" class="font-weight-light line-height: normal text-uppercase text-white"><?= ($id) ? 'Edit User' : 'Add User'; ?></h1>
</div>
    <form class="p-3 mb-2" method="POST">
        <input type="hidden" name="user_id" value="<?= $id; ?>">
        <div class="form-group">
            <label for="firstName">Firstname:</label>
            <input placeholder="Firstname" type="text" class="form-control" name="firstName" id="firstName" value="<?= $_POST['firstName'] ?? $user->firstName ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="lastName">Lastname:</label>
            <input placeholder="Lastname" type="text" class="form-control" name="lastName" id="lastName" value="<?= $_POST['lastName'] ?? $user->lastName ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="userName">Username:</label>
            <input placeholder="Username" type="text" class="form-control" name="userName" id="userName" value="<?= $_POST['userName'] ?? $user->userName ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="passWord">Password:</label>
            <input placeholder="Password" type="text" class="form-control" name="passWord" id="passWord" value="<?= $_POST['passWord'] ?? $user->passWord ?? ''; ?>">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Save</button>
        <?php if ($id): ?>
            <button type="submit" name="delete_user" class="btn btn-outline-danger">Delete User</button>
        <?php endif; ?>
    </form>




<?php
include_once "$dir/partial/footer.php";
?>

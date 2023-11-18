<?php
require_once '../../app.php';
include_once "$dir/partial/header.php";

$id = $_GET['id'] ?? 0;

$actor = ($id) ? getActorsDetail($id) : null;
$media = getMediaForActor($id);

if (count($_POST)) {
    $errors = [];

    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = $_POST['lastName'];
    
    if (!$firstName) {
        $errors[] = 'firstName is required';
    }

    if (isset($_POST['delete_actor'])) {
        if ($id) {
            deleteActor($id);
            header('Location: actors.php');
            exit;
        }
    } else {
        if (count($errors) == 0) {
            if ($id) {
                // Update actor
                updateActor($id, $firstName, $lastName, $avatarUrl);
            } else {
                $id = insertActor($firstName, $lastName, $avatarUrl);
            }
            header('Location: actors.php');
            exit;
        }
    }
}

if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
    $file = $_FILES['file'];
    $name = $file['name'];
    $tmp_name = $file['tmp_name'];

    $extension = pathinfo($name, PATHINFO_EXTENSION);

    $newName = uniqid() . '.' . $extension;

    move_uploaded_file($tmp_name, __DIR__ . '/avatars/' . $newName);

    $avatarUrl = $newName;
    
    if ($id) {
        updateActorAvatar($id, $avatarUrl);
    } else {
        // Een nieuwe actor toevoegen met de avatarUrl
        $id = insertActor($firstName, $lastName, $avatarUrl);
    }
    header('Location: actors.php?id=' . $id);
    exit;
} else {
    $newName = $actor->avatarUrl ?? '';
}

?>
<div class="container mt-4">   
<div class="d-flex align-middle align-text-middle justify-content-between p-2 bg-dark">
    <h1 style="line-height: normal;" class="font-weight-light line-height: normal text-uppercase text-white"><?= ($id) ? 'Edit Actor' : 'Add Actor'; ?></h1>
</div>

    <form class="p-3 mb-2" method="POST" class="actor-form">
        <input type="hidden" name="actor_id" value="<?= $id; ?>">
        <div class="form-group">
            <label for="firstName">Firstname:</label>
            <input type="text" class="form-control" name="firstName" id="firstName" value="<?= $_POST['firstName'] ?? $actor->firstName ?? ''; ?>">
        </div>

        <div class="form-group">
            <label for="lastName">Lastname:</label>
            <input type="text" class="form-control" name="lastName" id="lastName" value="<?= $_POST['lastName'] ?? $actor->lastName ?? ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <?php if ($id): ?>
            <button type="submit" name="delete_actor" class="btn btn-outline-danger">Delete Actor</button>
        <?php endif; ?>
    </form>
    <?php if ($id): ?>
        <div class="p-3 mb-2">
            <h5>Media of the actor:</h5>
                <div>
                    <a href="/Media/media_detail.php?actor_id=<?= $id; ?>" class="btn btn-outline-dark">Add New Media</a>
                    <a href="/Media/media.php?actor_id=<?= $id; ?>" class="btn btn-outline-dark">Link Media</a>
                </div>
            <br>
            <ul class= "d-flex p-0 m-0">
                <?php
                foreach ($media as $media) {
                    include "$dir/views/medias/media-item-notype.php";
                }
                ?>
            </ul>
        </div>
        <div  class="p-3 mb-2">
        <h5>Upload avatar </h5>
        <form class="upload-form" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file" id="file">
                    <label class="custom-file-label" for="file">Choose an avatar</label>
                </div>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-dark">Upload</button>
                </div>
            </div>
        </form>
    </div>

    <?php endif; ?>

</div>

<?php
include_once "$dir/partial/footer.php";
?>

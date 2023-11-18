<?php
require_once '../../app.php';
include_once "$dir/partial/header.php";

$id = $_GET['id'] ?? 0;

$media = ($id) ? getMediaDetail($id) : null;
$actorsForMedia = getActorsForMedia($id);

if (count($_POST)) {
    $errors = [];

    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$name) {
        $errors[] = 'Name is required';
    }

    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
    if ($type_id === false) {
        $errors[] = 'Type ID is not valid';
    }

    $cover_url = filter_input(INPUT_POST, 'cover_url', FILTER_SANITIZE_SPECIAL_CHARS);

    if (isset($_POST['delete_media'])) {
        if ($id) {
            deleteMedia($id);
            header('Location: media.php');
            exit;
        }
    } else {
        if (count($errors) == 0) {
            if ($id) {
                // Update media
                updateMedia($id, $name, $type_id, $cover_url);
            } else {
                $id = insertMedia($name, $type_id, $cover_url);
                header('Location: media.php');
                exit;
            }

            if (isset($_POST['actors'])) {
                $selectedActors = $_POST['actors'];

                // Voeg geselecteerde acteurs toe aan de media
                foreach ($selectedActors as $actor_id) {
                    linkActorToMedia($actor_id, $id);
                }

                // Verwijder acteurs die niet zijn geselecteerd
                foreach ($actorsForMedia as $actorForMedia) {
                    if (!in_array($actorForMedia->actor_id, $selectedActors)) {
                        unlinkActorFromMedia($actorForMedia->actor_id, $id);
                    }
                }
            }

            header('Location: media_detail.php?id=' . $id);
            exit;
        }
    }
}
?>

<div class="container mt-4">   
<div class="d-flex align-middle align-text-middle justify-content-between p-2 bg-dark">
    <h1 style="line-height: normal;" class="font-weight-light line-height: normal text-uppercase text-white"><?= ($id) ? 'Edit Media' : 'Add Media'; ?></h1>
    <?php if ($id) : ?>
    <img src="<?= $media->cover_url ?>" alt="<?= $media->media_name ?>" style="width: 50px; height: 65px;" class="img-fluid">
    <?php endif; ?>
</div>


    <form class="p-3 mb-2" method="POST">
        <input type="hidden" name="media_id" value="<?= $id; ?>">
        <div class="form-group">
            <label for="name">Name:</label>
            <input placeholder="Type here the name of the media..." type="text" class="form-control" name="name" id="name" value="<?= $_POST['name'] ?? $media->name ?? ''; ?>">
        </div>
        <div class="form-group">
            <label for="cover_url">Cover Image URL:</label>
            <input  placeholder="Place here the link for the cover image of the media..." type="text" class="form-control" name="cover_url" id="cover_url" value="<?= $_POST['cover_url'] ?? $media->cover_url ?? ''; ?>">
        </div>
        <div class="form-group">
            <label for="type_id">Media Type:</label>
            <select class="form-control" name="type_id" id="type_id">
                <option value="">Select the type of the media...</option>
                <?php
                $mediaTypes = getMediaTypes();
                foreach ($mediaTypes as $type) {
                    $selected = ($type->type_id == $media->type_id) ? "selected" : "";
                    echo "<option value='{$type->type_id}' $selected>{$type->name}</option>";
                }
                ?>
            </select>
        </div>

        <br>
        <h5>Link or unlink actors to this media</h5>
        <div class="form-group">
            <?php
            $allActors = getAllActors();
            foreach ($allActors as $actor) {
                $checked = in_array($actor->actor_id, array_column($actorsForMedia, 'actor_id')) ? 'checked' : '';

                echo "<div class='custom-control custom-checkbox'>
                    <input type='checkbox' class='custom-control-input' name='actors[]' value='{$actor->actor_id}' id='actor{$actor->actor_id}' $checked>
                    <label class='custom-control-label text-dark' for='actor{$actor->actor_id}'>{$actor->firstName} {$actor->lastName}</label>
                </div>";
            }
            ?>
        </div>


        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <?php if ($id) : ?>
                <button type="submit" name="delete_media" class="btn btn-outline-danger ml-2">Delete Media</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php
include_once "$dir/partial/footer.php";
?>

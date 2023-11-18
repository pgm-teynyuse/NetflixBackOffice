<?php
require_once '../../app.php';
include_once "$dir/partial/header.php";

?>

<div class="container mt-4">

    <h1 class="card card-header text">Media Library</h1>
    <br>
    <form class="form" method="GET">
    <div class="row mb-4">
        <div class="col-auto">
            <label for="search" class="sr-only">Search</label>
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Media">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>
            </div>
        </div>
        <div class="d-flex mb-3">
            <a href="/Media/media_detail.php" class="btn btn-outline-dark">Add New Media</a>
        </div>
    </div>
</form>

    <div class="list-group">
        <?php
        $search = $_GET['search'] ?? '';
        $medias = getMedias($search);
        $mediaTypes = getMediaTypes();
        foreach ($medias as $media) {
            include "$dir/views/medias/media-item.php";
        
        }
        ?>
    </div>
</div>

<?php
include_once "$dir/partial/footer.php";
?>

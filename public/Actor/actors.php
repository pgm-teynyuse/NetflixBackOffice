<?php
require_once '../../app.php';
include_once "$dir/partial/header.php";
?>

<div class="container mt-4">
<h1 class="card card-header text">Actors</h1>
<br>
<form class="form" method="GET">
    <div class="row mb-4">
        <div class="col-auto">
            <label for="search" class="sr-only">Search</label>
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Search Actor">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-dark">Search</button>
                </div>
            </div>
        </div>
        <div class="d-flex mb-3">
            <a href="/Actor/actor_detail.php" class="btn btn-outline-dark">Add New Actor</a>
        </div>
    </div>
</form>

    <div class="list-group">
        <?php
        $search = $_GET['search'] ?? '';
        $actors = getActors($search);
        foreach ($actors as $actor) {
            include "$dir/views/actors/actor-item.php";
        }
        ?>
    </div>
</div>

<?php
include_once "$dir/partial/footer.php";
?>

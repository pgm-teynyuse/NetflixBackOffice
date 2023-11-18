<a href="actor_detail.php?id=<?= $actor->actor_id ?>" class="list-group-item list-group-item-action">
    <div class="media-container position-relative">
        <div class="row">
            <div class="col-md-1 d-flex align-items-center">
                <img src="avatars/<?= $actor->avatarUrl ?>" alt="Avatar" style="background-color: rgba(0, 0, 0, 0.7); width: 80px; height: 80px;" class="img-fluid">
            </div>
            <div class="col-md-9 d-flex align-items-center">
                <div>
                    <h5><?= $actor->firstName ?> <?= $actor->lastName ?></h5>
                </div>
            </div>
        </div>
    </div>
</a>

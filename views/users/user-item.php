<a href="user_detail.php?id=<?= $user->user_id ?>" class="list-group-item list-group-item-action">
    <div class="media-container position-relative">
        <div class="row">
            <div class="col-md-9 d-flex align-items-center">
                <div>
                    <h5><?= $user->firstName ?> <?= $user->lastName ?></h5>
                    <p><?= $user->userName ?></p>
                </div>
            </div>
        </div>
    </div>
</a>
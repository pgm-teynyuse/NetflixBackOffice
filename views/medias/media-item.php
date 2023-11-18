<a href="media_detail.php?id=<?= $media->media_id ?>" class="list-group-item list-group-item-action">
    <div class="media-container position-relative">
        <div class="row">
            <div class="col-md-1 d-flex align-items-center">
                <img src="<?= $media->cover_url ?>" alt="<?= $media->media_name ?>" style="background-color: rgba(0, 0, 0, 0.7); width: 80px; height: 80px;" class="img-fluid">
            </div>
            <div class="col-md-9 d-flex align-items-center">
                <div>
                    <h5><?= $media->media_name ?></h5>
                    <p><?= $media->type_name ?></p>
                </div>
            </div>
        </div>
    </div>
</a>
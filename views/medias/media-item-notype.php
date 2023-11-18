<div class="d-row p-1">
<a style="height:150px; width:100px;" href="../Media/media_detail.php?id=<?= $media->media_id ?>" class="list-group-item list-group-item-action">
    <div class="">
        <div class="row">
            <div class="col">
                <img src="<?= $media->cover_url ?>" alt="<?= $media->media_name ?>" style="background-color: rgba(0, 0, 0, 0.7); width: 60px; height: 70px;" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="text-center m-0 p-0">
    <p><?= $media->name ?></p>
</div>
</a>
</div>

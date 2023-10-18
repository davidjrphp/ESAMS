<div class="row">
    <div class="col-lg-14 col-md-14 col-sm-14 col-xs-14 mx-auto my-5 py5">
        <div class="card shadow rounded-0">
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <?= html_entity_decode(file_get_contents(base_app . "welcome.html")) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto my-5 py5">
        <div class="card shadow rounded-0">
            <div class="card-body rounded-0">
                <h4 class="heading title-font" style="font-size: 30px">Popular</h4>
                <div class="container-fluid">
                    <?php include 'music_list.php'; ?>
                </div>
            </div>
        </div>
    </div>
</div>
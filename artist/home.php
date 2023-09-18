<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-auto my-5 py5">
        <div class="card shadow rounded-0">
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <?php echo  is_file('welcome.html') ? file_get_contents('welcome.html') : "" ?>
                </div>
            </div>
        </div>
    </div>
</div>
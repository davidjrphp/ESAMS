<style>
    /* Box styles */
    .box {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        margin-bottom: 20px;
        height: 25rem;
    }

    .box h3 {
        color: #6f42c1;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .box h4 {
        color: #333;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .box ul {
        list-style: none;
        padding: 0;
    }

    .box ul li {
        font-size: 18px;
        margin: 10px 0;
        color: #555;
    }

    /* Featured box styles */
    .featured {
        background-color: #6f42c1;
    }

    .featured h3 {
        color: #fff;
    }

    .featured h4 {
        color: #fff;
    }

    /* Button styles */
    .btn-buy {
        display: inline-block;
        background-color: #6f42c1;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .btn-buy:hover {
        background-color: #512da8;
    }

    /* Disable button styles */
    .btn-buy[disabled] {
        background-color: #ccc;
        cursor: not-allowed;
    }
</style>

<div class="card card-outline rounded-0 card-purple">
    <div class="card-header">
        <h2 class="card-title">Choose your Plan</h2>
        <div class="card-tools">
            <!-- <a href="<?= base_url . "artist/?page=musics" ?>" class="btn btn-flat btn-light bg-light"><span class="fas fa-angle-left"></span> Back to List</a> -->
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="box">
                        <h3>Free Plan</h3>
                        <h4>$0<span> / month</span></h4>
                        <ul>
                            <li>Upload 2 Songs</li>
                            <li>ESAMS CheckMark</li>
                            <li>Daily Stream Stats</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="?page=musics/manage_music" class="btn-buy">Pick This</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-md-0">
                    <div class="box featured">
                        <h3>Musician</h3>
                        <h4>$1.53<span> / month</span></h4>
                        <ul>
                            <li>Unlimited Songs</li>
                            <li>Lyrics Upload</li>
                            <li>Royalty</li>
                            <li>Daily Stream Stats</li>
                            <li>Social Media Sharing</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy" disabled>Pick This</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mt-4 mt-lg-0">
                    <div class="box featured">
                        <h3>Premium</h3>
                        <h4>$3.2<span> / month</span></h4>
                        <ul>
                            <li>Unlimited Songs</li>
                            <li>Lyrics Upload</li>
                            <li>Royalty</li>
                            <li>Daily Stream Stats</li>
                            <li>Social Media Sharing</li>
                        </ul>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy" disabled>Pick This</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
  #system-cover {
    width: 100%;
    height: 45em;
    object-fit: cover;
    object-position: center center;
  }
</style>
<h1 class="text-light">Welcome, <?php echo $_settings->userdata('firstname') . " " . $_settings->userdata('lastname') ?>!</h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Active Categories</span>
        <span class="info-box-number text-right h5">
          <?php
          $category = $conn->query("SELECT * FROM category_list WHERE delete_flag = 0 AND `status` = 1")->num_rows;
          echo number_format($category);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-6">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-headphones-alt"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Published Music</span>
        <span class="info-box-number text-right h5">
          <?php
          $musics = $conn->query("SELECT * FROM music_list WHERE delete_flag = 0 AND `status` = 1")->num_rows;
          echo number_format($musics);
          ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<div class="container-fluid text-center">
  <img src="../uploads/cover3.jpg" alt="system-cover" id="system-cover" class="img-fluid">
</div>
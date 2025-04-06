<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }

  .user-dd:hover {
    color: #fff !important
  }

  .login {
    border-radius: 222px;
  }
</style>
<nav class="main-header navbar navbar-expand-lg navbar-dark bg-gradient-info">
  <div class="container container-md-fluid container-sm-fluid px-6 px-lg-7 ">
    <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand" href="./">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="50" height="50" class="d-inline-block align-top rounded-circle" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>

    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" aria-current="page" href="../"><b>Home</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="../?page=all_artists"><b>Artists</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="../?page=music_list"><b>Popular</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="../?page=categories"><b>Genre</b></a>
        </li>
        <li class="nav-item dropdown rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link dropdown-toggle text-white" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b>More</b>
          </a>
          <div class="dropdown-menu" aria-labelledby="moreDropdown">
            <a class="dropdown-item" href="#" style="font-size: 20px">Playlist</a>
            <a class="dropdown-item" href="#" style="font-size: 20px">Favorite</a>
            <a class="dropdown-item" href="#" style="font-size: 20px">Podcast</a>
            <a class="dropdown-item" href="#" style="font-size: 20px">Supporters</a>
            <a class="dropdown-item" href="../?page=about" style="font-size: 20px">About</a>
          </div>
        </li>
      </ul>

      <div class="d-flex align-items-center ">
        <button type="button" class="btn btn-outline-secondary login">
          <a class="font-weight-bolder text-light mx-2 text-decoration-none" style="font-size: 20px" href="../Login/">SIGN-IN</a>
        </button>
      </div>
      
    </div>
  </div>
</nav>
<script>
  $(function() {
    $('#search_report').click(function() {
      uni_modal("Search Request Report", "report/search.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function() {
      $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function() {
      if ($('body').offset.top == 0)
        $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e) {
    e.preventDefault()
    var sTxt = $('[name="search"]').val()
    if (sTxt != '')
      location.href = './?p=products&search=' + sTxt;
  })
</script>
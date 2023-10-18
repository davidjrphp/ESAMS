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


    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" aria-current="page" href="./"><b>Home</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="./?page=all_artists"><b>Artists</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="./?page=music_list"><b>Popular</b></a>
        </li>
        <li class="nav-item rounded-0 title-font text-center w-100" style="font-size: 20px">
          <a class="nav-link text-white" href="./?page=categories"><b>Genre</b></a>
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
            <a class="dropdown-item" href="./?page=about" style="font-size: 20px">About</a>
          </div>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
              <form class="form-inline">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li> -->
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
          <div class="btn-group nav-link">
            <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
              <span><img src="<?php echo validate_image($_settings->userdata('avatar')) ?>" class="img-circle elevation-2 user-img" alt="User Image"></span>
              <span class="ml-3"><?php echo ucwords($_settings->userdata('stage_name')) ?></span>
              <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" href="<?php echo base_url . 'artist/?page=account' ?>"><span class="fa fa-user"></span> My Account</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="<?php echo base_url . '/classes/Login2.php?f=logout' ?>"><span class="fas fa-sign-out-alt"></span> Logout</a>
            </div>
          </div>
        </li>
        <li class="nav-item">

        </li>
        <!--  <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
            </a>
          </li> -->
      </ul>
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
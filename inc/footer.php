<script>
  $(document).ready(function() {
    $('#p_use').click(function() {
      uni_modal("Privacy Policy", "policy.php", "mid-large")
    })
    window.viewer_modal = function($src = '') {
      start_loader()
      var t = $src.split('.')
      t = t[1]
      if (t == 'mp4') {
        var view = $("<video src='" + $src + "' controls autoplay></video>")
      } else {
        var view = $("<img src='" + $src + "' />")
      }
      $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
      $('#viewer_modal .modal-content').append(view)
      $('#viewer_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,
        focus: true
      })
      end_loader()

    }
    window.uni_modal = function($title = '', $url = '', $size = "") {
      start_loader()
      $.ajax({
        url: $url,
        error: err => {
          console.log()
          alert("An error occured")
        },
        success: function(resp) {
          if (resp) {
            $('#uni_modal .modal-title').html($title)
            $('#uni_modal .modal-body').html(resp)
            if ($size != '') {
              $('#uni_modal .modal-dialog').addClass($size + '  modal-dialog-centered')
            } else {
              $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
            }
            $('#uni_modal').modal({
              show: true,
              backdrop: 'static',
              keyboard: false,
              focus: true
            })
            end_loader()
          }
        }
      })
    }
    window._conf = function($msg = '', $func = '', $params = []) {
      $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
      $('#confirm_modal .modal-body').html($msg)
      $('#confirm_modal').modal('show')
    }
  })
</script>
<style>
  /* Contact Section Styles */
  #contact {
    position: relative;
    padding: 50px 0;
    color: #fff;
    text-align: center;
  }

  #contact .overlay-mf {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 50%;
    background-image: url(assets/images/background.png);
    background-color: transparent;
    z-index: -1;
  }

  #contact h5.title-left {
    font-size: 24px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 30px;
  }

  #contact .socil-icon ul {
    list-style: none;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
  }

  #contact .socil-icon li {
    margin: 0 15px;
  }

  #contact .socil-icon li a {
    color: #fff;
    font-size: 24px;
    transition: color 0.3s ease;
  }

  #contact .socil-icon li a:hover {
    color: #ccc;
  }

  #contact .socil-icon .ico-circle {
    display: inline-block;
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50%;
    background-color: #333;
    text-align: center;
  }

  #contact .socil-icon .ico-circle i {
    line-height: 50px;
  }

  #contact .socil-icon .fas.fa-envelope {
    margin-right: 5px;
  }

  #contact .socil-icon .fas.fa-phone {
    margin-right: 5px;
  }

  /* Responsive Styles */
  @media screen and (max-width: 768px) {
    #contact h5.title-left {
      font-size: 20px;
    }

    #contact .socil-icon ul {
      flex-wrap: wrap;
    }

    #contact .socil-icon li {
      margin: 10px 15px;
    }
  }
</style>
<!-- Footer-->
<footer class="py-5 bg-dark">
  <div class="container">
    <h1>
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="60" height="60" class="d-inline-block align-top rounded-circle" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </h1>
    <div class="m-0 item-center" id="contact">
      <div class="socil-icon d-flex flex-column">
        <ul>
          <li><a href="#"><span><i class="fab fa-facebook"></i></span></a></li>
          <li><a href="#"><span><i class="fab fa-instagram"></i></span></a></li>
          <li><a href="#"><span><i class="fab fa-youtube"></i></span></a></li>
          <li><a href="#"><span><i class="fab fa-twitter"></i></span></a></li>
          <li><a href="mailto:davidgarciajr955@gmail.com"><span><i class="fas fa-envelope"></i></span></a></li>
        </ul>
      </div>
    </div>
    <strong>&copy; <?php echo date('Y') ?>. <?php echo $_settings->info('short_name') ?></strong>
    <div class="float-right d-none d-sm-inline-block">Developed By: <a href="mailto:davidgaricajr955@gmail.com">David Mwelwa</a></div>
  </div>
</footer>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- overlayScrollbars -->
<!-- <script src="<?php echo base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url ?>dist/js/adminlte.js"></script>
<div class="daterangepicker ltr show-ranges opensright">
  <div class="ranges">
    <ul>
      <li data-range-key="Today">Today</li>
      <li data-range-key="Yesterday">Yesterday</li>
      <li data-range-key="Last 7 Days">Last 7 Days</li>
      <li data-range-key="Last 30 Days">Last 30 Days</li>
      <li data-range-key="This Month">This Month</li>
      <li data-range-key="Last Month">Last Month</li>
      <li data-range-key="Custom Range">Custom Range</li>
    </ul>
  </div>
  <div class="drp-calendar left">
    <div class="calendar-table"></div>
    <div class="calendar-time" style="display: none;"></div>
  </div>
  <div class="drp-calendar right">
    <div class="calendar-table"></div>
    <div class="calendar-time" style="display: none;"></div>
  </div>
  <div class="drp-buttons"><span class="drp-selected"></span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" disabled="disabled" type="button">Apply</button> </div>
</div>
<div class="jqvmap-label" style="display: none; left: 1093.83px; top: 394.361px;"></div>
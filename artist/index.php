<?php ob_start(); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php
if (!isset($_SESSION['login_id']))
  header('location:login.php');
include 'db_connect.php';
ob_start();
if (!isset($_SESSION['system'])) {

  $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
  foreach ($system as $k => $v) {
    $_SESSION['system'][$k] = $v;
  }
}
ob_end_flush();
?>
<?php require_once('header2.php') ?>

<body class="layout-top-nav layout-fixed control-sidebar-slide-open layout-navbar-fixed text-sm dark-mode" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
  <div class="wrapper">
    <?php require_once('topBarNav.php') ?>
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  pt-3" style="min-height: 567.854px;">

      <!-- Main content -->
      <section class="content">
        <div class="container container-md-fluid container-sm-fluid">
          <?php
          if (!file_exists($page . ".php") && !is_dir($page)) {
            include '404.html';
          } else {
            if (is_dir($page))
              include $page . '/index.php';
            else
              include $page . '.php';
          }
          ?>
        </div>
      </section>
      <!-- /.content -->
      <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable rounded-0" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <a class="text-muted" href="javascript:void(0)" data-dismiss="modal"><i class="fa fa-times"></i></a>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary rounded-0" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
              <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog modal-full-height  modal-md rounded-0" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-arrow-right"></span>
              </button>
            </div>
            <div class="modal-body">
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered rounded-0" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
              <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary rounded-0" id='confirm' onclick="">Continue</button>
              <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
            <img src="" alt="">
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php require_once('inc/footer.php') ?>
</body>

</html>
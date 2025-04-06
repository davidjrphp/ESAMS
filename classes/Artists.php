<?php
require_once('../config.php');
class Artists extends DBConnection
{
    private $settings;
    public function __construct()
    {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
    }
    public function __destruct()
    {
        parent::__destruct();
    }

    function registration()
{
    if (!empty($_POST['password']))
        $_POST['password'] = md5($_POST['password']);
    else
        unset($_POST['password']);
    extract($_POST);
    $main_field = ['stage_name', 'email', 'username', 'password', 'sex', 'DOB', 'about_artist', 'type'];
    $data = "";
    $check = $this->conn->query("SELECT * FROM `artist_list` WHERE email = '{$email}' " . ($id > 0 ? " AND id != '{$id}'" : "") . " ")->num_rows;
    if ($check > 0) {
        $resp['status'] = 'failed';
        $resp['msg'] = 'Email already exists.';
        return json_encode($resp);
    }
    foreach ($_POST as $k => $v) {
        $v = $this->conn->real_escape_string($v);
        if (in_array($k, $main_field)) {
            if (!empty($data)) $data .= ", ";
            $data .= " `{$k}` = '{$v}' ";
        }
    }
    if (empty($id)) {
        $sql = "INSERT INTO `artist_list` SET {$data} ";
    } else {
        $sql = "UPDATE `artist_list` SET {$data} WHERE id = '{$id}' ";
    }
    $save = $this->conn->query($sql);
    if ($save) {
        $uid = !empty($id) ? $id : $this->conn->insert_id;
        $resp['status'] = 'success';
        $resp['aid'] = $uid; // Fixed typo: $aid -> $uid
        if (!empty($id))
            $resp['msg'] = 'Artist Details have been updated successfully';
        else
            $resp['msg'] = 'Your Account has been created successfully';

        if (!empty($_FILES['img']['tmp_name'])) {
            if (!is_dir(base_app . "uploads/avatars"))
                mkdir(base_app . "uploads/avatars");
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $fname = "uploads/avatars/$uid.png";
            $accept = array('image/jpeg', 'image/png');
            if (!in_array($_FILES['img']['type'], $accept)) {
                $resp['msg'] = "Image file type is invalid";
            }
            if ($_FILES['img']['type'] == 'image/jpeg')
                $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
            elseif ($_FILES['img']['type'] == 'image/png')
                $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
            if (!$uploadfile) {
                $resp['msg'] = "Image is invalid";
            }
            $temp = imagescale($uploadfile, 200, 200);
            if (is_file(base_app . $fname))
                unlink(base_app . $fname);
            $upload = imagepng($temp, base_app . $fname);
            if ($upload) {
                $this->conn->query("UPDATE `artist_list` SET `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) WHERE id = '{$uid}'");
            }
            imagedestroy($temp);
        }
        if (!empty($uid) && $this->settings->userdata('login_type') != 1) {
            $artist = $this->conn->query("SELECT * FROM `artist_list` WHERE id = '{$uid}' ");
            if ($artist->num_rows > 0) {
                $res = $artist->fetch_array();
                foreach ($res as $k => $v) {
                    if (!is_numeric($k) && $k != 'password') {
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type', '1');
            }
        }
    } else {
        $resp['status'] = 'failed';
        $resp['msg'] = $this->conn->error;
        $resp['sql'] = $sql;
    }
    if ($resp['status'] == 'success' && isset($resp['msg']))
        $this->settings->set_flashdata('success', $resp['msg']);
    return json_encode($resp);
}

    public function save_artists()
    {
        if (empty($_POST['password']))
            unset($_POST['password']);
        else
            $_POST['password'] = md5($_POST['password']);
        extract($_POST);
        $data = '';
        foreach ($_POST as $k => $v) {
            if (!in_array($k, array('id'))) {
                if (!empty($data)) $data .= " , ";
                $data .= " {$k} = '{$v}' ";
            }
        }
        if (empty($id)) {
            $qry = $this->conn->query("INSERT INTO artist_list set {$data}");
            if ($qry) {
                $id = $this->conn->insert_id;
                $this->settings->set_flashdata('success', 'Saved successfully.');
                foreach ($_POST as $k => $v) {
                    if ($k != 'id') {
                        if (!empty($data)) $data .= " , ";
                        if ($this->settings->userdata('id') == $id)
                            $this->settings->set_userdata($k, $v);
                    }
                }
                if (!empty($_FILES['img']['tmp_name'])) {
                    if (!is_dir(base_app . "uploads/avatars"))
                        mkdir(base_app . "uploads/avatars");
                    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                    $fname = "uploads/avatars/$id.png";
                    $accept = array('image/jpeg', 'image/png');
                    if (!in_array($_FILES['img']['type'], $accept)) {
                        $err = "Image file type is invalid";
                    }
                    if ($_FILES['img']['type'] == 'image/jpeg')
                        $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                    elseif ($_FILES['img']['type'] == 'image/png')
                        $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
                    if (!$uploadfile) {
                        $err = "Image is invalid";
                    }
                    $temp = imagescale($uploadfile, 200, 200);
                    if (is_file(base_app . $fname))
                        unlink(base_app . $fname);
                    $upload = imagepng($temp, base_app . $fname);
                    if ($upload) {
                        $this->conn->query("UPDATE `artist_list` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
                        if ($this->settings->userdata('id') == $id)
                            $this->settings->set_userdata('avatar', $fname . "?v=" . time());
                    }

                    imagedestroy($temp);
                }
                return 1;
            } else {
                return 2;
            }
        } else {
            $qry = $this->conn->query("UPDATE artist_list set $data where id = {$id}");
            if ($qry) {
                $this->settings->set_flashdata('success', 'Successfully updated.');
                foreach ($_POST as $k => $v) {
                    if ($k != 'id') {
                        if (!empty($data)) $data .= " , ";
                        if ($this->settings->userdata('id') == $id)
                            $this->settings->set_userdata($k, $v);
                    }
                }
                if (!empty($_FILES['img']['tmp_name'])) {
                    if (!is_dir(base_app . "uploads/avatars"))
                        mkdir(base_app . "uploads/avatars");
                    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
                    $fname = "uploads/avatars/$id.png";
                    $accept = array('image/jpeg', 'image/png');
                    if (!in_array($_FILES['img']['type'], $accept)) {
                        $err = "Image file type is invalid";
                    }
                    if ($_FILES['img']['type'] == 'image/jpeg')
                        $uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
                    elseif ($_FILES['img']['type'] == 'image/png')
                        $uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
                    if (!$uploadfile) {
                        $err = "Image is invalid";
                    }
                    $temp = imagescale($uploadfile, 200, 200);
                    if (is_file(base_app . $fname))
                        unlink(base_app . $fname);
                    $upload = imagepng($temp, base_app . $fname);
                    if ($upload) {
                        $this->conn->query("UPDATE `artist_list` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
                        if ($this->settings->userdata('id') == $id)
                            $this->settings->set_userdata('avatar', $fname . "?v=" . time());
                    }

                    imagedestroy($temp);
                }

                return 1;
            } else {
                return "UPDATE artist_list set $data where id = {$id}";
            }
        }
    }
}

$artists = new artists();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'registration':
        echo $artists->registration();
        break;
    case 'save':
        echo $artists->save_artists();
        break;
   
    default:
        // echo $sysset->index();
        break;
}

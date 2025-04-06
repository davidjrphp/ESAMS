<?php
require_once '../config.php';

class Login extends DBConnection
{
    private $settings;

    public function __construct()
    {
        global $_settings;
        $this->settings = $_settings;
        parent::__construct();
        ini_set('display_errors', 1); // Enable for debugging; disable in production
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function index()
    {
        echo '<h1>Access Denied</h1> <a href="/">Go Back.</a>';
    }

    public function login()
    {
        extract($_POST);

        // Hash the password (MD5 as per your current setup)
        $password = md5($password);

        // Check users table (admins: type 1 or 2)
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_array();
            if (in_array($user['type'], [1, 2])) { 
                foreach ($user as $k => $v) {
                    if (!is_numeric($k) && $k != 'password') {
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type', 1); 
                $redirect = '../admin/index.php'; 
                return json_encode(['status' => 'success', 'redirect' => $redirect]);
            }
        }

        // Check artist_list table (artists: type 3 only)
        $stmt = $this->conn->prepare("SELECT * FROM artist_list WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $artist = $result->fetch_array();
            if ($artist['type'] == 3) { 
                foreach ($artist as $k => $v) {
                    if (!is_numeric($k) && $k != 'password') {
                        $this->settings->set_userdata($k, $v);
                    }
                }
                $this->settings->set_userdata('login_type', 2); 
                $redirect = '../artist/index.php'; 
                return json_encode(['status' => 'success', 'redirect' => $redirect]);
            }
        }

        // If no match or invalid type
        return json_encode([
            'status' => 'incorrect',
            'last_qry' => "SELECT * FROM users WHERE username = '$username' AND password = '$password' OR email = '$username' AND password = '$password'"
        ]);
    }

	public function logout()
	{
		if ($this->settings->sess_des()) {
			header('Location: /ESAMS/Login/');
			exit;
		}
		// Fallback if session destruction fails
		echo '<script>alert("Logout failed."); location.replace("/ESAMS/Login/index.php");</script>';
	}
}

$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
    case 'login':
        echo $auth->login();
        break;
    case 'logout':
        echo $auth->logout();
        break;
    default:
        echo $auth->index();
        break;
}
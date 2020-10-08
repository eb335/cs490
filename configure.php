<?PHP
    define('DB_SERVER', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'fevan4ever');
    define('DB_DATABASE', 'cs490');
	
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
	
    if(mysqli_connect_error()){
        die('Connect Error('.mysqli_connect_errno().')'. mysqli_connect_error());
    }
?>
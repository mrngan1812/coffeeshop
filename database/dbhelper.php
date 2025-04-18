<?php
require_once('config.php');

function execute($sql)
{
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	mysqli_query($con, $sql);

	//close connection
	mysqli_close($con);
}

function executeResult($sql)
{
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$data   = [];
	while ($row = mysqli_fetch_array($result, 1)) {
		$data[] = $row;
	}
	mysqli_close($con);
	return $data;
}

function executeSingleResult($sql)
{
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$row    = mysqli_fetch_array($result, 1);

	//close connection
	mysqli_close($con);

	return $row;
}
function executeInsert($sql) {
    $conn = getConnection();
    
    if ($conn->query($sql) === TRUE) {
        // Lấy ID của bản ghi vừa thêm vào
        $insertedId = $conn->insert_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $insertedId = null;
    }

    $conn->close();
    return $insertedId;
}
function getConnection() {
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'asm_php'; // Thay thế với tên cơ sở dữ liệu của bạn

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

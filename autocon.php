<?php
	$id_segment = $_POST['id_segment'];
	$marka = $_POST['marka'];
	$model = $_POST['model'];
	$lokalizacja = $_POST['lokalizacja'];
	$data_sprzedazy = $_POST['data_sprzedazy'];
	$user = 'root';
	$pass = '';
	$db = 'carrental';
	// Database connection
	$conn = new mysqli('localhost',$user, $pass, $db);
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into samochod (id_segment,marka,model,lokalizacja,data_sprzedazy) values(?, ?, ?, ?, ?)");
		$stmt->bind_param("sssss", $id_segment, $marka, $model, $lokalizacja, $data_sprzedazy);
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();
		$conn->close();
	}
?>
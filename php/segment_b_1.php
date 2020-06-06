<?php
session_start();

if(isset($_POST['button'])){
  $imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko'];
	$adres = $_POST['adres'];
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$user = 'root';
	$pass = '';
	$db = 'carrental';
	// Database connection
	$conn = new mysqli('localhost',$user, $pass, $db);
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into klient (imie, nazwisko, adres, telefon, email) values(?, ?, ?, ?,?)");
		$stmt->bind_param("sssss", $imie, $nazwisko, $adres, $telefon, $email);
		$execval = $stmt->execute();
		$stmt->close();
		$conn->close();
  }
  header("Location: segment_b_2.php");
}


?>

<html>
  <head>
    <title>Registration Page</title>
    <style>
        body {
            width: 100%;
            min-height: 100vh;
            background-image: linear-gradient(
                118.4deg,
                rgba(122, 35, 52, 1) 27.5%,
                rgba(62, 9, 27, 1) 92.7%
            );
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        div {
          display: flex;
          flex-direction: column;
        }

        form {
            border: 1px solid #FFF;
            padding: 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 600px;
        }

        label {
          color: #FFF;
          width: 100%;
          text-transform: uppercase;
        }

        input {
            padding: 8px;
            width: 100%;
            margin-bottom: 16px;
        }

        .button {
          margin-top: 32px;
          height: 40px;
          width: 25%;
          border: none;
          border-radius: 50px;
          background: #a73e3e;
          box-shadow:  -3px -3px 10px #8e3535ab, 
            3px 3px 10px #c047477a;
          text-transform: uppercase;
          color: #FFF;
        }

        .main {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
        }

        .cancel {
          text-decoration: none;
          text-transform: uppercase;
          color: blue;
        }

    </style>
  </head>
  <body>
        <main class="main">
            
            <!-- formularz -->
            <form method="post">
            
                <label for="imie">imie</label>
                <input type="text" id="imie" name="imie" placeholder="Wpisz swoje imie" required> 
                <label for="id">nazwisko</label>
                
                <input type="text" id="nazwisko" name="nazwisko" placeholder="Wpisz swoje nazwisko" required>
                <label for="adres">adres</label>
                <input type="text" id="adres" name="adres" placeholder="Wpisz swoj adres zamieszkania" required>
                <label for="telefon">telefon</label>
                <input type="text" id="telefon" name="telefon" placeholder="Wpisz swój numer telefonu" required>
                <label for="email">email</label>
                <input type="text" id="email" name="email" placeholder="olek.kros@gmail.com" required>
               
              <input type = "submit" name = 'button' class="button">
            </form>
            <a href="../index.html" class="cancel" onclick="cancelFunction();">anuluj</a>
      </main>
      <script>
            function cancelFunction() {
              alert("Anulowałeś rezerwację!");
            }
          </script>
  </body>
</html>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "carrental");

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error);
  }

$sql = "SELECT id FROM klient ORDER BY `id` DESC LIMIT 1";
$result = $conn->query($sql);
$last_id = null;
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
        $last_id = $row['id'];

    }
  } else {
    echo "sss"; 
  }

$id_pracownika = 1;
$id_pakietu = 1;
$wybrany_samochod =  $_SESSION['id_wybrany_samochod'];
$data_wydania = $_SESSION['data_wydania'];
$data_odbioru = $_SESSION['data_odbioru'];
$rabat = 1;
$cena_pakiet = null;

$stmt = $conn->prepare("insert into rezerwacja (data_wypozyczenia, data_zwrotu, id_klienta, id_pakietu, id_pracownika, id_samochodu, rabat) values(?, ?, ?, ?,?,?,?)");
$stmt->bind_param("sssssss", $data_wydania, $data_odbioru, $last_id, $id_pakietu, $id_pracownika, $wybrany_samochod, $rabat);
$execval = $stmt->execute();
$stmt->close();

$sql = "SELECT cena FROM segment WHERE id = (SELECT id_segment FROM samochod WHERE id =(SELECT id_samochodu FROM rezerwacja WHERE id_rezerwacji = (SELECT id_rezerwacji FROM rezerwacja ORDER BY `id_rezerwacji` DESC LIMIT 1)))";
$result = $conn->query($sql);
$cena_segment = null;
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
        $cena_segment = $row['cena'];
    }
} else {
  echo "sss"; 
}

$sql = "SELECT DATEDIFF((SELECT data_zwrotu FROM rezerwacja ORDER BY id_rezerwacji DESC LIMIT 1), (SELECT data_wypozyczenia FROM rezerwacja ORDER BY id_rezerwacji DESC LIMIT 1))as okres";
$result = $conn->query($sql);
$okres = null;
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) {
        $okres = $row['okres'];
    }
} else {
  echo "sss"; 
}

$total = ($cena_pakiet + $cena_segment)*$okres;


if(isset($_POST['button'])){
    header("Location: ../index.html");
}


$conn->close();
?>

<html>
  <head>
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
            flex-direction: column;
        }

        div {
          display: flex;
          flex-direction: column;
        }

        form {
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

        .cancel {
          text-decoration: none;
          text-transform: uppercase;
          color: blue;
        }


    </style>
  </head>
  <body>
            <p>
              <label>Do zapłaty będzie: <?php echo $total?> PLN</label>
            </p>
            <form method="post">
              <input type = "submit" name = 'button' value="zatwierdź" class="button" onclick="alertFunction();">
            </form>
            <a href="../index.html" class="cancel" onclick="cancelFunction();">anuluj</a>
            
          <script>
            function alertFunction() {
                alert("Twoja rezerwacja przebiegła pomyślnie!");
            }

            function cancelFunction() {
              alert("Anulowałeś rezerwację!");
            }
          </script>
  </body>
</html>
<!DOCTYPE html>
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "carrental");

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error);
  }
$query = null;
$count = null;
if(isset($_POST['search'])){
    $txtStarDate=$_POST['txtStarDate'];
    $txtEndDate =$_POST['txtEndDate'];
    $query = mysqli_query($conn,"SELECT * FROM (SELECT * FROM samochod WHERE data_sprzedazy >'$txtEndDate' AND id_segment = 2)z LEFT JOIN (SELECT * FROM rezerwacja WHERE data_zwrotu<'$txtStarDate' OR data_wypozyczenia>'$txtEndDate')x ON x.id_samochodu = z.id");
    $count = mysqli_num_rows($query);
    $_SESSION['data_wydania'] = $txtStarDate;
    $_SESSION['data_odbioru'] = $txtEndDate;
}
if(isset($_POST['button'])){
    header("Location: segment_b_1.php");
}
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
            text-transform: uppercase;
            width: 100%;
            margin-bottom: 16px;
        }

        .button {
          margin-top: 32px;
          height: 40px;
          width: 100%;  
          border: none;
          border-radius: 50px;
          background: #a73e3e;
          box-shadow:  -3px -3px 10px #8e3535ab, 
            3px 3px 10px #c047477a;
          text-transform: uppercase;
          color: #FFF;
        }

        main {
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
        }

        .cancel {
            margin-top: 32px;
          text-decoration: none;
          text-transform: uppercase;
          color: blue;
        }


    </style>
</head>
<body>
    <main>
        <form method="post">
            <input type="date" name="txtStarDate">
            <input type="date" name="txtEndDate">
            
            <input type="submit" name="search" value="wyszukaj auto" class="button">
            

            <?php
            $select= '<select name="select">';
            if($count == null)
            {
                echo $select;
            }
            else
            {
                while($row = mysqli_fetch_array($query))
                {
                    $select.='<option value="'.$row['id'].'">'.$row['marka']." ".$row['model'].'</option>';
                }
                echo $select;
                
                
            }
            
            $_SESSION['id_wybrany_samochod'] = $_POST['select'];
            ?>
        <input type="submit" name="button" value="dalej" class="button">
        </form>
        <a href="../renting.html" class="cancel">Wróć</a>
    </main>
</body>
</html>



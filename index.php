<?php
global $db;
include "db/mysql.php"; // Assuming this file correctly establishes a database connection

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form is submitted and handle the input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentName = $_POST["studentName"];

    // Načítanie dát z tabuliek ev.ziak a ev.rpj pre zvoleného študenta
    $sql = "SELECT z.*, r.* FROM ev.ziak z
            LEFT JOIN ev.rpj r ON z.ziakID = r.ziakID
            WHERE CONCAT(z.meno, ' ', z.priezvisko) = '$studentName'";
    $result = mysqli_query($db, $sql);

    if (!$result) {
        die("Query nefunguje: " . mysqli_error($db));
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>nazov</title>
</head>
<body>
<header>
</header>
<div>
    <h1>Student Data</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="studentName">Enter student name:</label>
        <input type="text" id="studentName" name="studentName">
        <button type="submit">Search</button>
    </form>

    <?php
    // Check if the form is submitted and display the data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Ziak ID</th><th>Meno</th><th>Priezvisko</th><th>RPJ ID</th><th>Nazov</th><th>Odbor</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                // Vypisovanie do HTML tabuľky
                echo "<tr>";
                echo "<td>" . $row["ziakID"] . "</td>";
                echo "<td>" . $row["meno"] . "</td>";
                echo "<td>" . $row["priezvisko"] . "</td>";
                echo "<td>" . $row["rpjID"] . "</td>";
                echo "<td>" . $row["nazov"] . "</td>";
                echo "<td>" . $row["odbor"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Žiadny výsledok pre zadaného študenta.";
        }
    }
    ?>
</div>
</body>
</html>

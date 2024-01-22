<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded</title>
</head>

<body>
    <div>
        <div>
            <div>
                <div role="alert">
                    <strong>Csv File Uploaded</strong>, Click the button to go back and generate a new csv file if you like.
                </div>
            </div>
            <div> <button type="button" onclick="history.back();">Back</button></div>
        </div>
    </div>
</body>

</html>
<?php
require 'vendor/autoload.php';

try {
    $db = new SQLite3("test.db");
    set_time_limit(0);
    $file = fopen("./output/output.csv", "r");

    function tableExists($db, $tableName)
    {
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$tableName'");
        return $result->fetchArray() !== false;
    }

    if (!tableExists($db, 'csv_import')) {
        $query = "CREATE TABLE csv_import(id INTEGER PRIMARY KEY, name TEXT, surname TEXT, initials TEXT, age INT, dateOfBirth TEXT)";
        $db->exec($query);
    }

    $db->exec('BEGIN');
    $query = $db->prepare("INSERT INTO csv_import(name, surname, initials, age, dateOfBirth) VALUES(:name, :surname, :initials, :age, :dateOfBirth)");
    $query->bindParam(':name', $name, SQLITE3_TEXT);
    $query->bindParam(':surname', $surname, SQLITE3_TEXT);
    $query->bindParam(':initials', $initials, SQLITE3_TEXT);
    $query->bindParam(':age', $age, SQLITE3_INTEGER);
    $query->bindParam(':dateOfBirth', $dateOfBirth, SQLITE3_TEXT);

    $rows = 0;

    while (($row = fgetcsv($file, 1000000, ',')) !== false) {

        if ($rows === 0) {
            $rows++;
            continue;
        }

        // Check if the row has enough elements before attempting to access them
        if (count($row) < 6) {
            // Handle the case where the row doesn't have enough elements
            // You might log an error, skip the row, or handle it in another way
            continue;
        }

        list($id, $name, $surname, $initials, $age, $dateOfBirth) = $row;
        $query->execute();
        $rows++;
    }

    $db->exec('COMMIT');

    fclose($file);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();

    if (isset($db)) {
        $db->exec('ROLLBACK'); // Roll back changes if an error occurs
        $db->close(); // Close the database connection
    }
} finally {
        $db->close(); 
}
?>
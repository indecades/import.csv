<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated</title>
</head>

<body>
    <div>
        <div>
            <div>
                <div class="alert alert-success alert-dismissible fade show align-self-end d-flex" role="alert">
                    <strong>Users Generated</strong>, go back to upload the generated CSV
                </div>
            </div>
            <div>
                <button type="button" onclick="history.back();" class="btn btn-success">Back</button>
            </div>
        </div>
    </div>
</body>

</html>

<?php
require 'vendor/autoload.php';
$headers = ["id", "Firstname", "Surname", "Intials", "Age", "DateOfBirth"];
$myFile = fopen("./output/output.csv", "w") or die("Unable to open file!");
fputcsv($myFile, $headers);
//array of names
$names = [
    'Potter',
    'Malfoy',
    'Lovegood',
    'Diggle',
    'Podmore',
    'Peakes',
    'Weasley',
    'Prang',
    'Patil',
    'Lockhart',
    'Malkin',
    'Boot',
    'Umbringe',
    'Travers',
    'Jones',
    'Yaxley',
    'Vane',
    'Wood',
    'Corner'
];
// array of surnames
$surnames = [
    'Hagrid',
    'Hufflepuff',
    'Moran',
    'Sprout',
    'Flamel',
    'Quirell',
    'Fudge',
    'Hopkirk',
    'Cresswell',
    'Lynch',
    'Polkiss',
    'Tonks',
    'Snape',
    'Maxime',
    'Delacour',
    'Pince',
    'Greyback',
    'Bell',
    'Moody',
    'Warrington'
];

$userInputNumber = $_POST["amount"];
$insertDataIntoArray[] = [];

function createCsvFile($userInputNumber, $names, $surnames, $insertDataIntoArray, $myFile)
{

    for ($id = 1; $id < $userInputNumber + 1; $id++) {
        $randomName = $names[array_rand($names)];
        $randomSurname = $surnames[array_rand($surnames)];
        $randomDate = mt_rand(strtotime('1950-01-01'), time());
        $dateTime = new DateTime();
        $dateTime->setTimestamp($randomDate);
        $randomYear = $dateTime->format("Y");
        $date = $dateTime->format("d/m/Y");
        $year = date('Y');
        $age = $year - $randomYear;
        $initials = substr($randomName, 0, 1);

        $insertDataIntoArray[] = ["id" => $id, "name" => $randomName, "surname" => $randomSurname, "initials" => $initials, "age" => $age, "dateOfBirth" => $date];
    }

    foreach ($insertDataIntoArray as $fields) {
        fputcsv($myFile, $fields, ",");
    }
}

createCsvFile($userInputNumber, $names, $surnames, $insertDataIntoArray, $myFile);
fclose($myFile);
?>
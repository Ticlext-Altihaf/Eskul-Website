<?php


require_once 'vendor/autoload.php';
use Aspera\Spreadsheet\XLSX\Reader;

$faker = Faker\Factory::create( 'id_ID' );
// generate data by calling methods
echo $faker->name();
echo "\n";
$reader = new Reader();
$reader->open('dataeskul.xlsx');
foreach ($reader as $row) {
    //remove new line
    $row = array_map('trim', $row);
    //comma separated values
    $csv = implode(',', $row);
    print_r($csv);
}
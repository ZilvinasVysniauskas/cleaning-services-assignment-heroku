<?php

namespace CleaningApp\Controllers;

use Common\DatabaseTable;

class AdminPagesController
{
    private $userReservationTable;

    public function __construct(DatabaseTable $userReservationTable)
    {
        $this->userReservationTable = $userReservationTable;

    }
    public function mainPage(){
        return [
            'title' => 'admin home page',
            'templates' => [
                'adminLogged' => ['template' => 'adminLogged.html.php'],
                'output' => ['template' => 'adminMainPage.html.php']
            ]
        ];
    }

    public function getRecordsFromDb($column, $value){
        $condition = [$column => $value];
        $selectedData = $this->userReservationTable->selectDataFromDb('time',
            'ASC', $condition);
        return $selectedData;
    }

    public function downloadChoice($errors = null){
        return [
            'title' => 'download data',
            'templates' => [
                'adminLogged' => ['template' => 'adminLogged.html.php'],
                'output' => ['template' => 'downloadChoice.html.php', 'variables' => ['errors' => $errors] ?? null]
            ]
        ];
    }

    public function downloadCsv(){
        $errors = [];
        $valid = true;
        $data = [];
        if ($_POST['dateRange'] === 'showInputs'){
            if (strtotime($_POST['dateFrom']) > strtotime($_POST['dateTo'])){
                $errors[] = 'Start date cannot be greater end date';
                $valid = false;
            }
            $data['date'] = [$_POST['dateFrom'], $_POST['dateTo']];
        }else {
            $data = null;
        }
        if ($_POST['timeRange'] === 'showInputs'){
            if ($_POST['timeFrom'] > $_POST['timeTo']){
                $errors[] = 'Start time cannot be greater end time';
                $valid = false;
            }
            $data['time'] = [$_POST['timeFrom'], $_POST['timeTo']];
        }
        if($valid) {
            $selectedData = $this->userReservationTable->selectDataFromDb
            ($orderBy = null, $ascOrDesc = null, $condition = $data);
            $arr = [];
            $arr[] = ['name', 'email', 'phone number', 'apartment_address', 'date', 'time'];
            foreach ($selectedData as $record){
                $arr[] = [$record['name'], $record['email'], $record['phone_number'],
                    $record['apartment_address'], $record['date'], $record['time'] . ':00'];
            }
            $file = fopen('./files/records.csv' , 'w');
            foreach ($arr as $csvLine){
                fputcsv($file, $csvLine);
            }
            fclose($file);


            $filename = './files/records.csv';

            if (file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                readfile($filename);
            }
            unlink($filename);
            return $this->downloadChoice();
        }
        else {
            return $this->downloadChoice($errors);
        }
    }

    public function importRecordsDisplay($message = null){
        return [
            'title' => 'import records',
            'templates' => [
                'adminLogged' => ['template' => 'adminLogged.html.php'],
                'output' => ['template' => 'importRecords.html.php', 'variables' => [
                    'messages' => $message] ?? null]
            ]
        ];
    }

    public function importRecords(){
        $tmpName = $_FILES['csv']['tmp_name'];
        $csvArr = array_map('str_getcsv', file($tmpName));
        unset($csvArr[0]);
        foreach ($csvArr as $record){
            $data = ['name' => $record[0], 'email' => $record[1], 'phone_number' => $record[2],
                'apartment_address' => $record[3], 'date' => $record[4], 'time' => substr($record[5], 0, 1)];
            $this->userReservationTable->insertIntoDb($data);
        }
        return $this->importRecordsDisplay(['import successful']);
    }
}
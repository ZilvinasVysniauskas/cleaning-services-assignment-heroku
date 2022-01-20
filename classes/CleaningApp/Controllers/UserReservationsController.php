<?php

namespace CleaningApp\Controllers;

use Common\Authentication;
use Common\DatabaseTable;

class UserReservationsController
{
    private $userReservationTable;
    private $dateNow;
    private $authentication;

    public function __construct(DatabaseTable $userReservationTable, Authentication $authentication)
    {
        $this->userReservationTable = $userReservationTable;
        $this->dateNow = (new \DateTime())->add(\DateInterval::createFromDateString('1 day'));
        $this->authentication = $authentication;
    }

    public function displayReservationForm(){
        if ($this->authentication->isLogged()){
            return [
                'title' => 'admin add record',
                'templates' => [
                    'output' => ['template' => 'makeReservation.html.php', 'variables' =>
                        ['dateNow' => $this->dateNow->format('Y-m-d')]],
                    'adminLogged' => ['template' => 'adminLogged.html.php']
                ]
            ];
        }
        return [
            'title' => 'Place Reservation',
            'templates' => [
                'output' => ['template' => 'makeReservation.html.php', 'variables' =>
                    ['dateNow' => $this->dateNow->format('Y-m-d')]]
            ]
        ];


    }

    private function validatePhoneNumber($number){
        if (substr($number, 0, 4) === '+370'){
           return (strlen($number) === 12);
        }
        elseif (substr($number, 0, 2) === '86'){
            return (strlen($number) === 9);
        }
        return false;
    }

    public function addReservation(){
        $clientName = htmlentities($_POST['clientName'], ENT_QUOTES, 'UTF-8');
        $clientEmail = htmlentities($_POST['clientEmail'], ENT_QUOTES, 'UTF-8');
        $clientPhoneNumber = htmlentities($_POST['clientPhoneNumber'], ENT_QUOTES, 'UTF-8');
        $clientApartmentAddress = htmlentities($_POST['clientApartmentAddress'], ENT_QUOTES, 'UTF-8');
        $dateOfReservation = htmlentities($_POST['dateOfReservation'], ENT_QUOTES, 'UTF-8');
        $timeOfReservation = htmlentities($_POST['timeOfReservation'], ENT_QUOTES, 'UTF-8');

        $valid = true;
        $errors = [];

        if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)){
            $valid = false;
            $errors[] = 'invalid email address';
        }
        if (!$this->validatePhoneNumber($clientPhoneNumber)){
            $valid = false;
            $errors[] = 'invalid phone number';
        }
        if ($valid){
            $data = ['name' => $clientName, 'email' => $clientEmail, 'phone_number' => $clientPhoneNumber,
                'apartment_address' => $clientApartmentAddress, 'date' => $dateOfReservation, 'time' => $timeOfReservation];
            $this->userReservationTable->insertIntoDb($data);
            if ($this->authentication->isLogged()){
                return [
                    'title' => 'Amin add record',
                    'templates' => [
                        'output' => ['template' => 'makeReservation.html.php', 'variables' => ['dateNow' =>
                            $this->dateNow->format('Y-m-d'), 'message' => 'record added successfully']],
                        'adminLogged' => ['template' => 'adminLogged.html.php']
                    ]
                ];
            }
            return [
                'title' => 'Place Reservation',
                'templates' => [
                    'output' => ['template' => 'makeReservation.html.php', 'variables' => ['dateNow' =>
                        $this->dateNow->format('Y-m-d'), 'message' => 'registration successful']]
                ]
            ];
        }
        else{
            //TODO do so values would stay after invalid enter
            if ($this->authentication->isLogged()){
                return [
                    'title' => 'Place Reservation',
                    'templates' => [
                        'output' => ['template' => 'makeReservation.html.php', 'variables' => ['dateNow' =>
                            $this->dateNow->format('Y-m-d'), 'errors' => $errors]],
                        'adminLogged' => ['template' => 'adminLogged.html.php']
                    ]
                ];
            }
            return [
                'title' => 'Place Reservation',
                'templates' => [
                    'output' => ['template' => 'makeReservation.html.php', 'variables' => ['dateNow' =>
                        $this->dateNow->format('Y-m-d'), 'errors' => $errors]]
                ]
            ];
        }
    }

}
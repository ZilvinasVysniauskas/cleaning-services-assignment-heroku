<?php

namespace CleaningApp;
use CleaningApp\Controllers\AdminLoginController;
use CleaningApp\Controllers\AdminPagesController;
use Common\Authentication;
use Common\DatabaseTable;
use CleaningApp\Controllers\UserReservationsController;

class CleaningRoutes
{
    private $userReservationTable;
    private $adminLoginDetailsTable;


    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';
        $this->userReservationTable = new DatabaseTable($pdo, 'user_reservations', 'id');
        $this->adminLoginDetailsTable = new DatabaseTable($pdo, 'admin_login', 'admin_name');
    }

    public function getRoutes(){
        $authentication = new Authentication($this->adminLoginDetailsTable, 'admin_name',
        'admin_password');
        $userReservationController = new UserReservationsController($this->userReservationTable, $authentication);
        $adminLoginController = new AdminLoginController($this->adminLoginDetailsTable, $authentication);
        $adminPagesController = new AdminPagesController($this->userReservationTable);
        //TODO add condition when admin is set;
        if (!$authentication->isLogged()){
            $routes = [
                '' => [
                    'GET' => [
                        'controller' => $userReservationController,
                        'action' => 'displayReservationForm'
                    ],
                    'POST' => [
                        'controller' => $userReservationController,
                        'action' => 'addReservation'
                    ]
                ],
                'admin' => [
                    'GET' => [
                        'controller' => $adminLoginController,
                        'action' => 'loginPage'
                    ],
                    'POST' => [
                        'controller' => $adminLoginController,
                        'action' => 'checkAdminLogDetails'
                    ]
                ]
            ];
        }
        else {
            $routes = [
                '' => [
                    'GET' => [
                        'controller' => $adminPagesController,
                        'action' => 'mainPage'
                    ]
                ],
                'addrecord' => [
                    'GET' => [
                        'controller' => $userReservationController,
                        'action' => 'displayReservationForm'
                    ],
                    'POST' => [
                        'controller' => $userReservationController,
                        'action' => 'addReservation'
                    ]
                ],
                'changelogdetails' => [
                    'GET' => [
                        'controller' => $adminLoginController,
                        'action' => 'changeLoginInformationDisplay'
                    ],
                    'POST' => [
                        'controller' => $adminLoginController,
                        'action' => 'changeLoginInformation'
                    ]
                ],
                'logout' => [
                    'GET' => [
                        'controller' => $adminLoginController,
                        'action'  => 'logout'
                    ]
                ],
                'downloadrecords' => [
                    'GET' => [
                        'controller' => $adminPagesController,
                        'action' => 'downloadChoice'
                    ],
                    'POST' => [
                        'controller' => $adminPagesController,
                        'action' => 'downloadCsv'
                    ]
                ],
                'importrecords' => [
                    'GET' => [
                        'controller' => $adminPagesController,
                        'action' => 'importRecordsDisplay'
                    ],
                    'POST' => [
                        'controller' => $adminPagesController,
                        'action' => 'importRecords'
                    ]
                ]
            ];
        }
        return $routes;
    }

}
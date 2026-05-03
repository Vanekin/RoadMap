<?php

namespace RoadMap\Controllers;

use RoadMap\Core\Controller;
use RoadMap\Models\Incident;
use RoadMap\Core\Attributes\Route;

class IncidentController extends Controller
{
    private Incident $incidentModel;
    public function __construct($router)
    {
        parent::__construct($router);
        $this->incidentModel = new Incident();
    }
    #[Route('/incidents', method: 'GET')]
    public function index(): void
    {
        $incidents = $this->incidentModel->getAll();

        $this->render('incidentsIndex', [
            'pageTitle' => 'Все происшествия',
            'incidents' => $incidents
        ]);
    }
    #[Route('/incidents/create', method: 'GET')]
    public function create(): void
    {
        $this->render('incidentsCreate', [
            'pageTitle' => 'Добавить происшествие'
        ]);
    }
    #[Route('/incidents/store', method: 'POST')]
    public function store(): void
    {
        $method = $this->getMethod();
        if ($method !== 'POST') {
            $this->redirect('/incidents/create');
            return;
        }

        $title = $this->getRequestParams()['title'];
        $description = $this->getRequestParams()['description'];
        $address = $this->getRequestParams()['address'];
        $latitude = (float) $this->getRequestParams()['latitude'];
        $longitude = (float) $this->getRequestParams()['longitude'];

        $id = $this->incidentModel->create($title, $description, $latitude, $longitude, $address);

        $this->render('incidentsStore', [
            'pageTitle' => 'Происшествие добавлено',
            'title' => $title,
            'description' => $description,
            'address' => $address
        ]);
    }
}

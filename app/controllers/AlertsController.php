<?php
class AlertsController {
    private $aquariumModel;
    private $terrariumModel;

    public function __construct() {
        $this->aquariumModel = new Aquarium();
        $this->terrariumModel = new Terrarium();
    }

    public function index() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }

        $userId = Session::getUserId();
        $aquariumAlerts = $this->aquariumModel->getMaintenanceAlerts($userId);
        $terrariumAlerts = $this->terrariumModel->getMaintenanceAlerts($userId);

        $pageTitle = 'Notificaciones y Alertas';
        $contentView = BASE_PATH . '/app/views/alerts/index-content.php';
        require BASE_PATH . '/app/views/alerts/index.php';
    }
}

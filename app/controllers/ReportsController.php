<?php
class ReportsController {
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
        $pageTitle = 'Exportar y Reportes';
        $contentView = BASE_PATH . '/app/views/reports/index-content.php';
        require BASE_PATH . '/app/views/reports/index.php';
    }

    public function exportAquariumsCSV() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }
        $userId = Session::getUserId();
        $data = $this->aquariumModel->getByUser($userId);
        $this->sendCsv('acuarios.csv', ['ID','Nombre','Tipo','Volumen(L)','Estado','Creado'], array_map(function($a){
            return [$a['id'],$a['name'],$a['type'],$a['volume_liters'],$a['status'],$a['created_at']];
        }, $data));
    }

    public function exportTerrariumsCSV() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }
        $userId = Session::getUserId();
        $this->terrariumModel; // ensure model is loaded
        $data = $this->terrariumModel->getByUser($userId);
        $this->sendCsv('terrarios.csv', ['ID','Nombre','Tipo','Volumen(L)','Humedad(%)','Temp Min','Temp Max','Estado','Creado'], array_map(function($t){
            return [$t['id'],$t['name'],$t['type'],$t['volume_liters'],$t['humidity_level'],$t['temperature_min'],$t['temperature_max'],$t['status'],$t['created_at']];
        }, $data));
    }

    public function exportMaintenanceCSV() {
        if (!Session::isLogged()) {
            Response::unauthorized();
        }
        $userId = Session::getUserId();
        $aq = $this->aquariumModel->getAllMaintenanceByUser($userId);
        $tt = $this->terrariumModel->getAllMaintenance($userId);
        $rows = [];
        foreach ($aq as $m) {
            $rows[] = ['acuario', $m['aquarium_id'], $m['aquarium_name'], $m['log_type'], $m['description'], $m['percentage'] ?? '', $m['reminder_enabled'] ? 'sí' : 'no', $m['reminder_days'] ?? '', $m['reminder_next_at'] ?? '', $m['created_at']];
        }
        foreach ($tt as $m) {
            $rows[] = ['terrario', $m['terrarium_id'], $m['terrarium_name'], $m['log_type'], $m['description'], '', $m['reminder_enabled'] ? 'sí' : 'no', $m['reminder_days'] ?? '', '', $m['created_at']];
        }
        $this->sendCsv('mantenimientos.csv', ['Módulo','ID','Nombre','Tipo registro','Descripción','% Agua','Recordatorio','Días','Próximo','Fecha'], $rows);
    }

    private function sendCsv($filename, $headers, $rows) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
        fputcsv($output, $headers);
        foreach ($rows as $row) { fputcsv($output, $row); }
        fclose($output);
        exit;
    }
}

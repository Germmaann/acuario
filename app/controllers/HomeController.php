<?php
/**
 * HomeController
 */
class HomeController {
    
    public function index() {
        // Obtener últimos peces
        $fishModel = new Fish();
        $latestFish = $fishModel->getLatest(6);
        
        // Obtener últimos acuarios
        $aquariumModel = new Aquarium();
        $latestAquariums = $aquariumModel->getLatestPublic(6);
        
        // Obtener últimos terrarios
        $terrariumModel = new Terrarium();
        $latestTerrariums = $terrariumModel->getLatestPublic(6);
        
        // Obtener últimos artículos
        $articleModel = new Article();
        $latestArticles = $articleModel->getLatest(3);
        
        // Renderizar vista con variables
        require_once BASE_PATH . '/app/lib/ViewHelper.php';
        $variables = [
            'latestFish' => $latestFish,
            'latestAquariums' => $latestAquariums,
            'latestTerrariums' => $latestTerrariums,
            'latestArticles' => $latestArticles,
            'contentView' => BASE_PATH . '/app/views/home/index-content.php'
        ];
        
        // Extraer variables al scope global para que main.php y su incluido las vea
        extract($variables, EXTR_OVERWRITE);
        
        require BASE_PATH . '/app/views/layouts/main.php';
    }
}

<?php
/**
 * Helper para incluir vistas con variables
 */

function includeView($viewPath, $variables = []) {
    extract($variables, EXTR_OVERWRITE);
    require $viewPath;
}

?>

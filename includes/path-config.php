<?php
/**
 * Configuração de caminhos - Brasil Center
 * Detecta automaticamente se está na raiz ou em subpasta
 */

// Detectar o caminho base automaticamente
function get_base_path() {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // Remover o nome do arquivo do script
    $basePath = dirname($scriptName);
    
    // Se estiver na raiz, retorna apenas "/"
    if ($basePath === '/' || $basePath === '\\') {
        return '/';
    }
    
    // Garantir que termine com /
    return rtrim($basePath, '/') . '/';
}

// Função para gerar URLs corretas
function asset_url($path) {
    $basePath = get_base_path();
    $cleanPath = ltrim($path, '/');
    return $basePath . $cleanPath;
}

// Função para URLs de páginas
function page_url($path = '') {
    $basePath = get_base_path();
    if (empty($path)) {
        return $basePath;
    }
    $cleanPath = ltrim($path, '/');
    return $basePath . $cleanPath;
}

// Definir constantes globais
define('BASE_PATH', get_base_path());
define('ASSETS_URL', BASE_PATH);

// Debug (remover em produção)
if (isset($_GET['debug_paths'])) {
    echo "<pre>";
    echo "SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "\n";
    echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "\n";
    echo "BASE_PATH: " . BASE_PATH . "\n";
    echo "ASSETS_URL: " . ASSETS_URL . "\n";
    echo "</pre>";
    exit;
}
?>

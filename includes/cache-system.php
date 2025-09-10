<?php
/**
 * Sistema de Cache Simples - Brasil Center
 * Cache em arquivo para consultas GraphQL e dados pesados
 */

class SimpleCache {
    private $cacheDir;
    private $defaultTTL;
    
    public function __construct($cacheDir = 'cache', $defaultTTL = 3600) {
        $this->cacheDir = __DIR__ . '/../' . $cacheDir;
        $this->defaultTTL = $defaultTTL;
        
        // Criar diretório de cache se não existir
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
        
        // Criar arquivo .htaccess para proteger o cache
        $htaccessPath = $this->cacheDir . '/.htaccess';
        if (!file_exists($htaccessPath)) {
            file_put_contents($htaccessPath, "Deny from all\n");
        }
    }
    
    /**
     * Gerar chave de cache segura
     */
    private function getCacheKey($key) {
        return md5($key);
    }
    
    /**
     * Obter caminho do arquivo de cache
     */
    private function getCachePath($key) {
        return $this->cacheDir . '/' . $this->getCacheKey($key) . '.cache';
    }
    
    /**
     * Verificar se cache existe e é válido
     */
    public function has($key, $ttl = null) {
        $ttl = $ttl ?? $this->defaultTTL;
        $cachePath = $this->getCachePath($key);
        
        if (!file_exists($cachePath)) {
            return false;
        }
        
        $cacheTime = filemtime($cachePath);
        return (time() - $cacheTime) < $ttl;
    }
    
    /**
     * Obter dados do cache
     */
    public function get($key, $ttl = null) {
        if (!$this->has($key, $ttl)) {
            return null;
        }
        
        $cachePath = $this->getCachePath($key);
        $data = file_get_contents($cachePath);
        
        return $data ? unserialize($data) : null;
    }
    
    /**
     * Salvar dados no cache
     */
    public function set($key, $data, $ttl = null) {
        $cachePath = $this->getCachePath($key);
        $serializedData = serialize($data);
        
        return file_put_contents($cachePath, $serializedData, LOCK_EX) !== false;
    }
    
    /**
     * Remover item do cache
     */
    public function delete($key) {
        $cachePath = $this->getCachePath($key);
        if (file_exists($cachePath)) {
            return unlink($cachePath);
        }
        return true;
    }
    
    /**
     * Limpar cache expirado
     */
    public function cleanup($maxAge = 86400) { // 24 horas por padrão
        $files = glob($this->cacheDir . '/*.cache');
        $cleaned = 0;
        
        foreach ($files as $file) {
            if (time() - filemtime($file) > $maxAge) {
                if (unlink($file)) {
                    $cleaned++;
                }
            }
        }
        
        return $cleaned;
    }
    
    /**
     * Limpar todo o cache
     */
    public function clear() {
        $files = glob($this->cacheDir . '/*.cache');
        $cleared = 0;
        
        foreach ($files as $file) {
            if (unlink($file)) {
                $cleared++;
            }
        }
        
        return $cleared;
    }
}

// Instância global do cache
$GLOBALS['cache'] = new SimpleCache('cache', 1800); // 30 minutos de cache

/**
 * Função helper para usar o cache
 */
function get_cached($key, $callback, $ttl = null) {
    $cache = $GLOBALS['cache'];
    
    // Tentar obter do cache primeiro
    $data = $cache->get($key, $ttl);
    if ($data !== null) {
        return $data;
    }
    
    // Se não estiver no cache, executar callback
    $data = $callback();
    
    // Salvar no cache
    if ($data !== null) {
        $cache->set($key, $data, $ttl);
    }
    
    return $data;
}

/**
 * Limpar cache automaticamente (1% de chance a cada request)
 */
if (rand(1, 100) === 1) {
    $GLOBALS['cache']->cleanup();
}
?>












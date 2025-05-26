<?php
class MetaPreview
{
    protected $cacheTtl = 86400; // 24h

    public function fetch(string $url): array
    {
        $key = 'preview:' . md5($url);
        
        // Intenta caché (si APCu está instalado)
        if (function_exists('apcu_fetch') && $cached = apcu_fetch($key)) {
            return $cached;
        }

        // Fetch y parseo con manejo de errores
        try {
            $html = $this->httpGet($url);
            
            if (empty($html)) {
                throw new Exception("No se pudo obtener el contenido de la URL");
            }
            
            $data = $this->parseMeta($html, $url);
            
            // Guarda en caché si APCu está disponible
            if (function_exists('apcu_store')) {
                apcu_store($key, $data, $this->cacheTtl);
            }
            
            return $data;
            
        } catch (Exception $e) {
            // Retorna datos básicos si hay error
            return [
                'title' => 'Error al cargar el sitio',
                'description' => 'No se pudo obtener información de: ' . $url,
                'image' => '',
                'url' => $url
            ];
        }
    }

    protected function httpGet(string $url): string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; MetaPreviewBot/1.0)'
        ]);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html ?: '';
    }

    protected function parseMeta(string $html, string $url): array
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        @$doc->loadHTML($html); // Silenciamos errores de HTML mal formado
        libxml_clear_errors();
        
        $xp = new DOMXPath($doc);
        $get = fn($k) => $this->getMeta($xp, $k) ?? '';

        // Intenta obtener el título de diferentes formas
        $title = $get('title');
        if (empty($title)) {
            $titleNodes = $doc->getElementsByTagName('title');
            $title = $titleNodes->length > 0 ? $titleNodes->item(0)->textContent : 'Sin título';
        }

        return [
            'title' => trim($title),
            'description' => trim($get('description')),
            'image' => trim($get('image')),
            'url' => $url
        ];
    }

    protected function getMeta(DOMXPath $xp, string $key): ?string
    {
        $m = $xp->query("//meta[@property='og:$key']|//meta[@name='$key']|//meta[@property='twitter:$key']");
        return $m->length ? $m->item(0)->getAttribute('content') : null;
    }
}
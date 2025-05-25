<?php
// src/MetaPreview.php
class MetaPreview
{
    protected $cacheTtl = 86400; // 24h

    //public function fetch(string $url): array
    //{
    //    $key = 'preview:' . md5($url);
    //    // 1) Intenta caché
    //    if ($cached = apcu_fetch($key)) {
    //        return $cached;
    //    }

    //    // 2) Fetch y parseo
    //    $html = $this->httpGet($url);
    //    $data = $this->parseMeta($html, $url);

    //    // 3) Guárdalo en caché
    //    apcu_store($key, $data, $this->cacheTtl);

    //    return $data;
    //}

	 public function fetch(string $url): array
    {
        // Eliminamos la parte del caché
        $html = $this->httpGet($url);
        return $this->parseMeta($html, $url);
    }

    protected function httpGet(string $url): string
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => 5,
        ]);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html ?: '';
    }

    protected function parseMeta(string $html, string $url): array
    {
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadHTML($html);
        libxml_clear_errors();
        $xp = new DOMXPath($doc);
        $get = fn($k) => $this->getMeta($xp,$k) ?? '';

        return [
            'title'       => $get('title') ?: $doc->getElementsByTagName('title')->item(0)->textContent ?? '',
            'description' => $get('description'),
            'image'       => $get('image'),
            'url'         => $url,
        ];
    }

    protected function getMeta(DOMXPath $xp, string $key): ?string
    {
        $m = $xp->query("//meta[@property='og:$key']|//meta[@name='$key']");
        return $m->length ? $m->item(0)->getAttribute('content') : null;
    }
}
?>
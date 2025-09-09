<?php
header("Content-Type: application/json; charset=UTF-8");

$site = $_GET['site'] ?? null;

if (!$site) {
    echo json_encode(["error" => true, "message" => "No se proporcionó el parámetro 'site'."]);
    exit;
}

if (!filter_var($site, FILTER_VALIDATE_URL)) {
    echo json_encode(["error" => true, "message" => "La URL no es válida."]);
    exit;
}

// Descargar con cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MetaPreviewBot/1.0)");

$html = curl_exec($ch);
curl_close($ch);

if ($html === false || empty($html)) {
    echo json_encode(["error" => true, "message" => "No se pudo obtener contenido de la URL."]);
    exit;
}

// Parsear HTML
libxml_use_internal_errors(true);
$doc = new DOMDocument();
@$doc->loadHTML($html);
$xpath = new DOMXPath($doc);

// Helper para metas
function getMeta($xpath, $query) {
    $nodes = $xpath->query($query);
    return $nodes->length > 0 ? trim($nodes->item(0)->getAttribute("content")) : null;
}

// Title
$title = null;
$nodes = $xpath->query("//title");
if ($nodes->length > 0) {
    $title = trim($nodes->item(0)->nodeValue);
}
if (!$title) $title = getMeta($xpath, "//meta[@property='og:title']");
if (!$title) $title = getMeta($xpath, "//meta[@name='twitter:title']");

// Description
$description = getMeta($xpath, "//meta[@name='description']");
if (!$description) $description = getMeta($xpath, "//meta[@property='og:description']");
if (!$description) $description = getMeta($xpath, "//meta[@name='twitter:description']");

// Image
$image = getMeta($xpath, "//meta[@property='og:image']");
if (!$image) $image = getMeta($xpath, "//meta[@name='twitter:image']");

$response = [
    "error" => false,
    "url" => $site,
    "title" => $title ?: "Sin título",
    "description" => $description ?: "Sin descripción",
    "image" => $image
];

echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

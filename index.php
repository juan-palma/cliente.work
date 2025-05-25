<?php
require 'src/MetaPreview.php';

// 1. CONFIGURACIÓN SIMPLE - SOLO EDITA ESTE ARRAY CON TUS URLs
$mis_sitios = [
    'https://sca.cliente.work',
    'https://ejemplo.com',
    'https://otro-sitio.com'
    // ¡Simplemente añade más URLs aquí!
];

// 2. Obtenemos los meta datos
$preview = new MetaPreview();
$previews = [];
foreach ($mis_sitios as $url) {
    $previews[] = $preview->fetch($url);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio de Sitios Web</title>
    <style>
        :root {
            --card-bg: #fff;
            --text-primary: #1d2129;
            --text-secondary: #606770;
            --border-color: #dddfe2;
            --link-color: #1877f2;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 
                        Oxygen-Sans, Ubuntu, Cantarell, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        h1 {
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 30px;
        }
        
        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 20px;
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid var(--border-color);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .card-image {
            width: 100%;
            height: 210px;
            object-fit: cover;
            border-bottom: 1px solid var(--border-color);
        }
        
        .card-content {
            padding: 15px;
        }
        
        .card-domain {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: lowercase;
            margin-bottom: 5px;
        }
        
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 8px 0;
            line-height: 1.4;
        }
        
        .card-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.4;
            margin-bottom: 10px;
        }
        
        @media (max-width: 600px) {
            .portfolio-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <h1>Mis Sitios Web</h1>
    
    <div class="portfolio-grid">
        <?php foreach ($previews as $meta): ?>
            <?php if (!empty($meta['title']) || !empty($meta['description'])): ?>
                <a href="<?= htmlspecialchars($meta['url']) ?>" target="_blank" class="card">
                    <?php if (!empty($meta['image'])): ?>
                        <img src="<?= htmlspecialchars($meta['image']) ?>" 
                             alt="<?= htmlspecialchars($meta['title'] ?? '') ?>" 
                             class="card-image"
                             onerror="this.style.display='none'">
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <div class="card-domain">
                            <?= parse_url($meta['url'], PHP_URL_HOST) ?>
                        </div>
                        <h3 class="card-title">
                            <?= htmlspecialchars($meta['title'] ?? 'Sin título') ?>
                        </h3>
                        <p class="card-desc">
                            <?= htmlspecialchars($meta['description'] ?? '') ?>
                        </p>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</body>
</html>
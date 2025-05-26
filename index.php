<?php
require 'src/MetaPreview.php';

// Configuración - Solo edita este array
$mis_sitios = [
	'https://ventomaquia.com',
	'https://ahorcado.idalibre.com',
	'https://therocket.cliente.work',
	'https://obscuroplacer.com',
    'https://sca.cliente.work',
	'https://juan-palma.idalibre.com',
    'https://toner.cliente.work',
	'https://amatista-envases.com/',
	'https://yariel.site/',
	'https://tocho.cliente.work',
	'https://1975studio.com',
	'https://inmotion.cliente.work',
	'https://ciasa.cliente.work',
	'https://canadaviajes.cliente.work/toronto',
	'https://canadaviajes.cliente.work/quebec',
	'https://solael.mx',
	'https://tp-abogados.com'
    // Añade más URLs aquí
];

$preview = new MetaPreview();
$previews = [];
foreach ($mis_sitios as $url) {
    // Validación básica de URL
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $previews[] = $preview->fetch($url);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portafolio de Proyectos Realizados</title>
    <style>
		@import url('https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap');
        body {
            font-family: 'Sen', Roboto, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #1d2129;
        }
        .portfolio {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            border: 1px solid #dddfe2;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }
        .card-content {
            padding: 15px;
        }
        .card-domain {
            font-size: 12px;
            color: #606770;
            margin-bottom: 5px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 600;
            color: #1d2129;
            margin: 0 0 8px 0;
        }
        .card-desc {
            font-size: 14px;
            color: #606770;
            line-height: 1.4;
        }
        @media (max-width: 600px) {
            .portfolio {
                grid-template-columns: 1fr;
            }
        }
		.intro {
			padding: 10px 16vwpx;
		}
    </style>
</head>
<body>
    <h1>Portafolio de Proyectos Realizados</h1>
	<p class="intro">
		Te encuentras en nuestro portafolio o galería de proyectos que hemos realizado, aquí encontraras sitios de clientes, agencias hermanas con quienes colaboramos para apoyarlas al realizar sus proyectos he incluso nuestros propios sitios corporativos.
	</p>
	<p class="intro">
		Savemos que disfrutaras de cada uno de nuestros sitios y esperemos poder trabajar juntos si te sientes convencido y contento con lo que hacemos y como lo hacemos 😀
	</p>
    
    <div class="portfolio">
        <?php foreach ($previews as $meta): ?>
            <a href="<?= htmlspecialchars($meta['url']) ?>" target="_blank" class="card">
                <?php if (!empty($meta['image'])): ?>
                    <img src="<?= htmlspecialchars($meta['image']) ?>" 
                         alt="<?= htmlspecialchars($meta['title']) ?>" 
                         class="card-image"
                         onerror="this.style.display='none'">
                <?php endif; ?>
                
                <div class="card-content">
                    <div class="card-domain">
                        <?= parse_url($meta['url'], PHP_URL_HOST) ?>
                    </div>
                    <h3 class="card-title">
                        <?= htmlspecialchars($meta['title']) ?>
                    </h3>
                    <p class="card-desc">
                        <?= htmlspecialchars($meta['description']) ?>
                    </p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</body>
</html>
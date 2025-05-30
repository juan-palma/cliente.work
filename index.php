<?php
require 'src/MetaPreview.php';

// Configuración - Solo edita este array
$mis_sitios = [
	'https://ventomaquia.com',
	'https://therocket.cliente.work',
	'https://obscuroplacer.com',
    'https://sca.cliente.work',
	'https://juan-palma.idalibre.com',
     'https://ahorcado.idalibre.com',
    'https://toner.cliente.work',
	'https://amatista-envases.com/',
	'https://yariel.site/',
	'https://tocho.cliente.work',
	'https://1975studio.com',
	'https://inmotion.cliente.work',
	'https://ciasa.cliente.work',
	'https://canadaviajes.cliente.work/toronto',
	'https://canadaviajes.cliente.work/quebec',
	'https://canadaviajes.cliente.work/ontario',
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
    <meta name="viewport" content="width=device-width, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0, initial-scale=1.0, viewport-fit=cover" />
    <meta http-equiv="Content-Encoding" content="gzip" />
    <meta http-equiv="Accept-Encoding" content="gzip, deflate" />

    <meta name="facebook-domain-verification" content="v6kip5x88ivvhkw8x4unpx09k7m1lh" />

    <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M4SVLLSH');</script>
    <!-- End Google Tag Manager -->

    <title>Portafolio de Proyectos Realizados</title>
	<meta name="description" content="Estas en nuestro portafolio de proyectos que hemos realizado para clientes, agencias y nuestros corporativos"></meta>

    <meta property="og:type" content="WEBSITE" />
    <meta property="og:url" content="https://cliente.work" />
    <meta property="og:site_name" content="SCA | especialistas en gestión ambiental empresarial" />
    <!-- <meta property="fb:app_id" content="ID-FACEBOOK-APP" /> -->
            
    <meta property="og:title" content="Portafolio de Proyectos Realizados" />
    <meta property="og:description" content="Estas en nuestro portafolio de proyectos que hemos realizado para clientes, agencias y nuestros corporativos" />
    <meta property="og:image" content="https://cliente.work/assets/img/facebook_web_img_article.jpg" />
    <meta property="og:image:alt" content="Portada del sitio web" />
    <meta property="og:image:type" content="image/jpeg" />

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
        .intro {
			padding: 10px 16vw;
		}
        @media (max-width: 600px) {
            .portfolio {
                grid-template-columns: 2fr;
            }
            .intro {
                padding: 10px 8vw;
            }
        }
		
    </style>
</head>
<body>
    <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4SVLLSH"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <h1>Portafolio de Proyectos Realizados</h1>
	<p class="intro">
		Te encuentras en nuestro portafolio de proyectos, aquí encontraras desarrollos web hechos para clientes, agencias con quien colaboramos he incluso nuestros sitios corporativos.
	</p>
	<p class="intro">
		Sabemos que disfrutarás de cada uno de nuestros sitios esperando poder trabajar juntos, claro... si te sientes convencido y contento con lo que hacemos y como lo hacemos 😀
	</p>
	<p class="intro">
		Si deseas cotizar el desarrollo de algun sitio, mejora o herramienta, contacta con la persona que te brindo este enlace, si llegaste desde un anuncio, en el mismo encontraras información de contactos.
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
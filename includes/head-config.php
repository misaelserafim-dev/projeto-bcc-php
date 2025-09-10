<?php
/**
 * Configurações de HEAD para o site Brasil Center
 * Baseado no nuxt.config.js original
 */

// Incluir configuração de caminhos
require_once __DIR__ . '/path-config.php';

// Configurações padrão do site
$site_config = [
    'title' => 'BrasilCenter - Contact Center e Trade Marketing',
    'description' => 'BrasilCenter é especialista em Contact Center e Trade Marketing. Oferecemos atendimento estratégico para o Grupo Claro, soluções em ouvidoria, Anatel, atendimento técnico e vendas em varejo.',
    'og_image' => asset_url('images/logo-brasil-center.png'),
    'gtm_id' => 'GTM-5P8PDF'
];

// Configurações específicas por página
$page_configs = [
    'home' => [
        'title' => 'BrasilCenter - Contact Center e Trade Marketing',
        'description' => 'BrasilCenter é especialista em Contact Center e Trade Marketing. Oferecemos atendimento estratégico para o Grupo Claro, soluções em ouvidoria, Anatel, atendimento técnico e vendas em varejo.'
    ],
    'sobre' => [
        'title' => 'Sobre a BCC - BrasilCenter',
        'description' => 'Conheça a história da BrasilCenter, nossa missão, valores e como nos tornamos referência em Contact Center e Trade Marketing no Brasil.'
    ],
    'jeito-bcc' => [
        'title' => 'Jeito BCC - Nossa Cultura - BrasilCenter',
        'description' => 'Descubra o Jeito BCC de ser: nossa cultura organizacional, valores e o que nos torna únicos no mercado de Contact Center.'
    ]
];

/**
 * Função para gerar as meta tags baseado na página atual
 */
function generate_head_tags($page = 'home') {
    global $site_config, $page_configs;
    
    // Pegar configuração da página ou usar padrão
    $config = isset($page_configs[$page]) ? $page_configs[$page] : $page_configs['home'];
    $title = $config['title'];
    $description = $config['description'];
    
    return [
        'title' => $title,
        'description' => $description,
        'og_title' => $title,
        'og_description' => $description,
        'og_image' => $site_config['og_image'],
        'twitter_title' => $title,
        'twitter_description' => $description,
        'gtm_id' => $site_config['gtm_id']
    ];
}

/**
 * Função para renderizar o HTML do head
 */
function render_head($page = 'home') {
    $head_data = generate_head_tags($page);
    
    ob_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($head_data['title']); ?></title>
    
    <!-- Meta Tags SEO -->
    <meta name="description" content="<?php echo htmlspecialchars($head_data['description']); ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="<?php echo htmlspecialchars($head_data['og_title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($head_data['og_description']); ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?php echo htmlspecialchars($head_data['og_image']); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($head_data['twitter_title']); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($head_data['twitter_description']); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($head_data['og_image']); ?>">
    
    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo asset_url('favicon-512x512.png'); ?>">
    <link rel="shortcut icon" href="<?php echo asset_url('favicon-512x512.png'); ?>">
    
    <!-- Preload recursos críticos -->
    <link rel="preload" href="<?php echo asset_url('css/styles.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo asset_url('css/styles.css'); ?>"></noscript>
    
    <!-- Preload fonts críticas -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;600;700;800&display=swap"></noscript>
    
    <!-- Swiper CSS (lazy load) -->
    <link rel="preload" href="<?php echo asset_url('libs/swiper/swiper-bundle.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo asset_url('libs/swiper/swiper-bundle.min.css'); ?>"></noscript>
    
    <?php
    // CSS específico da página
    if ($page === 'sobre' && file_exists(__DIR__ . '/../css/sobre-bcc.css')) {
        echo '<link rel="stylesheet" href="' . asset_url('css/sobre-bcc.css') . '">';
    }
    if ($page === 'jeito-bcc' && file_exists(__DIR__ . '/../css/jeito-bcc.css')) {
        echo '<link rel="stylesheet" href="' . asset_url('css/jeito-bcc.css') . '">';
    }
    ?>
    
    <!-- GSAP -->
    <script src="<?php echo asset_url('libs/gsap/gsap.min.js'); ?>"></script>
    <script src="<?php echo asset_url('libs/gsap/ScrollTrigger.min.js'); ?>"></script>
    
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo $head_data['gtm_id']; ?>');
    </script>
    <?php
    return ob_get_clean();
}

/**
 * Função para renderizar o noscript do GTM (deve ir logo após <body>)
 */
function render_gtm_noscript() {
    global $site_config;
    return '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . $site_config['gtm_id'] . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
}
?>

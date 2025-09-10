<?php include 'includes/head-config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo render_head('sobre'); ?>
</head>
<body>
    <?php echo render_gtm_noscript(); ?>
    
    <?php include 'includes/header.php'; ?>
    
    <main class="sobre-bcc-page">
        <!-- Componente Banner Sobre -->
        <?php include 'includes/components/banner-sobre.php'; ?>
        
        <!-- Conteúdo da página sobre a BCC será adicionado aqui -->
        <div class="scroll-anime">
            <!-- Componente Quem somos -->
            <?php include 'includes/components/quem-somos.php'; ?>
            
            <!-- Componente As bases BCC -->
            <?php include 'includes/components/bases-bcc.php'; ?>
            
            <!-- Componente Conquistas -->
            <?php include 'includes/components/conquistas.php'; ?>
            
            <!-- Componente Jornada BCC -->
            <?php include 'includes/components/jornada-bcc.php'; ?>
            
            <!-- Componente Junte-se a nós -->
            <?php include 'includes/components/join-us.php'; ?>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- Swiper JS (async) -->
    <script src="<?php echo asset_url('libs/swiper/swiper-bundle.min.js'); ?>" async></script>
    <script src="<?php echo asset_url('js/scripts.js'); ?>" defer></script>
    <script src="<?php echo asset_url('js/sobre-bcc.js'); ?>" defer></script>
</body>
</html>

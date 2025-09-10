<?php include 'includes/head-config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo render_head('home'); ?>
</head>
<body>
    <?php echo render_gtm_noscript(); ?>
    
    <?php include 'includes/header.php'; ?>
    
    <main>
        <!-- Componente Banner -->
        <?php include 'includes/components/banner.php'; ?>
        
        <div class="scroll-anime">
            <!-- Componente Sobre nós -->
            <?php include 'includes/components/sobre-home.php'; ?>
            
            <!-- Componente Atuação -->
            <?php include 'includes/components/atuacao.php'; ?>
            
            <!-- Componente Nossa essência -->
            <?php include 'includes/components/nossa-essencia.php'; ?>
            
            <!-- Componente Nossa cultura -->
            <?php include 'includes/components/nossa-cultura.php'; ?>
            
            <!-- Componente Nossa gente -->
            <?php include 'includes/components/nossa-gente.php'; ?>
            
            <!-- Componente Apoio aos colaboradores -->
            <?php include 'includes/components/apoio.php'; ?>
            
            <!-- Componente Junte-se a nós -->
            <?php include 'includes/components/join-us.php'; ?>
            
            <!-- Componente Instagram -->
            <?php include 'includes/components/instagram.php'; ?>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- Swiper JS (async) -->
    <script src="<?php echo asset_url('libs/swiper/swiper-bundle.min.js'); ?>" async></script>
    <!-- Scripts globais primeiro (defer) -->
    <script src="<?php echo asset_url('js/scripts.js'); ?>" defer></script>
    <!-- Scripts específicos da página depois (defer) -->
    <script src="<?php echo asset_url('js/index.js'); ?>" defer></script>
</body>
</html>

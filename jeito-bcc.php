<?php include 'includes/head-config.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php echo render_head('jeito-bcc'); ?>
</head>
<body>
    <?php echo render_gtm_noscript(); ?>
    
    <?php include 'includes/header.php'; ?>
    
    <main class="jeito-bcc-page">
        <!-- Componente Banner Jeito BCC -->
        <?php include 'includes/components/banner-jeito-bcc.php'; ?>
        
        <!-- Conteúdo da página jeito BCC será adicionado aqui -->
        <div class="scroll-anime">
            <!-- Componente Atmosfera BCC -->
            <?php include 'includes/components/atmosfera-bcc.php'; ?>
            
            <!-- Componente Para começar e ficar -->
            <?php include 'includes/components/para-comecar.php'; ?>
            
            <!-- Componente Prioridades -->
            <?php include 'includes/components/prioridades.php'; ?>
            
            <!-- Componente Projetos internos -->
            <?php include 'includes/components/projetos-internos.php'; ?>
            
            <!-- Componente Junte-se a nós -->
            <?php include 'includes/components/join-us.php'; ?>
        </div>
    </main>
    
    <?php include 'includes/footer.php'; ?>
    
    <!-- Swiper JS (async) -->
    <script src="<?php echo asset_url('libs/swiper/swiper-bundle.min.js'); ?>" async></script>
    <script src="<?php echo asset_url('js/scripts.js'); ?>" defer></script>
    <script src="<?php echo asset_url('js/jeito-bcc.js'); ?>" defer></script>
</body>
</html>
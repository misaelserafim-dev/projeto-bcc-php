<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados do banner da API
$banner_data = get_jeito_bcc_banner();
$background = $banner_data['background'];
$backgroundMobile = $banner_data['backgroundMobile'];
$banner = $banner_data['banner'];
?>

<?php if (!empty($banner)): ?>
<style>
object.banner-svg-background.banner-svg-mobile {
    display: none !important;
    opacity: 0;
}

@media screen and (max-width: 768px) {
    object.banner-svg-background.banner-svg-mobile {
        display: block !important;
        opacity: 1;
    }
    object.banner-svg-background {
        display: none !important;
        opacity: 0;
    }
}

</style>

<div class="Banner">
    <!-- SVG inline como background -->
    <object 
        data="<?php echo htmlspecialchars($background); ?>" 
        type="image/svg+xml" 
        class="banner-svg-background banner-svg-desktop">
    </object>

    <object 
        data="<?php echo htmlspecialchars($backgroundMobile); ?>" 
        type="image/svg+xml" 
        class="banner-svg-background banner-svg-mobile">
    </object>

    <!-- Banner com Swiper (mesmo com um item) -->
    <div class="swiper mySwiper" data-swiper-config='{
        "slidesPerView": 1,
        "pagination": {"el": ".banner-jeito-bcc-pagination", "clickable": true, "type": "bullets"},
        "autoplay": {"delay": 4000},
        "loop": false,
        "touchReleaseOnEdges": true,
        "breakpoints": {
            "0": {"direction": "vertical"},
            "768": {"direction": "horizontal"}
        }
    }'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="item-banner container">
                    <div class="grid-item-banner">
                        <picture>
                            <?php if (!empty($banner['mobile'])): ?>
                                <source srcset="<?php echo htmlspecialchars($banner['mobile']); ?>" media="(max-width: 768px)" />
                            <?php endif; ?>
                            <?php if (!empty($banner['desktop'])): ?>
                                <img src="<?php echo htmlspecialchars($banner['desktop']); ?>" 
                                     alt="<?php echo htmlspecialchars($banner['titulo'] ?? 'Banner Jeito Brasil Center'); ?>" 
                                     aria-hidden="true">
                            <?php endif; ?>
                        </picture>
                        <div class="grid-item-banner-texto">
                            <?php if (!empty($banner['icone'])): ?>
                                <img src="<?php echo htmlspecialchars($banner['icone']); ?>" 
                                     alt="imagem ilustrativa" 
                                     aria-hidden="true" 
                                     class="icon-banner-cad">
                            <?php endif; ?>
                            
                            <?php if (!empty($banner['titulo'])): ?>
                                <h2><?php echo htmlspecialchars($banner['titulo']); ?></h2>
                            <?php endif; ?>
                            
                            <?php if (!empty($banner['descricao'])): ?>
                                <h3><?php echo htmlspecialchars($banner['descricao']); ?></h3>
                            <?php endif; ?>
                            
                            <?php if (!empty($banner['link']) && !empty($banner['botao'])): ?>
                                <a href="<?php echo htmlspecialchars($banner['link']); ?>" 
                                   class="button-banner" 
                                   target="<?php echo strpos($banner['link'], 'http') === 0 ? '_blank' : '_self'; ?>">
                                    <?php echo htmlspecialchars($banner['botao']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination banner-jeito-bcc-pagination"></div>
    </div>
</div>
<?php endif; ?>

<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados do banner da API
$banner_data = get_home_banner();
$background = $banner_data['background'];
$backgroundMobile = $banner_data['backgroundMobile'];
$slides = $banner_data['slides'];
?>

<?php if (!empty($slides)): ?>
<style>
object.banner-svg-background.banner-svg-mobile {
    display: none !important;
    opacity: 0;
}

@media screen and (max-width: 768px) {
    .item-banner.container {
        margin-top: 90px;
    }
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

    <div class="swiper mySwiper" data-swiper-config='{
        "slidesPerView": 1,
        "pagination": {"el": ".banner-pagination", "clickable": true, "type": "bullets"},
        "autoplay": {"delay": 4000},
        "loop": false,
        "touchReleaseOnEdges": true,
        "breakpoints": {
            "0": {"direction": "vertical"},
            "768": {"direction": "horizontal"}
        }
    }'>
        <div class="swiper-wrapper">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="swiper-slide">
                    <div class="item-banner container<?php echo $slide['alternativo'] ? ' banner-alternativo' : ''; ?>">
                        <div class="grid-item-banner">
                            <picture>
                                <?php if (!empty($slide['mobile'])): ?>
                                    <source srcset="<?php echo htmlspecialchars($slide['mobile']); ?>" media="(max-width: 768px)" />
                                <?php endif; ?>
                                <?php if (!empty($slide['desktop'])): ?>
                                    <img src="<?php echo htmlspecialchars($slide['desktop']); ?>" 
                                         alt="<?php echo htmlspecialchars($slide['title'] ?? 'Banner Brasil Center'); ?>" 
                                         aria-hidden="true">
                                <?php endif; ?>
                            </picture>
                            <div class="grid-item-banner-texto">
                                <?php if (!empty($slide['icon'])): ?>
                                    <img src="<?php echo htmlspecialchars($slide['icon']); ?>" 
                                         alt="imagem ilustrativa" 
                                         aria-hidden="true" 
                                         class="icon-banner-cad">
                                <?php endif; ?>
                                
                                <?php if (!empty($slide['title'])): ?>
                                    <h2><?php echo htmlspecialchars($slide['title']); ?></h2>
                                <?php endif; ?>
                                
                                <?php if (!empty($slide['text'])): ?>
                                    <h3><?php echo htmlspecialchars($slide['text']); ?></h3>
                                <?php endif; ?>
                                
                                <?php if (!empty($slide['link']) && !empty($slide['button'])): ?>
                                    <a href="<?php echo htmlspecialchars($slide['link']); ?>" 
                                       class="button-banner" 
                                       target="<?php echo strpos($slide['link'], 'http') === 0 ? '_blank' : '_self'; ?>">
                                        <?php echo htmlspecialchars($slide['button']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination (bullets) -->
        <div class="swiper-pagination banner-pagination"></div>
    </div>
</div>


<?php endif; ?> 
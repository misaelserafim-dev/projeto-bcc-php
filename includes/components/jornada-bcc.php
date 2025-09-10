<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados da "Jornada BCC" da API
$jornada_data = get_sobre_jornada();
$historias = $jornada_data['historias'];
?>

<?php if (!empty($historias)): ?>
<section id="jornada-bcc">
    <div class="Historias container">
        <div class="content-title t-center">
            <span class="highlight">Construindo história</span>
            <h2 class="title-xl">Jornada BCC</h2>
            <p>Fazendo junto e crescendo junto há mais de 25 anos.</p>
        </div>
        
        <div class="swipper-bullets-mod"></div>
        
        <div class="swiper carousel-container" data-swiper-config='{
            "slidesPerView": 1,
            "spaceBetween": 0,
            "pagination": {"el": ".swipper-bullets-mod", "clickable": true},
            "navigation": {
                "nextEl": ".n-historia",
                "prevEl": ".p-historia"
            },
            "grabCursor": true
        }'>
            <div class="swiper-wrapper">
                <?php foreach ($historias as $index => $history): ?>
                    <div class="swiper-slide card-carrossel">
                        <div class="card-image-carrossel">
                            <span class="icon-date"></span>
                            <picture class="picture-wrapper">
                                <?php if (!empty($history['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($history['image']); ?>" 
                                         alt="logo da empresa" 
                                         aria-hidden="true" 
                                         loading="lazy" />
                                <?php endif; ?>
                            </picture>
                        </div>
                        
                        <div class="card-content-history">
                            <div class="title-container-carrossel">
                                <?php echo htmlspecialchars($history['anoInit']); ?> 
                                <strong><?php echo htmlspecialchars($history['anoFim']); ?></strong>
                            </div>
                            
                            <div class="content-image-mobile">
                                <picture>
                                    <?php if (!empty($history['imageMobile'])): ?>
                                        <source media="(max-width: 768px)" srcset="<?php echo htmlspecialchars($history['imageMobile']); ?>" />
                                    <?php endif; ?>
                                    <?php if (!empty($history['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($history['image']); ?>" 
                                             alt="logo da empresa mobile" 
                                             loading="lazy" />
                                    <?php endif; ?>
                                </picture>
                            </div>
                            
                            <?php if (!empty($history['text'])): ?>
                                <div class="card-content-text"><?php echo $history['text']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="container-btns">
            <div class="item-actions">
                <button class="swiper-button-prev p-historia"></button>
                <button class="swiper-button-next n-historia"></button>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


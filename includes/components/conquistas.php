<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados das "Conquistas" da API
$conquistas_data = get_sobre_conquistas();
$titulo = $conquistas_data['titulo'];
$premios = $conquistas_data['premios'];
?>

<?php if (!empty($premios) || !empty($titulo)): ?>
<section id="conquistas">
    <div class="container">
        <div class="content-title t-center">
            <span class="highlight">Conquistas</span>
            <?php if (!empty($titulo)): ?>
                <h2 class="title-xl"><?php echo htmlspecialchars($titulo); ?></h2>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($premios)): ?>
            <div class="swiper carousel-container" data-swiper-config='{
                "slidesPerView": 4.4,
                "spaceBetween": 16,
                "grabCursor": true,
                "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"},
                "freeMode": true,
                "breakpoints": {
                    "0": {
                        "slidesPerView": 1.4
                    },
                    "640": {
                        "slidesPerView": 2.5
                    },
                    "1024": {
                        "slidesPerView": 4.4,
                        "spaceBetween": 16
                    }
                }
            }'>
                <div class="swiper-wrapper">
                    <?php foreach ($premios as $index => $premio): ?>
                        <div class="swiper-slide card-item">
                            <?php if (!empty($premio['image'])): ?>
                                <img src="<?php echo htmlspecialchars($premio['image']); ?>" 
                                     alt="logo da empresa" 
                                     aria-hidden="true" 
                                     loading="lazy" />
                            <?php endif; ?>
                            
                            <div class="flex-item-card">
                                <?php if (!empty($premio['title'])): ?>
                                    <h3><span class="icon-stars"></span> <?php echo htmlspecialchars($premio['title']); ?></h3>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($premio['text'])): ?>
                                <p><?php echo htmlspecialchars($premio['text']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Navigation buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

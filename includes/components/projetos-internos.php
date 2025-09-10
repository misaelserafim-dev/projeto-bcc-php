<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados dos "Projetos internos" da API
$projetos_data = get_jeito_bcc_projetos();
$projetos = $projetos_data['projetos'];
?>

<?php if (!empty($projetos)): ?>
<section id="projetos-internos">
    <div class="container">
        <div class="content-title t-center">
            <span class="highlight">Projetos internos</span>
            <h2 class="title-xxl">Incentivo e reconhecimento para os nossos</h2>
            <p>Conheça as iniciativas que destacam os talentos da BCC.</p>
        </div>
        
        <div class="swiper carousel-container" data-swiper-config='{
            "slidesPerView": 4,
            "spaceBetween": 56,
            "navigation": {"nextEl": ".swiper-button-next", "prevEl": ".swiper-button-prev"},
            "grabCursor": true,
            "breakpoints": {
                "0": {
                    "slidesPerView": 1
                },
                "640": {
                    "slidesPerView": 2
                },
                "1024": {
                    "slidesPerView": 4
                }
            }
        }'>
            <div class="swiper-wrapper">
                <?php foreach ($projetos as $index => $projeto): ?>
                    <div class="swiper-slide card-carrossel">
                        <div class="card-content-project">
                            <?php if (!empty($projeto['icone'])): ?>
                                <div class="icone-item">
                                    <img src="<?php echo htmlspecialchars($projeto['icone']); ?>" 
                                         alt="ícone ilustrativo" 
                                         aria-hidden="true" 
                                         loading="lazy" />
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($projeto['titulo'])): ?>
                                <h3><?php echo htmlspecialchars($projeto['titulo']); ?></h3>
                            <?php endif; ?>
                            
                            <?php if (!empty($projeto['descricao'])): ?>
                                <p><?php echo htmlspecialchars($projeto['descricao']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigation buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>
<?php endif; ?>

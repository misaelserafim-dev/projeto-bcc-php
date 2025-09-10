<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar benefícios da API
$benefits = get_home_benefits();
?>

<?php if (!empty($benefits)): ?>
<section id="apoio">
    <div class="Apoio container">
        <div class="content-title t-center">
            <span class="highlight">Apoio aos colaboradores</span>
            <h2 class="title-xxl">Benefícios que vão além do trabalho</h2>
            <p>Além de coberturas essenciais como <strong>vale-transporte, vale-refeição/alimentação, seguro de vida, plano de saúde e odontológico,</strong> a BCC tem muito mais apoio para complementar o seu bem-estar:</p>
        </div>
        
        <!-- Swiper -->
        <div class="swiper carousel-container" data-swiper-config='{
            "slidesPerView": 4,
            "spaceBetween": 56,
            "navigation": {
                "nextEl": ".n-apoio",
                "prevEl": ".p-apoio"
            },
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
                <?php foreach ($benefits as $index => $benefit): ?>
                    <div class="swiper-slide card-carrossel" data-index="<?php echo $index; ?>">
                        <div class="card-content-project">
                            <div class="icone-item">
                                <img src="<?php echo process_image_url($benefit['icone']['node']['sourceUrl']); ?>" 
                                     alt="ícone ilustrativo" 
                                     aria-hidden="true" 
                                     loading="lazy" />
                            </div>
                            <h3><?php echo htmlspecialchars($benefit['descricao']); ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="container-btns">
            <div class="item-actions">
                <button class="swiper-button-prev p-apoio" aria-label="Anterior"></button>
                <button class="swiper-button-next n-apoio" aria-label="Próximo"></button>
            </div>
        </div>
    </div>
</section>


<?php endif; ?>

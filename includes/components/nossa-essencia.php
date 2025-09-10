<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados da essência da API
$essencia_data = get_home_essencia();
$titulo = $essencia_data['titulo'];
$videos = $essencia_data['videos'];
?>

<?php if (!empty($videos)): ?>
<section class="Essencia" id="essencia">
    <div class="container">
        <div class="content-title">
            <span class="highlight" id="essencia-highlight">Nossa essência</span>
            <h2 class="title-xxl" id="essencia-title"><?php echo htmlspecialchars($titulo); ?></h2>
        </div>

        <div class="swiper carousel-container" data-swiper-config='{"slidesPerView": 5, "spaceBetween": 16, "pagination": {"el": "#essencia-pagination", "clickable": true}, "breakpoints": {"0": {"slidesPerView": 1.1, "spaceBetween": 12}, "640": {"slidesPerView": 2.5, "spaceBetween": 16}, "1024": {"slidesPerView": 5, "spaceBetween": 16}}}'>
            <div class="swiper-wrapper">
                <?php foreach ($videos as $index => $video): ?>
                    <div class="swiper-slide carousel-item" data-video-index="<?php echo $index; ?>">
                        <video 
                            alt="vídeos do tiktok da Brasil Center" 
                            loading="lazy" 
                            playsinline 
                            preload="metadata" 
                            muted>
                            <source src="<?php echo htmlspecialchars($video['thumbnail']); ?>" type="video/mp4" />
                        </video>
                        <div class="overlay"></div>
                        <button class="play-button" data-video-index="<?php echo $index; ?>">
                            <span class="play-icon">
                                <img src="assets/botao-play.png" alt="ícone play">
                            </span>
                            <span class="pause-icon" style="display: none;">
                                <img src="assets/botao-pausa.svg" alt="ícone pausa">
                            </span>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div id="essencia-pagination" class="custom-swiper-pagination"></div>
    </div>
</section>
<?php endif; ?>
<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados da cultura da API
$cultura_data = get_home_cultura();
$titulo = $cultura_data['titulo'];
$imagens = $cultura_data['imagens'];
?>

<?php if (!empty($imagens)): ?>
<section id="nossacultura">
    <div class="container">
        <div class="content-title">
            <span class="highlight">Nossa cultura</span>
            <h2 class="title-xxl t-white"><?php echo htmlspecialchars($titulo); ?></h2>
            <p class="t-white">Ambientes e estruturas que tornam tudo mais leve e uma cultura onde pessoas vêm antes de qualquer coisa.</p>
        </div>
        <div class="grid-wrapper">
            <div class="grid" id="cultura-grid">
                <?php foreach ($imagens as $index => $img): ?>
                    <img src="<?php echo htmlspecialchars($img['thumbnail']); ?>" 
                         alt="<?php echo htmlspecialchars($img['alt']); ?>" 
                         class="item" 
                         loading="lazy" 
                         data-index="<?php echo $index; ?>" />
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

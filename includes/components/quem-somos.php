<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados do "Quem somos" da API
$quem_somos = get_sobre_quem_somos();

?>

<?php if (!empty($quem_somos['titulo']) || !empty($quem_somos['descricao'])): ?>
<section id="quem-somos-bcc">
    <div class="container">
        <div class="list-card-horizontal">
            <div class="item-cad-horizontal grid grid-2">
                <div class="card-horizontal-text">
                    <span class="highlight">Quem somos</span>
                    
                    <?php if (!empty($quem_somos['titulo'])): ?>
                        <h2 class="title-xxl"><?php echo $quem_somos['titulo']; ?></h2>
                    <?php endif; ?>
                    
                    <?php if (!empty($quem_somos['descricao'])): ?>
                        <div><?php echo $quem_somos['descricao']; ?></div>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($quem_somos['imagem'])): ?>
                    <div class="card-horizontal-img">
                        <img src="<?php echo htmlspecialchars($quem_somos['imagem']); ?>" 
                             alt="Imagem Sobre" 
                             aria-hidden="true" 
                             loading="lazy" 
                             class="img_anime">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

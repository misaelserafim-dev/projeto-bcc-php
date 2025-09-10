<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados da atuação da API
$atuacao_data = get_home_atuacao();
$titulo = $atuacao_data['titulo'];
$items = $atuacao_data['items'];
?>

<?php if (!empty($items)): ?>
<section id="atuacao" data-scroll-content-atuacao>
    <div class="container" data-container-atuacao>
        <div class="grid grid-2">
            <div class="content-title">
                <div id="sticky-title" data-sticky-title-atuacao>
                    <span class="highlight">Atuação</span>
                    <h2 class="title-xxl t-white"><?php echo htmlspecialchars($titulo); ?></h2>
                </div>
            </div>
            <div class="content-numbers">
                <?php foreach ($items as $index => $item): ?>
                    <div class="item-atuacao">
                        <img src="<?php echo htmlspecialchars($item['icon']); ?>" 
                             alt="ícone para <?php echo htmlspecialchars($item['label']); ?>" 
                             class="icon-atuacao" 
                             aria-hidden="true" 
                             loading="lazy">
                        <h4 class="number-element" 
                            data-index="<?php echo $index; ?>"
                            data-value="<?php echo htmlspecialchars($item['value']); ?>"
                            id="number-<?php echo $index; ?>">
                            <?php echo htmlspecialchars($item['value']); ?>
                        </h4>
                        <p><?php echo htmlspecialchars($item['label']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>

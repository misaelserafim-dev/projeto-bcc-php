<?php
// Incluir cliente GraphQL
include_once __DIR__ . '/../graphql-client.php';

// Buscar dados das "Prioridades" da API
$prioridades_data = get_jeito_bcc_prioridades();
$prioridades = $prioridades_data['prioridades'];
?>

<section id="prioridades" data-scroll-content-prioridades>
    <div class="container" data-container-prioridades>
        <div class="list-card-horizontal">
            <div class="item-cad-horizontal grid">
                <div class="card-horizontal-text">
                    <span class="highlight">Prioridades</span>
                    <h2 class="title-xxl">A gente valoriza o que é mais importante</h2>
                    <p>Um time de talentos vibrantes que cresce no bem-estar coletivo e tem ações e prioridades bem definidas.</p>

                    <?php if (!empty($prioridades)): ?>
                        <div class="list-itens grid grid-2">
                            <?php foreach ($prioridades as $index => $item): ?>
                                <div class="item-list">
                                    <?php if (!empty($item['icone'])): ?>
                                        <picture class="div-icon">
                                            <img src="<?php echo htmlspecialchars($item['icone']); ?>" 
                                                 alt="ícone de ilustração para <?php echo htmlspecialchars($item['titulo']); ?>" 
                                                 aria-hidden="true" 
                                                 loading="lazy">
                                        </picture>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['titulo'])): ?>
                                        <h4><?php echo htmlspecialchars($item['titulo']); ?></h4>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['descricao'])): ?>
                                        <p><?php echo htmlspecialchars($item['descricao']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-horizontal-img">
                    <picture>
                        <source srcset="images/jeitoBcc/pessoa-prioridade.png" media="(max-width: 768px)" />
                        <img src="images/jeitoBcc/pessoa-prioridade.png" 
                             alt="imagem ilustrativa" 
                             aria-hidden="true" 
                             loading="lazy"
                             class="imgParallax" 
                             data-parallax-image>
                    </picture>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="background-parallax" style="background-image: url('images/jeitoBcc/bg-parallax.jpg');"></div>

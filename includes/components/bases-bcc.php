<?php
// Dados fixos do componente (não vem da API)
$cardItems = [
    [
        'icon' => 'assets/olho.svg',
        'title' => 'Objetivo',
        'text' => 'Prover serviços de Contact Center e Vendas aos clientes do Grupo Claro com qualidade diferenciada e custos competitivos.'
    ],
    [
        'icon' => 'assets/telescopio.svg',
        'title' => 'Perspectiva',
        'text' => 'Ser reconhecida pela excelência na gestão de soluções de relacionamento com o cliente.'
    ],
    [
        'icon' => 'assets/estrela.svg',
        'title' => 'Valores',
        'text' => 'Sustentabilidade, cliente, pessoas, inovação e honestidade.'
    ]
];
?>

<section id="bases">
    <div class="container">
        <div class="list-card-horizontal">
            <div class="content-title t-center">
                <span class="highlight animate-up" data-animate="up">As bases BCC</span>
                <h2 class="title-xxl animate-up" data-animate="up">O jeito <span class="word_breaker"></span> BrasilCenter <span class="word_breaker"></span>de fazer</h2>
            </div>
            
            <div class="item-cad-horizontal grid grid-2">
                <div class="card-horizontal-img">
                    <img src="images/sobreBcc/base-bcc.png" 
                         alt="imagem ilustrativa" 
                         aria-hidden="true" 
                         loading="lazy" 
                         class="img_anime animate-up" 
                         data-animate="up">
                </div>
                
                <div class="card-horizontal-text">
                    <?php foreach ($cardItems as $index => $item): ?>
                        <div class="item-card animate-up" data-animate="up" data-delay="<?php echo $index * 0.1; ?>">
                            <img src="<?php echo htmlspecialchars($item['icon']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 class="card-icon animate-up" 
                                 data-animate="up">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p><?php echo htmlspecialchars($item['text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>   
    </div>   
</section>

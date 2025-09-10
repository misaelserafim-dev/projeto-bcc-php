<?php
/**
 * Dados do Footer - Brasil Center
 * Busca dados da API GraphQL
 */

// Incluir cliente GraphQL
include_once __DIR__ . '/graphql-client.php';

// Links do footer (buscar da API)
$footer_links = get_footer_links();

// Informações de contato
$footer_contact = [
    'email' => 'falecomabcc@brasilcenter.com.br',
    'instagram' => 'https://www.instagram.com/brasilcenter_oficial/'
];

// Menu principal do footer
$footer_menu = [
    [
        'title' => 'Página inicial',
        'link' => '/'
    ],
    [
        'title' => 'Sobre a BCC',
        'link' => '/sobre'
    ],
    [
        'title' => 'Jeito BCC',
        'link' => '/jeito-bcc'
    ],
    [
        'title' => 'Junte-se a nós',
        'link' => 'https://vemprabcc.gupy.io/',
        'target' => '_blank'
    ]
];

/**
 * Função para obter o ano atual (equivalente ao currentYear do Nuxt)
 */
function get_current_year() {
    return date('Y');
}

/**
 * Função para renderizar os links do footer
 */
function render_footer_links($links) {
    $html = '';
    foreach ($links as $link) {
        $target = (strpos($link['link'], 'http') === 0) ? ' target="_blank"' : '';
        $html .= '<li><a href="' . htmlspecialchars($link['link']) . '"' . $target . '>' . htmlspecialchars($link['nomeDoCampo']) . '</a></li>';
    }
    return $html;
}

/**
 * Função para renderizar o menu principal do footer
 */
function render_footer_menu($menu) {
    $html = '';
    foreach ($menu as $item) {
        $target = isset($item['target']) ? ' target="' . $item['target'] . '"' : '';
        $html .= '<li><a href="' . htmlspecialchars($item['link']) . '"' . $target . '>' . htmlspecialchars($item['title']) . '</a></li>';
    }
    return $html;
}
?>

<?php
/**
 * Cliente GraphQL para WordPress
 */

// Incluir sistema de cache
require_once __DIR__ . '/cache-system.php';

/**
 * Substitui o $fetch do Nuxt
 */

// Endpoint centralizado
const GRAPHQL_ENDPOINT = 'https://misaelserafim.online/bcc/graphql';

/**
 * Função principal para fazer requisições GraphQL
 * Agora só precisa da query, o endpoint é fixo
 */
function graphql_query($query, $variables = []) {
    // Criar chave de cache baseada na query e variáveis
    $cacheKey = 'graphql_' . md5($query . serialize($variables));
    
    // Tentar obter do cache primeiro
    return get_cached($cacheKey, function() use ($query, $variables) {
        $data = [
            'query' => $query,
            'variables' => $variables
        ];
        
        $options = [
            'http' => [
                'header' => [
                    'Content-Type: application/json',
                    'User-Agent: BrasilCenter-PHP-Client/1.0'
                ],
                'method' => 'POST',
                'content' => json_encode($data),
                'timeout' => 15 // Reduzir timeout para 15 segundos
            ]
        ];
        
        $context = stream_context_create($options);
        
        try {
            $response = file_get_contents(GRAPHQL_ENDPOINT, false, $context);
            
            if ($response === false) {
                throw new Exception('Falha na requisição GraphQL');
        }
        
        $result = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Erro ao decodificar resposta JSON: ' . json_last_error_msg());
        }
        
        return $result;
        
    } catch (Exception $e) {
        error_log('Erro GraphQL: ' . $e->getMessage());
        return null;
    }
    }, 1800); // Cache por 30 minutos
}

/**
 * Função compatibilidade (deprecated)
 * Mantida para não quebrar código existente
 */
function graphql_fetch($endpoint, $query, $variables = []) {
    return graphql_query($query, $variables);
}

/**
 * Queries GraphQL centralizadas
 */
const QUERIES = [
    'benefits' => '
        query {
            pageBy(uri: "home") {
                home {
                    beneficios {
                        icone {
                            node {
                                sourceUrl
                            }
                        }
                        descricao
                    }
                }
            }
        }
    ',
    'cultura' => '
        query {
            pageBy(uri: "home") {
                home {
                    titulocultura
                    listaDeImagens {
                        imagem {
                            node {
                                sourceUrl
                                altText
                            }
                        }
                    }
                }
            }
        }
    ',
    'essencia' => '
        query {
            pageBy(uri: "home") {
                home {
                    tituloDe
                    videos {
                        uploadVideo {
                            node {
                                mediaItemUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    'atuacao' => '
        query {
            pageBy(uri: "home") {
                home {
                    tituloDeAtuacao
                    findOut {
                        icone {
                            node {
                                id
                                sourceUrl
                            }
                        }
                        numero
                        descricao
                    }
                }
            }
        }
    ',
    'banner' => '
        query {
            pageBy(uri: "home") {
                home {
                    fundoEmSvg {
                        node {
                            mediaItemUrl
                        }
                    }
                    fundoEmSvgMobile {
                        node {
                            mediaItemUrl
                        }
                    }
                    banner {
                        button
                        bannerAlternativo
                        link
                        text
                        title
                        icones {
                            node {
                                sourceUrl
                            }
                        }
                        image {
                            node {
                                sourceUrl
                            }
                        }
                        imageMobile {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    'sobre-banner' => '
        query {
            pageBy(uri: "sobre-bcc") {
                title
                sobreBbc {
                    fundoEmSvg {
                        node {
                            mediaItemUrl
                        }
                    }
                    fundoEmSvgMobile {
                        node {
                            mediaItemUrl
                        }
                    }
                    banner { 
                        botao    
                        descricao 
                        link     
                        titulo  
                        icone {
                            node {
                                sourceUrl
                            }
                        } 
                        bannerDesktop { 
                            node {
                                sourceUrl
                            }
                        }
                        bannerMobile {  
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'sobre-quem-somos' => '
        query {
            pageBy(uri: "sobre-bcc") {
                sobreBbc {
                    tituloSobreBbc
                    descricaoSobreBbc
                    imagemSobreBbc {
                        node {
                            sourceUrl
                        }
                    }
                }
            }
        }
    ',
    
    'sobre-conquistas' => '
        query {
            pageBy(uri: "sobre-bcc") {
                sobreBbc {
                    tituloPremio
                    conquistas {
                        descricaoDoPremio
                        premios
                        logo {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'sobre-jornada' => '
        query {
            pageBy(uri: "sobre-bcc") {
                sobreBbc {
                    historia {
                        anoInicio
                        anoFim
                        descricao
                        imagem {
                            node {
                                sourceUrl
                            }
                        }
                        imagemMobile {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'jeito-bcc-banner' => '
        query {
            pageBy(uri: "jeito-bcc") {
                jeitoBcc {
                    fundoEmSvg {
                        node {
                            mediaItemUrl
                        }
                    }
                    fundoEmSvgMobile {
                        node {
                            mediaItemUrl
                        }
                    }
                    banner {
                        botao
                        descricao
                        link
                        titulo
                        icone {
                            node {
                                sourceUrl
                            }
                        }
                        bannerMobile {
                            node {
                                sourceUrl
                            }
                        }
                        bannerDesktop {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'jeito-bcc-prioridades' => '
        query {
            pageBy(uri: "jeito-bcc") {
                jeitoBcc {
                    prioridades {
                        titulo
                        descricao
                        icone {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'jeito-bcc-projetos' => '
        query {
            pageBy(uri: "jeito-bcc") {
                jeitoBcc {
                    projetos {
                        titulo
                        descricao
                        icone {
                            node {
                                sourceUrl
                            }
                        }
                    }
                }
            }
        }
    ',
    
    'footer-links' => '
        query {
            pageBy(uri: "home") {
                id
                home {
                    links {
                        nomeDoCampo
                        link
                    }
                }
            }
        }
    '
];

/**
 * Função genérica para buscar dados da home
 */
function get_home_data($section) {
    if (!isset(QUERIES[$section])) {
        error_log("Seção GraphQL não encontrada: $section");
        return null;
    }
    
    $response = graphql_query(QUERIES[$section]);
    
    if (!$response || !isset($response['data']['pageBy']['home'])) {
        return null;
    }
    
    return $response['data']['pageBy']['home'];
}

/**
 * Função específica para buscar benefícios da home
 */
function get_home_benefits() {
    $data = get_home_data('benefits');
    return $data ? ($data['beneficios'] ?? []) : [];
}

/**
 * Função específica para buscar dados da cultura da home
 */
function get_home_cultura() {
    $data = get_home_data('cultura');
    
    if (!$data) {
        return [
            'titulo' => '',
            'imagens' => []
        ];
    }
    
    $titulo = $data['titulocultura'] ?? 'Ambientes que inspiram e conectam';
    $listaImagens = $data['listaDeImagens'] ?? [];
    
    $imagens = [];
    foreach ($listaImagens as $item) {
        if (isset($item['imagem']['node'])) {
            $imagens[] = [
                'thumbnail' => process_image_url($item['imagem']['node']['sourceUrl']),
                'alt' => $item['imagem']['node']['altText'] ?? 'Imagem da cultura Brasil Center'
            ];
        }
    }
    
    return [
        'titulo' => $titulo,
        'imagens' => $imagens
    ];
}

/**
 * Função específica para buscar vídeos da essência da home
 */
function get_home_essencia() {
    $data = get_home_data('essencia');
    
    if (!$data) {
        return [
            'titulo' => '',
            'videos' => []
        ];
    }
    
    $titulo = $data['tituloDe'] ?? 'Conheça nossa essência através dos nossos vídeos';
    $videosData = $data['videos'] ?? [];
    
    $videos = [];
    foreach ($videosData as $item) {
        if (isset($item['uploadVideo']['node']['mediaItemUrl'])) {
            $videos[] = [
                'thumbnail' => process_image_url($item['uploadVideo']['node']['mediaItemUrl'])
            ];
        }
    }
    
    return [
        'titulo' => $titulo,
        'videos' => $videos
    ];
}

/**
 * Função específica para buscar dados de atuação da home
 */
function get_home_atuacao() {
    $data = get_home_data('atuacao');
    
    if (!$data) {
        return [
            'titulo' => '',
            'items' => []
        ];
    }
    
    $titulo = $data['tituloDeAtuacao'] ?? 'Nossa atuação em números';
    $findOutData = $data['findOut'] ?? [];
    
    $items = [];
    foreach ($findOutData as $item) {
        $items[] = [
            'icon' => process_image_url($item['icone']['node']['sourceUrl'] ?? ''),
            'value' => $item['numero'] ?? '',
            'label' => $item['descricao'] ?? ''
        ];
    }
    
    return [
        'titulo' => $titulo,
        'items' => $items
    ];
}

/**
 * Função específica para buscar dados do banner da home
 */
function get_home_banner() {
    $data = get_home_data('banner');
    
    if (!$data) {
        return [
            'background' => '',
            'backgroundMobile' => '',
            'slides' => []
        ];
    }
    
    $background = $data['fundoEmSvg']['node']['mediaItemUrl'] ?? '';
    $backgroundMobile = $data['fundoEmSvgMobile']['node']['mediaItemUrl'] ?? '';
    $bannerData = $data['banner'] ?? [];
    
    $slides = [];
    foreach ($bannerData as $item) {
        $slides[] = [
            'title' => $item['title'] ?? '',
            'text' => $item['text'] ?? '',
            'button' => $item['button'] ?? '',
            'link' => $item['link'] ?? '',
            'alternativo' => $item['bannerAlternativo'] ?? false,
            'icon' => process_image_url($item['icones']['node']['sourceUrl'] ?? ''),
            'desktop' => process_image_url($item['image']['node']['sourceUrl'] ?? ''),
            'mobile' => process_image_url($item['imageMobile']['node']['sourceUrl'] ?? '')
        ];
    }
    
    return [
        'background' => process_image_url($background),
        'backgroundMobile' => process_image_url($backgroundMobile),
        'slides' => $slides
    ];
}

/**
 * Função específica para buscar dados do banner da página sobre
 */
function get_sobre_banner() {
    $query = QUERIES['sobre-banner'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['sobreBbc'])) {
        return [
            'background' => '',
            'backgroundMobile' => '',
            'banner' => []
        ];
    }
    
    $sobreBbc = $response['data']['pageBy']['sobreBbc'];
    $background = $sobreBbc['fundoEmSvg']['node']['mediaItemUrl'] ?? '';
    $backgroundMobile = $sobreBbc['fundoEmSvgMobile']['node']['mediaItemUrl'] ?? '';
    $bannerData = $sobreBbc['banner'] ?? [];
    
    $banner = [];
    if (!empty($bannerData) && is_array($bannerData) && isset($bannerData[0])) {
        // A API retorna o banner como array, pegar o primeiro item
        $bannerItem = $bannerData[0];
        $banner = [
            'titulo' => $bannerItem['titulo'] ?? '',
            'descricao' => $bannerItem['descricao'] ?? '',
            'botao' => $bannerItem['botao'] ?? '',
            'link' => $bannerItem['link'] ?? '',
            'icone' => process_image_url($bannerItem['icone']['node']['sourceUrl'] ?? ''),
            'desktop' => process_image_url($bannerItem['bannerDesktop']['node']['sourceUrl'] ?? ''),
            'mobile' => process_image_url($bannerItem['bannerMobile']['node']['sourceUrl'] ?? '')
        ];
    }
    
    return [
        'background' => process_image_url($background),
        'backgroundMobile' => process_image_url($backgroundMobile),
        'banner' => $banner
    ];
}

/**
 * Buscar dados do "Quem somos" da página sobre-bcc
 */
function get_sobre_quem_somos() {
    $query = QUERIES['sobre-quem-somos'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['sobreBbc'])) {
        return [
            'titulo' => '',
            'descricao' => '',
            'imagem' => ''
        ];
    }
    
    $sobreBbc = $response['data']['pageBy']['sobreBbc'];
    
    return [
        'titulo' => $sobreBbc['tituloSobreBbc'] ?? '',
        'descricao' => $sobreBbc['descricaoSobreBbc'] ?? '',
        'imagem' => process_image_url($sobreBbc['imagemSobreBbc']['node']['sourceUrl'] ?? '')
    ];
}

/**
 * Buscar dados das "Conquistas" da página sobre-bcc
 */
function get_sobre_conquistas() {
    $query = QUERIES['sobre-conquistas'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['sobreBbc'])) {
        return [
            'titulo' => '',
            'premios' => []
        ];
    }
    
    $sobreBbc = $response['data']['pageBy']['sobreBbc'];
    $conquistasData = $sobreBbc['conquistas'] ?? [];
    
    $premios = [];
    if (!empty($conquistasData) && is_array($conquistasData)) {
        foreach ($conquistasData as $conquista) {
            $premios[] = [
                'image' => process_image_url($conquista['logo']['node']['sourceUrl'] ?? ''),
                'title' => $conquista['premios'] ?? '',
                'text' => $conquista['descricaoDoPremio'] ?? ''
            ];
        }
    }
    
    return [
        'titulo' => $sobreBbc['tituloPremio'] ?? '',
        'premios' => $premios
    ];
}

/**
 * Buscar dados da "Jornada BCC" da página sobre-bcc
 */
function get_sobre_jornada() {
    $query = QUERIES['sobre-jornada'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['sobreBbc'])) {
        return [
            'historias' => []
        ];
    }
    
    $sobreBbc = $response['data']['pageBy']['sobreBbc'];
    $historiasData = $sobreBbc['historia'] ?? [];
    
    $historias = [];
    if (!empty($historiasData) && is_array($historiasData)) {
        foreach ($historiasData as $historia) {
            $historias[] = [
                'anoInit' => $historia['anoInicio'] ?? '',
                'anoFim' => $historia['anoFim'] ?? '',
                'text' => $historia['descricao'] ?? '',
                'image' => process_image_url($historia['imagem']['node']['sourceUrl'] ?? ''),
                'imageMobile' => process_image_url($historia['imagemMobile']['node']['sourceUrl'] ?? '')
            ];
        }
    }
    
    return [
        'historias' => $historias
    ];
}

/**
 * Buscar dados do banner da página jeito-bcc
 */
function get_jeito_bcc_banner() {
    $query = QUERIES['jeito-bcc-banner'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['jeitoBcc'])) {
        return [
            'background' => '',
            'backgroundMobile' => '',
            'banner' => []
        ];
    }
    
    $jeitoBcc = $response['data']['pageBy']['jeitoBcc'];
    $background = $jeitoBcc['fundoEmSvg']['node']['mediaItemUrl'] ?? '';
    $backgroundMobile = $jeitoBcc['fundoEmSvgMobile']['node']['mediaItemUrl'] ?? '';
    $bannerData = $jeitoBcc['banner'] ?? [];
    
    $banner = [];
    if (!empty($bannerData) && is_array($bannerData) && isset($bannerData[0])) {
        // A API retorna o banner como array, pegar o primeiro item
        $bannerItem = $bannerData[0];
        $banner = [
            'titulo' => $bannerItem['titulo'] ?? '',
            'descricao' => $bannerItem['descricao'] ?? '',
            'botao' => $bannerItem['botao'] ?? '',
            'link' => $bannerItem['link'] ?? '',
            'icone' => process_image_url($bannerItem['icone']['node']['sourceUrl'] ?? ''),
            'desktop' => process_image_url($bannerItem['bannerDesktop']['node']['sourceUrl'] ?? ''),
            'mobile' => process_image_url($bannerItem['bannerMobile']['node']['sourceUrl'] ?? '')
        ];
    }
    
    return [
        'background' => process_image_url($background),
        'backgroundMobile' => process_image_url($backgroundMobile),
        'banner' => $banner
    ];
}

/**
 * Buscar dados das "Prioridades" da página jeito-bcc
 */
function get_jeito_bcc_prioridades() {
    $query = QUERIES['jeito-bcc-prioridades'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['jeitoBcc'])) {
        return [
            'prioridades' => []
        ];
    }
    
    $jeitoBcc = $response['data']['pageBy']['jeitoBcc'];
    $prioridadesData = $jeitoBcc['prioridades'] ?? [];
    
    $prioridades = [];
    if (!empty($prioridadesData) && is_array($prioridadesData)) {
        foreach ($prioridadesData as $prioridade) {
            $prioridades[] = [
                'titulo' => $prioridade['titulo'] ?? '',
                'descricao' => $prioridade['descricao'] ?? '',
                'icone' => process_image_url($prioridade['icone']['node']['sourceUrl'] ?? '')
            ];
        }
    }
    
    return [
        'prioridades' => $prioridades
    ];
}

/**
 * Buscar dados dos "Projetos internos" da página jeito-bcc
 */
function get_jeito_bcc_projetos() {
    $query = QUERIES['jeito-bcc-projetos'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['jeitoBcc'])) {
        return [
            'projetos' => []
        ];
    }
    
    $jeitoBcc = $response['data']['pageBy']['jeitoBcc'];
    $projetosData = $jeitoBcc['projetos'] ?? [];
    
    $projetos = [];
    if (!empty($projetosData) && is_array($projetosData)) {
        foreach ($projetosData as $projeto) {
            $projetos[] = [
                'titulo' => $projeto['titulo'] ?? '',
                'descricao' => $projeto['descricao'] ?? '',
                'icone' => process_image_url($projeto['icone']['node']['sourceUrl'] ?? '')
            ];
        }
    }
    
    return [
        'projetos' => $projetos
    ];
}

/**
 * Buscar dados dos "Links" do footer
 */
function get_footer_links() {
    $query = QUERIES['footer-links'];
    $response = graphql_query($query);
    
    if (!$response || !isset($response['data']['pageBy']['home'])) {
        return [];
    }
    
    $home = $response['data']['pageBy']['home'];
    $linksData = $home['links'] ?? [];
    
    $links = [];
    if (!empty($linksData) && is_array($linksData)) {
        foreach ($linksData as $link) {
            $links[] = [
                'nomeDoCampo' => $link['nomeDoCampo'] ?? '',
                'link' => $link['link'] ?? ''
            ];
        }
    }
    
    return $links;
}

/**
 * Função para processar URL da imagem
 */
function process_image_url($url) {
    // Se a URL for absoluta (da API), usar como está
    if (strpos($url, 'http') === 0) {
        return $url;
    }
    
    // Se for relativa, ajustar para o projeto local
    return $url;
}
?>


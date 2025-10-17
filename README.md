# 📖 Site BrasilCenter - Documentação Técnica

> Sistema web moderno desenvolvido em PHP com integração WordPress via GraphQL

![BrasilCenter](https://www.brasilcenter.com.br/images/logo-brasil-center.png)

## 🎯 Visão Geral

O site da BrasilCenter foi desenvolvido com foco em **performance**, **facilidade de manutenção** e **experiência do usuário**.

### ✨ Características Principais
- Sistema de cache inteligente para velocidade
- Conteúdo gerenciado via WordPress
- Design responsivo e acessível
- Integração automática de dados
- Estrutura modular e organizada

### 🔄 Como Funciona
1. **Usuário acessa** uma página (index.php, sobre.php, etc.)
2. **Sistema verifica** se tem dados salvos no cache
3. **Se não tem cache,** busca dados do WordPress via GraphQL
4. **Monta a página** com os dados e exibe para o usuário
5. **Salva no cache** para próximas visitas serem rápidas

## 💻 Tecnologias Utilizadas

### 🛠️ Stack Principal
- **PHP 8.0+** - Backend e lógica do servidor
- **HTML5** - Estrutura das páginas
- **CSS3** - Estilos e layout responsivo
- **JavaScript ES6** - Interações e animações

### 📚 Bibliotecas
- **GSAP** - Animações avançadas
- **Swiper.js** - Carrosséis e sliders
- **WordPress GraphQL** - Integração de dados

### 🔧 Ferramentas
- **Google Tag Manager** - Análise e métricas
- **HandTalk** - Acessibilidade para surdos
- **Sistema de Cache** - Performance otimizada

## ⚙️ Requisitos Técnicos

### 🖥️ Servidor Web
- Apache 2.4+, IIS 8.0+
- Suporte a URL Rewrite
- PHP 8.0+ com extensões: json, curl, openssl

### 📁 Permissões Necessárias
- Pasta `cache/` com permissão de escrita
- Arquivos PHP com permissão de leitura

## 🚀 Deploy do Site

O processo de deploy é **simples e direto** - basta colocar os arquivos no servidor.

### 📋 Passo a Passo
1. **Upload dos Arquivos:** Envie para a raiz do servidor todos os arquivos do site
2. **Configuração Automática:** O arquivo `web.config` já vem configurado com o site
3. **Permissões:** Certifique-se que a pasta `cache/` tem permissão de escrita

### 📁 O que Acontece no Deploy
- **Arquivos PHP** são executados automaticamente pelo servidor
- **Web.config** configura URLs amigáveis e cache
- **Pasta cache/** é criada automaticamente se não existir

## 📁 Estrutura de Arquivos

```
www/
├── 📄 index.php              # Página inicial
├── 📄 sobre.php              # Página sobre a empresa
├── 📄 jeito-bcc.php          # Página jeito BCC
├── 📁 assets/                # Recursos estáticos (SVG, imagens)
├── 📁 cache/                 # Sistema de cache (*.cache)
├── 📁 css/                   # Folhas de estilo
│   ├── styles.css            # Estilos principais
│   ├── sobre-bcc.css         # Estilos página sobre
│   └── jeito-bcc.css         # Estilos página jeito BCC
├── 📁 js/                    # Scripts JavaScript
│   ├── scripts.js            # Scripts principais
│   ├── index.js              # Scripts da home
│   ├── sobre-bcc.js          # Scripts página sobre
│   └── jeito-bcc.js          # Scripts página jeito BCC
├── 📁 includes/              # Arquivos PHP incluídos
│   ├── header.php            # Cabeçalho
│   ├── footer.php            # Rodapé
│   ├── cache-system.php      # Sistema de cache
│   ├── graphql-client.php    # Cliente GraphQL
│   └── 📁 components/        # Componentes modulares
│       ├── banner.php        # Banner principal
│       ├── instagram.php     # Seção Instagram
│       ├── nossa-cultura.php # Seção cultura
│       └── [outros...]       # Demais componentes
├── 📁 images/                # Imagens do site
└── 📁 libs/                  # Bibliotecas externas
    ├── gsap/                 # Animações GSAP
    └── swiper/               # Carrossel Swiper
```

## ⚡ Sistema de Cache

O cache é uma **"memória temporária"** que torna o site muito mais rápido, evitando buscar dados do WordPress a cada visita.

### Como Funciona
- **Primeira visita:** Busca dados do WordPress (demora um pouco)
- **Salva na pasta cache/** por 30 minutos
- **Próximas visitas:** Usa dados salvos (muito rápido)
- **Após 30 min:** Cache expira, busca dados novos

### 🧹 Como Limpar o Cache
**Quando conteúdo não atualiza:**
1. Entre na pasta "/cache/ na raiz do site (www)"
2. Delete todos os arquivos .cache
3. Próxima visita buscará dados atualizados

## ✏️ Como Fazer Alterações

### 📝 Alterações de Conteúdo (WordPress)
Para alterar **textos, imagens e vídeos**, acesse o painel do WordPress:

**🔗 Link:** **********

- **HOME:** Páginas → Home → (Banner, Lista de Imagens, Vídeos, Find Out)
- **SOBRE:** Páginas → Sobre BCC → (Banner, História, Conquistas)
- **JEITO BCC:** Páginas → Jeito BCC → (Banner, Prioridades, Projetos)

### ⚙️ Alterações de Layout e Funcionalidades
Para alterar **código, estilos e funcionalidades:**

- **Páginas principais:** `index.php`, `sobre.php`, `jeito-bcc.php`
- **Componentes:** `includes/components/nomedoarquivo.php`
- **Estilos:** `css/styles.css` (geral) ou arquivos específicos
- **JavaScript:** `js/scripts.js` ou arquivos específicos

### 🔄 Após Fazer Alterações
- **WordPress:** Aguarde 30 minutos OU limpe o cache
- **Código/CSS:** Teste em diferentes navegadores
- **Sempre:** Faça backup antes de mudanças importantes

## 🔗 API e Endpoints

### Configuração
- **Tempo limite:** 15 segundos para resposta
- **Cache:** Dados ficam salvos por 30 minutos

### Queries Disponíveis

| Função | Página | Busca no WordPress | Retorna |
|--------|--------|-------------------|---------|
| `get_home_banner()` | HOME | Páginas → Home → Banner | title, text, button, link, images |
| `get_home_cultura()` | HOME | Páginas → Home → Lista de Imagens | titulo, array de imagens |
| `get_home_essencia()` | HOME | Páginas → Home → Vídeos | titulo, array de vídeos |
| `get_home_atuacao()` | HOME | Páginas → Home → Find Out | titulo, items (icon, value, label) |
| `get_home_benefits()` | HOME | Páginas → Home → Benefícios | array com icone, descricao |
| `get_sobre_banner()` | SOBRE | Páginas → Sobre BCC → Banner | titulo, descricao, botao, link |
| `get_sobre_quem_somos()` | SOBRE | Páginas → Sobre BCC → Quem Somos | titulo, descricao, imagem |
| `get_sobre_conquistas()` | SOBRE | Páginas → Sobre BCC → Conquistas | titulo, premios (image, title, text) |
| `get_sobre_jornada()` | SOBRE | Páginas → Sobre BCC → História | historias (anos, text, image) |
| `get_jeito_bcc_banner()` | JEITO BCC | Páginas → Jeito BCC → Banner | titulo, descricao, botao, link |
| `get_jeito_bcc_prioridades()` | JEITO BCC | Páginas → Jeito BCC → Prioridades | titulo, array de prioridades |
| `get_jeito_bcc_projetos()` | JEITO BCC | Páginas → Jeito BCC → Projetos | titulo, projetos com images |

**🔄 Cache:** Todas as queries têm cache de 30 minutos

## 🔧 Configurações Importantes

### 📊 Google Tag Manager
- **Localização:** `includes/head-config.php`
- **Como alterar:** Substitua o ID do GTM na variável correspondente

### ♿ HandTalk (Acessibilidade)
- **Localização:** `includes/footer.php`
- **Token:** Altere o token do HandTalk na configuração do script
- **Como alterar:** Localize a seção HandTalk e substitua o token de acesso

### 🔗 Endpoint GraphQL
- **Localização:** `includes/graphql-client.php`
- **Endpoint:** Altere a URL do WordPress GraphQL
- **Como alterar:** Modifique a constante `GRAPHQL_ENDPOINT`

## 📋 Documentação Completa

Para acessar a documentação técnica completa com todos os detalhes, abra o arquivo:
```
documentacao-tecnica-versao-html.html
```

**Desenvolvido para BrasilCenter** | Setembro 2025

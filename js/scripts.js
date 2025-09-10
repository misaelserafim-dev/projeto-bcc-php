// Scripts principais do site Brasil Center

document.addEventListener('DOMContentLoaded', function() {
    // Variáveis globais
    let mobileView = false;
    let menuOpen = false;
    
    // Elementos DOM
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const navMenu = document.getElementById('nav-menu');
    const mobileCta = document.getElementById('mobile-cta');
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Função para alternar menu mobile
    const toggleMenu = () => {
        menuOpen = !menuOpen;
        mobileMenuBtn.classList.toggle('active', menuOpen);
        navMenu.classList.toggle('menu-open', menuOpen);
        
        // Adicionar classe ao body para prevenir scroll quando menu aberto
        document.body.classList.toggle('menu-open', menuOpen);
    };
    
    // Função para fechar menu
    const closeMenu = () => {
        if (menuOpen) {
            menuOpen = false;
            mobileMenuBtn.classList.remove('active');
            navMenu.classList.remove('menu-open');
            document.body.classList.remove('menu-open');
        }
    };
    
    // Função para detectar se é mobile/tablet
    const handleResize = () => {
        const wasMobile = mobileView;
        mobileView = window.innerWidth <= 1180;
        
        // Mostrar/ocultar elementos baseado no tamanho da tela
        if (mobileView) {
            mobileMenuBtn.style.display = 'flex';
            mobileCta.style.display = 'flex';
        } else {
            mobileMenuBtn.style.display = 'none';
            mobileCta.style.display = 'none';
            closeMenu(); // Fechar menu se mudou para desktop
        }
        
        // Se mudou de mobile para desktop, limpar classes
        if (wasMobile && !mobileView) {
            closeMenu();
        }
    };
    
    // Marcar link ativo baseado na página atual
    const setActiveLink = () => {
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            link.classList.remove('active-link');
            
            // Verificar se o link corresponde à página atual
            const linkPath = new URL(link.href).pathname;
            if (currentPath === linkPath || 
                (currentPath === '/' && linkPath === '/') ||
                (currentPath.includes('sobre-bcc') && linkPath.includes('sobre-bcc')) ||
                (currentPath.includes('jeito-bcc') && linkPath.includes('jeito-bcc'))) {
                link.classList.add('active-link');
            }
        });
    };
    
    // Event listeners
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', toggleMenu);
    }
    
    // Fechar menu ao clicar nos links
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // Se for link interno, fechar menu
            if (!link.hasAttribute('target')) {
                closeMenu();
            }
        });
    });
    
    // Fechar menu ao clicar fora dele
    document.addEventListener('click', (e) => {
        if (menuOpen && !navMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
            closeMenu();
        }
    });
    
    // Fechar menu com tecla ESC
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menuOpen) {
            closeMenu();
        }
    });
    
    // Event listener para resize
    window.addEventListener('resize', handleResize);
    
    // Inicialização
    handleResize();
    setActiveLink();
    
    console.log('Brasil Center - Header carregado com funcionalidade completa');
});

// Função para inicializar Swipers
function initializeSwipers() {
    // Inicializar todos os swipers encontrados na página (exceto os que já têm data-swiper-config)
    const swipers = document.querySelectorAll('.swiper:not([data-swiper-initialized]):not([data-swiper-config])');
    
    swipers.forEach((swiperElement, index) => {
        // Configuração padrão do Swiper
        const swiperConfig = {
            // Navegação
            navigation: {
                nextEl: swiperElement.querySelector('.swiper-button-next'),
                prevEl: swiperElement.querySelector('.swiper-button-prev'),
            },
            
            // Paginação
            pagination: {
                el: swiperElement.querySelector('.swiper-pagination'),
                clickable: true,
            },
            
            // Scrollbar
            scrollbar: {
                el: swiperElement.querySelector('.swiper-scrollbar'),
            },
            
            // Configurações responsivas
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40
                }
            },
            
            // Loop infinito
            loop: true,
            
            // Autoplay (opcional)
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            }
        };
        
        // Verificar se tem configuração específica no data attribute
        const customConfig = swiperElement.dataset.swiperConfig;
        if (customConfig) {
            try {
                const parsedConfig = JSON.parse(customConfig);
                Object.assign(swiperConfig, parsedConfig);
            } catch (e) {
                console.warn('Configuração Swiper inválida:', customConfig);
            }
        }
        
        // Inicializar o Swiper
        new Swiper(swiperElement, swiperConfig);
        console.log(`Swiper ${index + 1} inicializado`);
    });
}

// Aguardar o carregamento do Swiper antes de inicializar
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se o Swiper foi carregado
    if (typeof Swiper !== 'undefined') {
        initializeSwipers();
    } else {
        console.warn('Swiper não foi carregado');
    }
});

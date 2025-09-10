/**
 * Scripts específicos para a página INDEX
 * Contém todos os scripts dos componentes incluídos na index.php
 */

// ===========================================
// COMPONENTE: ATUAÇÃO - Animação de números
// ===========================================
let gsapLoaded = false;
let scrollTriggerLoaded = false;
let numberRefs = {};
let animatedValues = {};

function checkGSAPAndInitialize() {
    gsapLoaded = typeof gsap !== 'undefined';
    scrollTriggerLoaded = typeof ScrollTrigger !== 'undefined';
    
    if (gsapLoaded && scrollTriggerLoaded) {
        initializeAtuacaoAnimations();
    } else {
        console.warn('GSAP ou ScrollTrigger não carregados ainda');
        // Tentar novamente após um pequeno delay
        setTimeout(checkGSAPAndInitialize, 500);
    }
}

function initializeAtuacaoAnimations() {
    if (scrollTriggerLoaded) {
        gsap.registerPlugin(ScrollTrigger);
    }
    
    const numberElements = document.querySelectorAll('#atuacao .number-element');
    numberElements.forEach((element, index) => {
        numberRefs[index] = element;
        animatedValues[index] = null;
    });
    
    console.log(`Atuação inicializada com ${numberElements.length} números para animar`);
    setupNumberScrollTriggers();
}

function animateNumber(index, rawValue) {
    if (!gsapLoaded || animatedValues[index]) return;
    
    const element = numberRefs[index];
    if (!element) return;
    
    const match = rawValue.match(/([\+\-]?\d+)(\s*\w*)?/);
    if (!match) {
        element.textContent = rawValue;
        animatedValues[index] = rawValue;
        return;
    }
    
    const number = parseInt(match[1]);
    const suffix = match[2] || '';
    
    const obj = { val: 0 };
    gsap.to(obj, {
        val: number,
        duration: 2,
        ease: 'power1.out',
        onUpdate: () => {
            const formatted = new Intl.NumberFormat('pt-BR').format(Math.floor(obj.val));
            const prefix = rawValue.startsWith('+') ? '+' : '';
            element.textContent = `${prefix}${formatted}${suffix}`;
        },
        onComplete: () => {
            element.textContent = rawValue;
            animatedValues[index] = rawValue;
        }
    });
}

function setupNumberScrollTriggers() {
    if (!scrollTriggerLoaded) return;
    
    const numberElements = Object.values(numberRefs);
    if (numberElements.length === 0) return;
    
    ScrollTrigger.batch(numberElements, {
        onEnter: batch => {
            batch.forEach((el) => {
                const index = Object.keys(numberRefs).find(key => numberRefs[key] === el);
                if (index !== undefined && !animatedValues[index]) {
                    const rawValue = el.getAttribute('data-original-value') || el.textContent;
                    animateNumber(parseInt(index), rawValue);
                }
            });
        },
        start: 'top 85%',
        once: true
    });
}

function refreshScrollTriggers() {
    if (scrollTriggerLoaded) {
        ScrollTrigger.refresh();
    }
}

// ===========================================
// COMPONENTE: NOSSA ESSÊNCIA - Vídeos
// ===========================================
let videoRefs = {};
let selectedVideo = null;
let hoverIndex = null;
let defaultActive = 0;

function initializeVideoControls() {
    const videoElements = document.querySelectorAll('#essencia video');
    const playButtons = document.querySelectorAll('#essencia .play-button');
    const carouselItems = document.querySelectorAll('#essencia .carousel-item');
    
    // Inicializar referências de vídeo
    videoElements.forEach((video, index) => {
        videoRefs[index] = video;
    });
    
    // Event listeners para botões de play
    playButtons.forEach((button, index) => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleFixed(index);
        });
    });
    
    // Event listeners para hover nos itens do carrossel
    carouselItems.forEach((item, index) => {
        item.addEventListener('mouseenter', () => {
            hoverIndex = index;
            updateActiveStates();
        });
        
        item.addEventListener('mouseleave', () => {
            hoverIndex = null;
            updateActiveStates();
        });
    });
    
    // Definir estado inicial
    updateActiveStates();
    
    console.log('Nossa Essência inicializada com', videoElements.length, 'vídeos');
}

function toggleFixed(index) {
    const video = videoRefs[index];
    if (!video) return;
    
    const playButton = document.querySelector(`#essencia .play-button[data-video-index="${index}"]`);
    const playIcon = playButton ? playButton.querySelector('.play-icon') : null;
    const pauseIcon = playButton ? playButton.querySelector('.pause-icon') : null;
    
    if (selectedVideo === index) {
        // Se já está ativo, desativa
        video.pause();
        video.currentTime = 0;
        selectedVideo = null;
        
        // Atualizar ícones
        if (playIcon) playIcon.style.display = 'inline';
        if (pauseIcon) pauseIcon.style.display = 'none';
    } else {
        // Parar todos os outros vídeos
        Object.entries(videoRefs).forEach(([i, v]) => {
            if (v && parseInt(i) !== index) {
                v.pause();
                v.currentTime = 0;
                
                // Resetar ícones dos outros vídeos
                const otherButton = document.querySelector(`#essencia .play-button[data-video-index="${i}"]`);
                if (otherButton) {
                    const otherPlayIcon = otherButton.querySelector('.play-icon');
                    const otherPauseIcon = otherButton.querySelector('.pause-icon');
                    if (otherPlayIcon) otherPlayIcon.style.display = 'inline';
                    if (otherPauseIcon) otherPauseIcon.style.display = 'none';
                }
            }
        });
        
        selectedVideo = index;
        video.muted = false;
        video.play().catch(() => {});
        
        // Atualizar ícones
        if (playIcon) playIcon.style.display = 'none';
        if (pauseIcon) pauseIcon.style.display = 'inline';
    }
    
    updateActiveStates();
}

function updateActiveStates() {
    const carouselItems = document.querySelectorAll('#essencia .carousel-item');
    
    carouselItems.forEach((item, index) => {
        const isActive = hoverIndex !== null ? hoverIndex === index : 
                        (selectedVideo !== null ? selectedVideo === index : defaultActive === index);
        
        if (isActive) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

// ===========================================
// COMPONENTE: NOSSA CULTURA - Grid de imagens
// ===========================================
function initializeNossaCultura() {
    const images = document.querySelectorAll('#nossacultura .item');
    
    images.forEach((img, index) => {
        img.addEventListener('load', function() {
            setTimeout(() => {
                this.classList.add('loaded');
            }, index * 100); // Delay escalonado para efeito cascata
        });
        
        // Se a imagem já foi carregada
        if (img.complete) {
            setTimeout(() => {
                img.classList.add('loaded');
            }, index * 100);
        }
        
        // Hover effect
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    console.log('Nossa Cultura inicializada com', images.length, 'imagens');
}

// ===========================================
// COMPONENTE: INSTAGRAM - Widget
// ===========================================
let instagramWidgetLoaded = false;
let instagramWidgetLoading = false;

function loadInstagramWidget() {
    if (instagramWidgetLoaded || instagramWidgetLoading) {
        console.log('Instagram widget já carregado ou carregando');
        return;
    }
    
    instagramWidgetLoading = true;
    console.log('Carregando Instagram widget...');
    
    const feedContainer = document.querySelector('.sk-instagram-feed');
    if (feedContainer) {
        feedContainer.innerHTML = '<div class="instagram-loading" style="text-align: center; padding: 40px; color: #666;"><p>Carregando feed do Instagram...</p><div style="margin-top: 10px;"><div style="display: inline-block; width: 20px; height: 20px; border: 3px solid #f3f3f3; border-top: 3px solid #007bff; border-radius: 50%; animation: spin 1s linear infinite;"></div></div></div>';
    }
    
    const existingScript = document.getElementById('sociablekit-script');
    if (existingScript) {
        existingScript.remove();
    }
    
    const script = document.createElement('script');
    script.id = 'sociablekit-script';
    script.src = 'https://widgets.sociablekit.com/instagram-feed/widget.js';
    script.defer = true;
    
    script.onload = function() {
        console.log('Instagram widget carregado com sucesso');
        instagramWidgetLoaded = true;
        instagramWidgetLoading = false;
    };
    
    script.onerror = function() {
        console.error('Erro ao carregar Instagram widget');
        instagramWidgetLoading = false;
        if (feedContainer) {
            feedContainer.innerHTML = '<p style="text-align: center; color: #666; padding: 40px;">Erro ao carregar feed do Instagram</p>';
        }
    };
    
    document.body.appendChild(script);
}

// ===========================================
// FUNÇÃO UTILITÁRIA PARA SWIPER
// ===========================================
function initializeSwiperSafely(selector, componentName) {
    const swiperElement = document.querySelector(selector);
    if (!swiperElement) {
        console.warn(`Elemento Swiper não encontrado: ${selector}`);
        return false;
    }
    
    if (typeof Swiper === 'undefined') {
        console.error('Biblioteca Swiper não carregada');
        return false;
    }
    
    // Verificar se já foi inicializado
    if (swiperElement.swiper || swiperElement.hasAttribute('data-swiper-initialized')) {
        console.log(`Swiper ${componentName} já foi inicializado`);
        return true;
    }
    
    // Verificar se tem wrapper
    const wrapper = swiperElement.querySelector('.swiper-wrapper');
    if (!wrapper) {
        console.error(`Swiper ${componentName}: .swiper-wrapper não encontrado`);
        return false;
    }
    
    try {
        const configString = swiperElement.dataset.swiperConfig || '{}';
        const swiperConfig = JSON.parse(configString);
        
        console.log(`Inicializando Swiper ${componentName} com config:`, swiperConfig);
        
        // Marcar como inicializado para evitar dupla inicialização
        swiperElement.setAttribute('data-swiper-initialized', 'true');
        
        // Inicializar Swiper
        const swiperInstance = new Swiper(swiperElement, swiperConfig);
        console.log(`Swiper ${componentName} inicializado com sucesso`);
        return true;
    } catch (error) {
        console.error(`Erro ao inicializar Swiper ${componentName}:`, error);
        // Remover atributo se falhou
        swiperElement.removeAttribute('data-swiper-initialized');
        return false;
    }
}

// ===========================================
// COMPONENTE: SOBRE HOME - Scroll Sticky
// ===========================================
let sobreHomeContext = null;

function setupSobreHomeScrollTrigger() {
    if (!gsapLoaded || !scrollTriggerLoaded) {
        console.warn('GSAP ou ScrollTrigger não carregados para Sobre Home');
        return;
    }
    
    const containerSobre = document.querySelector('[data-container-sobre]');
    const stickyTitleSobre = document.querySelector('[data-sticky-title-sobre]');
    const scrollContentSobre = document.querySelector('[data-scroll-content]');
    
    if (!containerSobre || !stickyTitleSobre || !scrollContentSobre) {
        console.log('Elementos do Sobre Home não encontrados');
        return;
    }
    
    // Limpar contexto anterior se existir
    if (sobreHomeContext) {
        sobreHomeContext.revert();
    }
    
    // Só aplicar o efeito em desktop (>= 1024px)
    if (window.innerWidth >= 1024) {
        sobreHomeContext = gsap.context(() => {
            ScrollTrigger.create({
                trigger: stickyTitleSobre,
                start: 'center center',
                end: () => `${containerSobre.offsetHeight - stickyTitleSobre.offsetHeight - 800} / 2`,
                pin: stickyTitleSobre,
                scrub: true,
                anticipatePin: 1,
                markers: false, // Mude para true para debug
                onUpdate: (self) => {
                    // Log opcional para debug
                    // console.log('Scroll progress:', self.progress);
                }
            });
            
            console.log('Sobre Home ScrollTrigger configurado');
        }, containerSobre);
    } else {
        console.log('Sobre Home ScrollTrigger não aplicado (tela < 1024px)');
    }
}

// ===========================================
// COMPONENTE: ATUAÇÃO - Scroll Sticky
// ===========================================
let atuacaoContext = null;

function setupAtuacaoScrollTrigger() {
    if (!gsapLoaded || !scrollTriggerLoaded) {
        console.warn('GSAP ou ScrollTrigger não carregados para Atuação');
        return;
    }
    
    const containerAtuacao = document.querySelector('[data-container-atuacao]');
    const stickyTitleAtuacao = document.querySelector('[data-sticky-title-atuacao]');
    const scrollContentAtuacao = document.querySelector('[data-scroll-content-atuacao]');
    
    if (!containerAtuacao || !stickyTitleAtuacao || !scrollContentAtuacao) {
        console.log('Elementos da Atuação não encontrados');
        return;
    }
    
    // Limpar contexto anterior se existir
    if (atuacaoContext) {
        atuacaoContext.revert();
    }
    
    // Só aplicar o efeito em desktop (>= 1024px)
    if (window.innerWidth >= 1024) {
        atuacaoContext = gsap.context(() => {
            ScrollTrigger.create({
                trigger: stickyTitleAtuacao,
                start: 'center center',
                end: () => `${containerAtuacao.offsetHeight - stickyTitleAtuacao.offsetHeight - 400} / 2`,
                pin: stickyTitleAtuacao,
                scrub: true,
                anticipatePin: 1,
                markers: false, // Mude para true para debug
                onUpdate: (self) => {
                    // Log opcional para debug
                    // console.log('Atuação scroll progress:', self.progress);
                }
            });
            
            console.log('Atuação ScrollTrigger configurado');
        }, containerAtuacao);
    } else {
        console.log('Atuação ScrollTrigger não aplicado (tela < 1024px)');
    }
}

// ===========================================
// COMPONENTE: NOSSA GENTE - Animação de Imagens
// ===========================================
function setupNossaGenteAnimations() {
    if (!gsapLoaded || !scrollTriggerLoaded) {
        console.warn('GSAP ou ScrollTrigger não carregados para Nossa Gente');
        return;
    }
    
    const animatedImages = document.querySelectorAll('#nossagente .img-animate-up');
    
    if (animatedImages.length === 0) {
        console.log('Imagens do Nossa Gente não encontradas');
        return;
    }
    
    // Configurar estado inicial das imagens (invisíveis e deslocadas para baixo)
    gsap.set(animatedImages, {
        y: 100,
        opacity: 0
    });
    
    // Criar animação para cada imagem
    animatedImages.forEach((img, index) => {
        ScrollTrigger.create({
            trigger: img,
            start: 'top 85%',
            end: 'bottom 20%',
            once: true, // Animar apenas uma vez
            onEnter: () => {
                gsap.to(img, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: index * 0.2, // Delay escalonado entre as imagens
                    ease: 'power2.out'
                });
            }
        });
    });
    
    console.log(`Nossa Gente: ${animatedImages.length} imagens configuradas para animação`);
}

// ===========================================
// INICIALIZAÇÃO GERAL DA PÁGINA INDEX
// ===========================================
document.addEventListener('DOMContentLoaded', function() {
    // Aguardar um pouco para garantir que scripts.js termine de executar
    setTimeout(function() {
        console.log('Inicializando scripts da página INDEX');
        
        // Verificar se estamos na página inicial
        const currentPath = window.location.pathname;
        const isHomePage = currentPath === '/' || 
                          currentPath === '/index.php' || 
                          currentPath.endsWith('/brasilcenter/') || 
                          currentPath.endsWith('/brasilcenter/index.php');
        
        if (!isHomePage) {
            console.log('Não é a página inicial, scripts não serão executados');
            return;
        }
        
        initializeIndexComponents();
    }, 100);
});

function initializeIndexComponents() {
    
    // Inicializar componentes se existirem na página
    
    // 1. Banner (carrossel principal)
    if (document.querySelector('.Banner')) {
        console.log('Componente Banner encontrado, inicializando...');
        const bannerInitialized = initializeSwiperSafely('.Banner .mySwiper', 'Banner');
        
        // Verificar se os bullets foram criados
        if (bannerInitialized) {
            setTimeout(() => {
                const bullets = document.querySelectorAll('.Banner .banner-pagination .swiper-pagination-bullet');
                console.log(`Banner bullets criados: ${bullets.length}`);
                if (bullets.length === 0) {
                    console.warn('Banner: Bullets não foram criados. Verifique a configuração da paginação.');
                }
            }, 500);
        }
    }
    
    // 2. Sobre Home (seção inicial)
    if (document.querySelector('#sobreHome')) {
        console.log('Componente Sobre Home encontrado, inicializando...');
        // Aguardar GSAP carregar antes de configurar ScrollTrigger
        setTimeout(() => {
            setupSobreHomeScrollTrigger();
        }, 200);
    }
    
    // 3. Atuação (números animados)
    if (document.querySelector('#atuacao')) {
        console.log('Componente Atuação encontrado, inicializando...');
        // Salvar valores originais antes da animação
        const numberElements = document.querySelectorAll('#atuacao .number-element');
        numberElements.forEach((element, index) => {
            element.setAttribute('data-original-value', element.textContent);
        });
        checkGSAPAndInitialize();
        
        // Configurar scroll sticky após pequeno delay
        setTimeout(() => {
            setupAtuacaoScrollTrigger();
        }, 300);
    }
    
    // 4. Nossa Essência (vídeos)
    if (document.querySelector('#essencia')) {
        console.log('Componente Nossa Essência encontrado, inicializando...');
        initializeVideoControls();
        
        // Inicializar Swiper se disponível
        initializeSwiperSafely('#essencia .carousel-container', 'Nossa Essência');
    }
    
    // 5. Nossa Gente (animação de imagens)
    if (document.querySelector('#nossagente')) {
        console.log('Componente Nossa Gente encontrado, inicializando...');
        setTimeout(() => {
            setupNossaGenteAnimations();
        }, 200);
    }
    
    // 6. Nossa Cultura (grid de imagens)
    if (document.querySelector('#nossacultura')) {
        console.log('Componente Nossa Cultura encontrado, inicializando...');
        initializeNossaCultura();
    }
    
    // 7. Apoio (Swiper de benefícios)
    if (document.querySelector('#apoio')) {
        console.log('Componente Apoio encontrado, inicializando...');
        initializeSwiperSafely('#apoio .swiper', 'Apoio');
    }
    
    // 8. Instagram (widget)
    if (document.querySelector('#instagram')) {
        console.log('Componente Instagram encontrado, inicializando...');
        // Delay para garantir que outros scripts carregaram
        setTimeout(() => {
            loadInstagramWidget();
        }, 1000);
    }
}

// Refresh ScrollTrigger quando a janela redimensionar
window.addEventListener('resize', function() {
    setTimeout(() => {
        refreshScrollTriggers();
        // Reconfigurar scroll sticky do Sobre Home
        if (document.querySelector('#sobreHome')) {
            setupSobreHomeScrollTrigger();
        }
        // Reconfigurar scroll sticky da Atuação
        if (document.querySelector('#atuacao')) {
            setupAtuacaoScrollTrigger();
        }
    }, 100);
});

// Cleanup quando sair da página
window.addEventListener('beforeunload', function() {
    if (scrollTriggerLoaded) {
        ScrollTrigger.killAll();
    }
    if (sobreHomeContext) {
        sobreHomeContext.revert();
    }
    if (atuacaoContext) {
        atuacaoContext.revert();
    }
});

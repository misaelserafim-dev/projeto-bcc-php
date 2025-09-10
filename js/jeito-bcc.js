/**
 * Scripts específicos para a página JEITO-BCC
 */

// Função para inicializar Swiper de forma segura
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
// COMPONENTE: ATMOSFERA BCC - Animação Diagonal
// ===========================================
function setupAtmosferaBccAnimations() {
    // Verificar se GSAP e ScrollTrigger estão carregados
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP ou ScrollTrigger não carregados para Atmosfera BCC');
        return;
    }
    
    const animatedElements = document.querySelectorAll('#atmosfera .animate-diagonal');
    
    if (animatedElements.length === 0) {
        console.log('Elementos animados da Atmosfera BCC não encontrados');
        return;
    }
    
    // Configurar estado inicial dos elementos (invisíveis, deslocados para baixo e direita)
    gsap.set(animatedElements, {
        x: 100, // Deslocado para a direita
        y: 80,  // Deslocado para baixo
        opacity: 0
    });
    
    // Criar animação para cada elemento
    animatedElements.forEach((element, index) => {
        ScrollTrigger.create({
            trigger: element,
            start: 'top 85%',
            end: 'bottom 20%',
            once: true, // Animar apenas uma vez
            onEnter: () => {
                gsap.to(element, {
                    x: 0,      // Move da direita para posição original
                    y: 0,      // Move de baixo para posição original
                    opacity: 1,
                    duration: 1.0, // Um pouco mais lento para o efeito diagonal
                    delay: index * 0.2,
                    ease: 'power2.out'
                });
            }
        });
    });
    
    console.log(`Atmosfera BCC: ${animatedElements.length} elementos configurados para animação diagonal`);
}

// ===========================================
// COMPONENTE: PRIORIDADES - Efeito Parallax
// ===========================================
let prioridadesParallaxContext = null;

function setupPrioridadesParallax() {
    // Verificar se GSAP e ScrollTrigger estão carregados
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP ou ScrollTrigger não carregados para Prioridades Parallax');
        return;
    }
    
    const containerPrioridades = document.querySelector('[data-container-prioridades]');
    const parallaxImage = document.querySelector('[data-parallax-image]');
    const scrollContentPrioridades = document.querySelector('[data-scroll-content-prioridades]');
    
    if (!containerPrioridades || !parallaxImage || !scrollContentPrioridades) {
        console.log('Elementos do Prioridades Parallax não encontrados');
        return;
    }
    
    // Limpar contexto anterior se existir
    if (prioridadesParallaxContext) {
        prioridadesParallaxContext.revert();
    }
    
    // Só aplicar o efeito em desktop (>= 1024px)
    if (window.innerWidth >= 1024) {
        prioridadesParallaxContext = gsap.context(() => {
            ScrollTrigger.create({
                trigger: scrollContentPrioridades,
                start: 'top bottom',
                end: 'bottom top',
                scrub: 1, // Movimento suave sincronizado com o scroll
                onUpdate: (self) => {
                    // Mover a imagem para baixo conforme o scroll (efeito parallax)
                    const yPos = self.progress * 200; // Movimento de 0 a 200px
                    gsap.set(parallaxImage, {
                        y: yPos,
                        ease: 'none'
                    });
                }
            });
            
            console.log('Prioridades Parallax configurado');
        }, containerPrioridades);
    } else {
        console.log('Prioridades Parallax não aplicado (tela < 1024px)');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Scripts da página Jeito BCC carregados');
    
    // Aguardar um pouco para garantir que scripts.js terminou
    setTimeout(() => {
        // Verificar se há banner na página
        const banner = document.querySelector('.Banner');
        if (banner) {
            console.log('Banner Jeito BCC encontrado, inicializando Swiper...');
            
            // Inicializar Swiper do banner
            const bannerSwiper = banner.querySelector('.swiper[data-swiper-config]');
            if (bannerSwiper) {
                initializeSwiperSafely('.Banner .swiper[data-swiper-config]', 'Banner Jeito BCC');
            }
        }
        
        // Verificar se há componente Projetos internos na página
        const projetosInternos = document.querySelector('section:has(.card-content-project)');
        if (projetosInternos) {
            console.log('Componente Projetos internos encontrado, inicializando Swiper...');
            
            // Inicializar Swiper dos projetos internos
            const projetosSwiper = projetosInternos.querySelector('.swiper[data-swiper-config]');
            if (projetosSwiper) {
                initializeSwiperSafely('section:has(.card-content-project) .swiper[data-swiper-config]', 'Projetos internos');
            }
        }
        
        // Verificar se há componente Atmosfera BCC na página
        const atmosferaBcc = document.querySelector('#atmosfera');
        if (atmosferaBcc) {
            console.log('Componente Atmosfera BCC encontrado, inicializando animações...');
            
            // Aguardar um pouco para garantir que GSAP carregou
            setTimeout(() => {
                setupAtmosferaBccAnimations();
            }, 200);
        }
        
        // Verificar se há componente Prioridades na página
        const prioridadesBcc = document.querySelector('#prioridades');
        if (prioridadesBcc) {
            console.log('Componente Prioridades encontrado, inicializando parallax...');
            
            // Aguardar um pouco para garantir que GSAP carregou
            setTimeout(() => {
                setupPrioridadesParallax();
            }, 300);
        }
        
        // Adicionar outras funcionalidades específicas da página jeito-bcc aqui
    }, 100);
});

// Refresh efeitos quando a janela redimensionar
window.addEventListener('resize', function() {
    setTimeout(() => {
        // Reconfigurar parallax das Prioridades
        if (document.querySelector('#prioridades')) {
            setupPrioridadesParallax();
        }
    }, 100);
});

// Cleanup quando sair da página
window.addEventListener('beforeunload', function() {
    if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.killAll();
    }
    if (prioridadesParallaxContext) {
        prioridadesParallaxContext.revert();
    }
});

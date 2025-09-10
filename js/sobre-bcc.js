/**
 * Scripts específicos para a página SOBRE-BCC
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
// COMPONENTE: BASES BCC - Animação de Elementos
// ===========================================
function setupBasesBccAnimations() {
    // Verificar se GSAP e ScrollTrigger estão carregados
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
        console.warn('GSAP ou ScrollTrigger não carregados para Bases BCC');
        return;
    }
    
    const animatedElements = document.querySelectorAll('#bases .animate-up');
    
    if (animatedElements.length === 0) {
        console.log('Elementos animados do Bases BCC não encontrados');
        return;
    }
    
    // Configurar estado inicial dos elementos (invisíveis e deslocados para baixo)
    gsap.set(animatedElements, {
        y: 60,
        opacity: 0
    });
    
    // Criar animação para cada elemento
    animatedElements.forEach((element, index) => {
        // Pegar delay personalizado ou usar baseado no index
        const customDelay = element.dataset.delay ? parseFloat(element.dataset.delay) : index * 0.1;
        
        ScrollTrigger.create({
            trigger: element,
            start: 'top 85%',
            end: 'bottom 20%',
            once: true, // Animar apenas uma vez
            onEnter: () => {
                gsap.to(element, {
                    y: 0,
                    opacity: 1,
                    duration: 0.6,
                    delay: customDelay,
                    ease: 'power2.out'
                });
            }
        });
    });
    
    console.log(`Bases BCC: ${animatedElements.length} elementos configurados para animação`);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Scripts da página Sobre BCC carregados');
    
    // Aguardar um pouco para garantir que scripts.js terminou
    setTimeout(() => {
        // Verificar se há banner na página
        const banner = document.querySelector('.Banner');
        if (banner) {
            console.log('Banner Sobre encontrado, inicializando Swiper...');
            
            // Inicializar Swiper do banner
            const bannerSwiper = banner.querySelector('.swiper[data-swiper-config]');
            if (bannerSwiper) {
                initializeSwiperSafely('.Banner .swiper[data-swiper-config]', 'Banner Sobre');
            }
        }
        
        // Verificar se há componente Conquistas na página
        const conquistas = document.querySelector('#conquistas');
        if (conquistas) {
            console.log('Componente Conquistas encontrado, inicializando Swiper...');
            
            // Inicializar Swiper das conquistas
            const conquistasSwiper = conquistas.querySelector('.swiper[data-swiper-config]');
            if (conquistasSwiper) {
                initializeSwiperSafely('#conquistas .swiper[data-swiper-config]', 'Conquistas');
            }
        }
        
        // Verificar se há componente Jornada BCC na página
        const jornada = document.querySelector('#jornada-bcc');
        if (jornada) {
            console.log('Componente Jornada BCC encontrado, inicializando Swiper...');
            
            // Inicializar Swiper da jornada
            const jornadaSwiper = jornada.querySelector('.swiper[data-swiper-config]');
            if (jornadaSwiper) {
                initializeSwiperSafely('#jornada-bcc .swiper[data-swiper-config]', 'Jornada BCC');
            }
        }
        
        // Verificar se há componente Bases BCC na página
        const basesBcc = document.querySelector('#bases');
        if (basesBcc) {
            console.log('Componente Bases BCC encontrado, inicializando animações...');
            
            // Aguardar um pouco para garantir que GSAP carregou
            setTimeout(() => {
                setupBasesBccAnimations();
            }, 200);
        }
        
        // Adicionar outras funcionalidades específicas da página sobre aqui
    }, 100);
});

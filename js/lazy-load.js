/**
 * Lazy Loading de Imagens - Brasil Center
 * Carrega imagens apenas quando necessário para melhorar performance
 */

(function() {
    'use strict';
    
    // Verificar se o navegador suporta Intersection Observer
    if (!('IntersectionObserver' in window)) {
        // Fallback para navegadores antigos - carregar todas as imagens
        const lazyImages = document.querySelectorAll('img[data-src]');
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        });
        return;
    }
    
    // Configurar Intersection Observer
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                
                // Carregar imagem
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                
                // Carregar srcset se existir
                if (img.dataset.srcset) {
                    img.srcset = img.dataset.srcset;
                    img.removeAttribute('data-srcset');
                }
                
                // Remover classe de placeholder
                img.classList.remove('lazy-loading');
                img.classList.add('lazy-loaded');
                
                // Parar de observar esta imagem
                observer.unobserve(img);
            }
        });
    }, {
        // Carregar imagem quando estiver 50px antes de aparecer
        rootMargin: '50px 0px',
        threshold: 0.01
    });
    
    // Observar todas as imagens com data-src
    const lazyImages = document.querySelectorAll('img[data-src]');
    lazyImages.forEach(img => {
        // Adicionar classe para styling
        img.classList.add('lazy-loading');
        imageObserver.observe(img);
    });
    
    // Função para converter imagens existentes para lazy loading
    window.enableLazyLoading = function() {
        const images = document.querySelectorAll('img[src]:not([data-src])');
        images.forEach(img => {
            // Não aplicar lazy loading em imagens críticas
            if (img.closest('.Banner') || img.hasAttribute('data-no-lazy')) {
                return;
            }
            
            // Mover src para data-src
            img.dataset.src = img.src;
            img.src = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1 1"%3E%3C/svg%3E';
            
            // Mover srcset se existir
            if (img.srcset) {
                img.dataset.srcset = img.srcset;
                img.srcset = '';
            }
            
            // Observar nova imagem lazy
            img.classList.add('lazy-loading');
            imageObserver.observe(img);
        });
    };
})();

// CSS inline para lazy loading
const lazyLoadCSS = `
    .lazy-loading {
        opacity: 0;
        transition: opacity 0.3s;
        background: #f0f0f0;
    }
    .lazy-loaded {
        opacity: 1;
    }
`;

// Adicionar CSS ao head
const style = document.createElement('style');
style.textContent = lazyLoadCSS;
document.head.appendChild(style);















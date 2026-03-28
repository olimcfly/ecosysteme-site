/**
 * ÉCOSYSTÈME IMMO LOCAL+ - Main JavaScript
 * Version: 3.2 - Navigation + UI uniquement
 * 
 * NOTE: La gestion des formulaires est déléguée à form-handler.js
 * Ce fichier gère : Navigation mobile, Modals, Animations, FAQ, etc.
 */

// === Navigation Mobile ===
const Navigation = {
    init() {
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');
        const navLinks = document.querySelectorAll('.nav-link');
        const header = document.querySelector('.header');
        
        console.log('🍔 Navigation init - Hamburger:', !!hamburger, 'NavMenu:', !!navMenu);
        
        if (hamburger && navMenu) {
            // Toggle menu au clic sur hamburger
            hamburger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isActive = hamburger.classList.contains('active');
                console.log('🍔 Hamburger cliqué, état actuel:', isActive ? 'ouvert' : 'fermé');
                
                hamburger.classList.toggle('active');
                navMenu.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });
            
            // Fermer le menu au clic sur un lien
            navLinks.forEach(function(link) {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                });
            });
            
            // Fermer le menu au clic en dehors
            document.addEventListener('click', function(e) {
                if (navMenu.classList.contains('active')) {
                    if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                        hamburger.classList.remove('active');
                        navMenu.classList.remove('active');
                        document.body.classList.remove('menu-open');
                    }
                }
            });
            
            // Fermer avec touche Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && navMenu.classList.contains('active')) {
                    hamburger.classList.remove('active');
                    navMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        }
        
        // Header scroll effect
        if (header) {
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.scrollY;
                
                if (currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                if (currentScroll > lastScroll && currentScroll > 200) {
                    header.classList.add('header-hidden');
                } else {
                    header.classList.remove('header-hidden');
                }
                lastScroll = currentScroll;
            });
        }
    }
};

// === Gestion des Modals ===
const Modals = {
    init() {
        // Boutons d'ouverture
        const modalTriggers = document.querySelectorAll('[data-modal]');
        modalTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const modalId = trigger.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });
        
        // Boutons de fermeture
        const closeButtons = document.querySelectorAll('.modal-close, [data-modal-close]');
        closeButtons.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const modal = btn.closest('.modal-overlay');
                if (modal) {
                    modal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Fermer au clic sur l'overlay
        const overlays = document.querySelectorAll('.modal-overlay');
        overlays.forEach(function(overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Fermer avec Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-overlay.active').forEach(function(modal) {
                    modal.classList.remove('active');
                });
                document.body.style.overflow = '';
            }
        });
    },
    
    open(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    },
    
    close(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    },
    
    closeAll() {
        document.querySelectorAll('.modal-overlay.active').forEach(function(modal) {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
};

// === Smooth Scroll ===
const SmoothScroll = {
    init() {
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                const href = anchor.getAttribute('href');
                if (href === '#' || href === '#!') return;
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
};

// === Animations au Scroll ===
const ScrollAnimations = {
    init() {
        const animatedElements = document.querySelectorAll('.animate-on-scroll, .fade-in, .slide-up, .fade-in-up');
        
        if (animatedElements.length === 0) return;
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        animatedElements.forEach(function(el) {
            observer.observe(el);
        });
    }
};

// === FAQ Accordéon ===
const FAQ = {
    init() {
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(function(item) {
            const question = item.querySelector('.faq-question');
            if (question) {
                question.addEventListener('click', function() {
                    const isActive = item.classList.contains('active');
                    
                    faqItems.forEach(function(otherItem) {
                        otherItem.classList.remove('active');
                    });
                    
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            }
        });
    }
};

// === Compteur Animé ===
const Counter = {
    init() {
        const counters = document.querySelectorAll('.counter, [data-counter]');
        
        if (counters.length === 0) return;
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    Counter.animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(function(counter) {
            observer.observe(counter);
        });
    },
    
    animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target') || element.innerText);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(function() {
            current += step;
            if (current >= target) {
                element.innerText = target.toLocaleString('fr-FR');
                clearInterval(timer);
            } else {
                element.innerText = Math.floor(current).toLocaleString('fr-FR');
            }
        }, 16);
    }
};

// === Témoignages Slider ===
const Testimonials = {
    currentIndex: 0,
    items: [],
    autoPlayInterval: null,
    
    init() {
        this.items = document.querySelectorAll('.testimonial-item');
        const prevBtn = document.querySelector('.testimonial-prev');
        const nextBtn = document.querySelector('.testimonial-next');
        
        if (this.items.length === 0) return;
        
        if (prevBtn) prevBtn.addEventListener('click', this.prev.bind(this));
        if (nextBtn) nextBtn.addEventListener('click', this.next.bind(this));
        
        this.startAutoPlay();
        
        const container = document.querySelector('.testimonials-slider');
        if (container) {
            container.addEventListener('mouseenter', this.stopAutoPlay.bind(this));
            container.addEventListener('mouseleave', this.startAutoPlay.bind(this));
        }
    },
    
    show(index) {
        this.items.forEach(function(item, i) {
            item.classList.toggle('active', i === index);
        });
    },
    
    next() {
        this.currentIndex = (this.currentIndex + 1) % this.items.length;
        this.show(this.currentIndex);
    },
    
    prev() {
        this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
        this.show(this.currentIndex);
    },
    
    startAutoPlay() {
        this.stopAutoPlay();
        this.autoPlayInterval = setInterval(this.next.bind(this), 5000);
    },
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
};

// === Vérification Zone ===
const ZoneChecker = {
    init() {
        const form = document.getElementById('zone-form');
        if (!form) return;
        form.addEventListener('submit', this.checkZone.bind(this));
    },
    
    async checkZone(e) {
        e.preventDefault();
        
        const codePostal = document.getElementById('code-postal').value;
        const resultDiv = document.getElementById('zone-result');
        
        if (!codePostal || codePostal.length !== 5) {
            this.showResult('error', 'Veuillez entrer un code postal valide.');
            return;
        }
        
        resultDiv.innerHTML = '<div class="loading"><span class="spinner"></span> Vérification...</div>';
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        const zonesOccupees = ['75001', '75002', '69001', '33000'];
        
        if (zonesOccupees.includes(codePostal)) {
            this.showResult('taken', 'Cette zone est déjà attribuée.');
        } else {
            this.showResult('available', 'Cette zone est disponible !');
        }
    },
    
    showResult(status, message) {
        const resultDiv = document.getElementById('zone-result');
        if (!resultDiv) return;
        
        const icons = { available: '✅', taken: '⚠️', error: '❌' };
        resultDiv.innerHTML = '<div class="zone-result-' + status + '">' +
            '<span class="icon">' + icons[status] + '</span><p>' + message + '</p>' +
            (status === 'available' ? '<a href="/demo.php" class="btn btn-primary">Réserver</a>' : '') +
        '</div>';
    }
};

// === Tabs ===
const Tabs = {
    init() {
        document.querySelectorAll('.tabs-container, [data-tabs]').forEach(function(container) {
            const tabs = container.querySelectorAll('.tab-btn, [data-tab]');
            const panels = container.querySelectorAll('.tab-panel, [data-tab-panel]');
            
            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    const targetId = tab.getAttribute('data-tab') || tab.getAttribute('href').replace('#', '');
                    tabs.forEach(function(t) { t.classList.remove('active'); });
                    panels.forEach(function(p) { p.classList.remove('active'); });
                    tab.classList.add('active');
                    const targetPanel = document.getElementById(targetId);
                    if (targetPanel) targetPanel.classList.add('active');
                });
            });
        });
    }
};

// === Utilitaires ===
const Utils = {
    formatPhone(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 10) value = value.substr(0, 10);
        let formatted = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 2 === 0) formatted += ' ';
            formatted += value[i];
        }
        input.value = formatted;
    },
    
    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    },
    
    showToast(message, type) {
        type = type || 'info';
        const toast = document.createElement('div');
        toast.className = 'toast toast-' + type;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(function() { toast.classList.add('show'); }, 10);
        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() { toast.remove(); }, 300);
        }, 3000);
    }
};

// === Downloads ===
const Downloads = {
    init() {
        document.querySelectorAll('a[download], .btn-download').forEach(function(link) {
            link.addEventListener('click', function() {
                const fileName = link.getAttribute('download') || link.href.split('/').pop();
                console.log('📥 Téléchargement:', fileName);
            });
        });
    }
};

// === Initialisation Globale ===
document.addEventListener('DOMContentLoaded', function() {
    Navigation.init();
    // NOTE: Les formulaires sont gérés par form-handler.js
    Modals.init();
    SmoothScroll.init();
    ScrollAnimations.init();
    FAQ.init();
    Counter.init();
    Testimonials.init();
    ZoneChecker.init();
    Tabs.init();
    Downloads.init();
    
    document.querySelectorAll('input[type="tel"]').forEach(function(input) {
        input.addEventListener('input', function() { Utils.formatPhone(input); });
    });
    
    document.body.classList.add('js-loaded');
    console.log('🚀 ÉCOSYSTÈME IMMO LOCAL+ v3.2 initialisé (formulaires → form-handler.js)');
});

// === Export ===
window.EcosystemeImmo = { Navigation, Modals, Utils, Downloads };
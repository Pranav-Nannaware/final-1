// ===== GLOBAL VARIABLES =====
let isMobileMenuOpen = false;
let isSearchOpen = false;
let currentTestimonialIndex = 0;
let scrollTimeout = null;

// ===== INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    console.log('Bharat English School & Jr. College - Website Loaded');
    
    // Ensure mobile menu is closed on page load
    const navigation = document.getElementById('navigation');
    if (navigation) {
        navigation.classList.remove('show');
    }
    
    // Initialize all components
    initializeLoadingScreen();
    initializeNavigation();
    initializeSearch();
    initializeAnimations();
    initializeScrollEffects();
    initializeInteractiveElements();
    initializeAccessibility();

    
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Show success message after everything is loaded
    setTimeout(() => {
        console.log('✅ All animations and features loaded successfully!');
        
        // Add a subtle success indicator
        const successIndicator = document.createElement('div');
        successIndicator.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        `;
        successIndicator.innerHTML = '✨ Website Ready';
        document.body.appendChild(successIndicator);
        
        // Animate in
        setTimeout(() => {
            successIndicator.style.opacity = '1';
            successIndicator.style.transform = 'translateY(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            successIndicator.style.opacity = '0';
            successIndicator.style.transform = 'translateY(-10px)';
            setTimeout(() => successIndicator.remove(), 300);
        }, 3000);
    }, 2000);
});

// ===== LOADING SCREEN =====
function initializeLoadingScreen() {
    const loadingScreen = document.getElementById('loadingScreen');
    
    if (!loadingScreen) {
        console.log('Loading screen not found');
        return;
    }
    
    // Force remove loading screen after 3 seconds as fallback
    const forceRemoveTimeout = setTimeout(() => {
        if (loadingScreen && loadingScreen.parentNode) {
            loadingScreen.remove();
            console.log('Loading screen force removed');
        }
    }, 3000);
    
    // Simulate loading progress
    const progressBar = loadingScreen.querySelector('.loading-progress');
    if (progressBar) {
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
            }
            progressBar.style.width = progress + '%';
        }, 100);
    }
    
    // Remove loading screen after content loads
    setTimeout(() => {
        if (loadingScreen && loadingScreen.parentNode) {
            loadingScreen.style.opacity = '0';
            loadingScreen.style.transform = 'scale(1.1)';
            
            setTimeout(() => {
                if (loadingScreen && loadingScreen.parentNode) {
                    loadingScreen.remove();
                    console.log('Loading screen removed successfully');
                }
            }, 500);
        }
        
        // Clear the force timeout since we're removing normally
        clearTimeout(forceRemoveTimeout);
    }, 1500);
}

// ===== NAVIGATION =====
function initializeNavigation() {
    initHeaderAnimations();
    initMobileMenu();
}

// ===== SEARCH =====
function initializeSearch() {
    initSearchOverlay();
}

// ===== ANIMATIONS =====
function initializeAnimations() {
    initGSAPAnimations();
    initCounterAnimations();
    initTestimonialsCarousel();
}

// ===== SCROLL EFFECTS =====
function initializeScrollEffects() {
    initScrollAnimations();
    initParallaxEffects();
    initScrollToTop();
    initSmoothScrolling();
}

// ===== INTERACTIVE ELEMENTS =====
function initializeInteractiveElements() {
    initContactForm();
    initKeyboardNavigation();
    initTouchSupport();
}

// ===== ACCESSIBILITY =====
function initializeAccessibility() {
    enhanceAccessibility();
    initLazyLoading();
}

// ===== HEADER ANIMATIONS =====
function initHeaderAnimations() {
    const header = document.getElementById('header');
    const navigation = document.getElementById('navigation');
    
    if (!header) {
        console.log('Header not found');
        return;
    }
    
    let lastScrollY = window.scrollY;
    let isHeaderVisible = true;
    
    function handleScroll() {
        const currentScrollY = window.scrollY;
        
        // Clear any existing timeout
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        
        // Close mobile menu when scrolling if it's open
        if (isMobileMenuOpen && navigation) {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const hamburger = mobileMenuBtn ? mobileMenuBtn.querySelector('.hamburger') : null;
            
            navigation.classList.remove('show');
            if (hamburger) hamburger.classList.remove('active');
            document.body.style.overflow = '';
            isMobileMenuOpen = false;
        }
        
        // Add scrolled class for background
        if (currentScrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Hide/show header on scroll with debouncing
        scrollTimeout = setTimeout(() => {
            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                if (isHeaderVisible) {
                    header.classList.add('hidden');
                    isHeaderVisible = false;
                }
            } else {
                if (!isHeaderVisible) {
                    header.classList.remove('hidden');
                    isHeaderVisible = true;
                }
            }
            lastScrollY = currentScrollY;
        }, 10);
    }
    
    window.addEventListener('scroll', throttle(handleScroll, 16));
}

// ===== MOBILE MENU =====
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navigation = document.getElementById('navigation');
    
    if (!mobileMenuBtn || !navigation) {
        console.log('Mobile menu elements not found');
        return;
    }
    
    const hamburger = mobileMenuBtn.querySelector('.hamburger');
    
    function toggleMobileMenu() {
        isMobileMenuOpen = !isMobileMenuOpen;
        
        if (isMobileMenuOpen) {
            navigation.classList.add('show');
            if (hamburger) hamburger.classList.add('active');
            document.body.style.overflow = 'hidden';
        } else {
            navigation.classList.remove('show');
            if (hamburger) hamburger.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    function closeMobileMenu() {
        if (isMobileMenuOpen) {
            isMobileMenuOpen = false;
            navigation.classList.remove('show');
            if (hamburger) hamburger.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
    mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMobileMenu();
    });
    
    // Close menu when clicking on nav links
    const navLinks = navigation.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            closeMobileMenu();
        });
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (isMobileMenuOpen && !mobileMenuBtn.contains(e.target) && !navigation.contains(e.target)) {
            closeMobileMenu();
        }
    });
    
    // Close menu on window resize (prevents issues when switching orientations)
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && isMobileMenuOpen) {
            closeMobileMenu();
        }
    });
}

// ===== SEARCH OVERLAY =====
function initSearchOverlay() {
    const searchBtn = document.getElementById('searchBtn');
    const searchOverlay = document.getElementById('searchOverlay');
    const closeSearch = document.getElementById('closeSearch');
    const searchInput = document.getElementById('searchInput');
    
    if (!searchBtn || !searchOverlay) {
        console.log('Search overlay elements not found');
        return;
    }
    
    function openSearch() {
        isSearchOpen = true;
        searchOverlay.classList.add('active');
        if (searchInput) {
            searchInput.focus();
        }
        document.body.style.overflow = 'hidden';
    }
    
    function closeSearchOverlay() {
        isSearchOpen = false;
        searchOverlay.classList.remove('active');
        if (searchInput) {
            searchInput.value = '';
        }
        document.body.style.overflow = '';
    }
    
    searchBtn.addEventListener('click', openSearch);
    if (closeSearch) {
        closeSearch.addEventListener('click', closeSearchOverlay);
    }
    
    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isSearchOpen) {
            closeSearchOverlay();
        }
    });
    
    // Close on overlay click
    searchOverlay.addEventListener('click', (e) => {
        if (e.target === searchOverlay) {
            closeSearchOverlay();
        }
    });
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            // Add search logic here
            console.log('Searching for:', query);
        });
    }
}

// ===== SCROLL ANIMATIONS =====
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);
        
        // Observe sections
        const sections = document.querySelectorAll('section');
        sections.forEach(section => {
            observer.observe(section);
        });
        
        // Observe cards
    const cards = document.querySelectorAll('.program-card, .testimonial-card, .campus-item');
        cards.forEach(card => {
            observer.observe(card);
        });
    }
    
// ===== COUNTER ANIMATIONS =====
function initCounterAnimations() {
        const counters = document.querySelectorAll('.stat-number');
    
    if (counters.length === 0) {
        console.log('No counter elements found');
        return;
    }
        
        const observerOptions = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                    const suffix = counter.textContent.replace(/[0-9]/g, '');
                    let current = 0;
                    const increment = target / 100;
                    
                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.ceil(current) + suffix;
                            setTimeout(updateCounter, 20);
                        } else {
                            counter.textContent = target + suffix;
                        }
                    };
                    
                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        }, observerOptions);
        
        counters.forEach(counter => {
            observer.observe(counter);
        });
    }
    
// ===== TESTIMONIALS CAROUSEL =====
function initTestimonialsCarousel() {
    const container = document.getElementById('testimonialsContainer');
    const prevBtn = document.getElementById('testimonialsPrev');
    const nextBtn = document.getElementById('testimonialsNext');
    
    if (!container) {
        console.log('Testimonials container not found');
        return;
    }
    
    const cards = container.querySelectorAll('.testimonial-card');
    
    const cardWidth = 350 + 32; // card width + gap
    const maxScroll = (cards.length - 1) * cardWidth;
    
    function scrollTestimonials(direction) {
        const currentScroll = container.scrollLeft;
        const scrollAmount = direction === 'next' ? cardWidth : -cardWidth;
        const newScroll = currentScroll + scrollAmount;
        
        container.scrollTo({
            left: Math.max(0, Math.min(newScroll, maxScroll)),
            behavior: 'smooth'
        });
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => scrollTestimonials('prev'));
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => scrollTestimonials('next'));
    }
    
    // Auto-scroll testimonials
    let autoScrollInterval;
    
    function startAutoScroll() {
        autoScrollInterval = setInterval(() => {
            if (container.scrollLeft >= maxScroll) {
                container.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                scrollTestimonials('next');
            }
        }, 5000);
    }
    
    function stopAutoScroll() {
        clearInterval(autoScrollInterval);
    }
    
    // Start auto-scroll
    startAutoScroll();
    
    // Pause on hover
    container.addEventListener('mouseenter', stopAutoScroll);
    container.addEventListener('mouseleave', startAutoScroll);
}

// ===== CONTACT FORM =====
function initContactForm() {
    const form = document.getElementById('contactForm');
    
    if (!form) {
        console.log('Contact form not found');
        return;
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Show loading state
        const submitBtn = form.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span>Sending...</span><i data-lucide="loader-2"></i>';
        submitBtn.disabled = true;
        
        // Simulate form submission
        setTimeout(() => {
            // Reset form
            form.reset();
            
            // Show success message
            showNotification('Message sent successfully! We\'ll get back to you soon.', 'success');
            
            // Reset button
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            // Reinitialize icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }, 2000);
    });
}

// ===== SCROLL TO TOP =====
function initScrollToTop() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    if (!scrollToTopBtn) {
        console.log('Scroll to top button not found');
        return;
    }
    
    function toggleScrollToTopButton() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    }
    
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
    
    window.addEventListener('scroll', toggleScrollToTopButton);
    scrollToTopBtn.addEventListener('click', scrollToTop);
}

// ===== PARALLAX EFFECTS =====
function initParallaxEffects() {
    const hero = document.querySelector('.hero');
    const heroVideo = document.querySelector('.hero-video');
    
    if (hero && heroVideo) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
            heroVideo.style.transform = `translateY(${rate}px)`;
            });
        }
    }
    
// ===== INTERSECTION OBSERVERS =====
function initIntersectionObservers() {
    // Observe elements for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe all animatable elements
    const animatableElements = document.querySelectorAll('.program-card, .testimonial-card, .campus-item, .about-highlight');
    animatableElements.forEach(el => observer.observe(el));
}

// ===== SMOOTH SCROLLING =====
function initSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const header = document.querySelector('.header');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===== KEYBOARD NAVIGATION =====
function initKeyboardNavigation() {
    document.addEventListener('keydown', (e) => {
        // Escape key closes modals
        if (e.key === 'Escape') {
            if (isMobileMenuOpen) {
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                if (mobileMenuBtn) mobileMenuBtn.click();
            }
            if (isSearchOpen) {
                const closeSearch = document.getElementById('closeSearch');
                if (closeSearch) closeSearch.click();
            }
        }
        
        // Arrow keys for carousel navigation
        if (e.key === 'ArrowLeft') {
            const prevBtn = document.getElementById('testimonialsPrev');
            if (prevBtn) prevBtn.click();
        }
        if (e.key === 'ArrowRight') {
            const nextBtn = document.getElementById('testimonialsNext');
            if (nextBtn) nextBtn.click();
        }
    });
}

// ===== TOUCH SUPPORT =====
    function initTouchSupport() {
    // Swipe gestures for testimonials
    const testimonialsContainer = document.getElementById('testimonialsContainer');
    
    if (testimonialsContainer) {
        let startX = 0;
        let endX = 0;
        
        function handleTouchStart(e) {
            startX = e.touches[0].clientX;
        }
        
        function handleTouchEnd(e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        }
        
        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                    // Swipe left - next
                    const nextBtn = document.getElementById('testimonialsNext');
                    if (nextBtn) nextBtn.click();
                    } else {
                    // Swipe right - previous
                    const prevBtn = document.getElementById('testimonialsPrev');
                    if (prevBtn) prevBtn.click();
                }
            }
        }
        
        testimonialsContainer.addEventListener('touchstart', handleTouchStart);
        testimonialsContainer.addEventListener('touchend', handleTouchEnd);
    }
}

// ===== SCROLL PROGRESS BAR =====
(function() {
  let progressBar = document.getElementById('scroll-progress');
  if (!progressBar) {
    progressBar = document.createElement('div');
    progressBar.id = 'scroll-progress';
    document.body.appendChild(progressBar);
  }
  window.addEventListener('scroll', function() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const percent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    progressBar.style.width = percent + '%';
  });
})();

// Slideshow background for hero section
const heroImages = [
  'images/1.png',
  'images/2.png',
  'images/3.jpg',
  'images/4.jpg',
 
];
let heroCurrent = 0;
const heroSlideshow = document.querySelector('.slideshow-background');
function showNextHeroImage() {
  if (heroSlideshow) {
    heroSlideshow.style.backgroundImage = `url('${heroImages[heroCurrent]}')`;
    heroCurrent = (heroCurrent + 1) % heroImages.length;
  }
}
showNextHeroImage();
setInterval(showNextHeroImage, 4000);

// ===== ADVANCED GSAP ANIMATIONS =====
function initGSAPAnimations() {
  if (typeof gsap === 'undefined') {
    console.log('GSAP not loaded, skipping GSAP animations');
    return;
  }
  try {
    gsap.registerPlugin(ScrollTrigger);

    // Section fade/slide/scale in
    gsap.utils.toArray('section').forEach((section, i) => {
      gsap.from(section, {
        scrollTrigger: {
          trigger: section,
          start: 'top 80%',
          toggleActions: 'play none none reverse'
        },
        y: 80,
        opacity: 0,
        scale: 0.98,
        duration: 1.2,
        ease: 'power3.out',
        delay: i * 0.05
      });
    });

    // Animate SVG wave dividers
    gsap.utils.toArray('.wave-divider svg').forEach((svg, i) => {
      gsap.from(svg, {
        scrollTrigger: {
          trigger: svg,
          start: 'top 90%',
          toggleActions: 'play none none reverse'
        },
        y: 60,
        opacity: 0,
        duration: 1.1,
        ease: 'power2.out',
        delay: i * 0.1
      });
    });

    // Floating shapes gentle movement
    gsap.utils.toArray('.floating-shape').forEach((shape, i) => {
      gsap.to(shape, {
        y: 'random(-20, 20)',
        x: 'random(-20, 20)',
        repeat: -1,
        yoyo: true,
        duration: 4 + Math.random() * 2,
        ease: 'sine.inOut',
        delay: i * 0.5
      });
    });

    // Cards and images pop/float
    gsap.utils.toArray('.program-card, .testimonial-card, .alumni-card, .campus-item, .about-highlight').forEach((card, i) => {
      gsap.from(card, {
        scrollTrigger: {
          trigger: card,
          start: 'top 85%',
          toggleActions: 'play none none reverse'
        },
        y: 60,
        opacity: 0,
        scale: 0.97,
        duration: 0.9,
        ease: 'power2.out',
        delay: i * 0.04
      });
    });
    gsap.utils.toArray('.image-item img, .campus-image img').forEach((img, i) => {
      gsap.from(img, {
        scrollTrigger: {
          trigger: img,
          start: 'top 90%',
          toggleActions: 'play none none reverse'
        },
        scale: 1.08,
        opacity: 0,
        duration: 1.1,
        ease: 'power2.out',
        delay: i * 0.03
      });
    });

    // Animate section backgrounds
    gsap.utils.toArray('.about-section, .programs-section, .campus-section, .testimonials-section, .contact-section').forEach((sec, i) => {
      gsap.fromTo(sec, {
        backgroundPosition: '0% 50%'
      }, {
        scrollTrigger: {
          trigger: sec,
          start: 'top 90%',
          end: 'bottom 10%',
          scrub: 1
        },
        backgroundPosition: '100% 50%',
        ease: 'none',
        duration: 2
      });
    });

    // Button ripple effect on click
    document.querySelectorAll('.button-pulse').forEach(btn => {
      btn.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.left = (e.offsetX || e.touches?.[0]?.clientX || 0) + 'px';
        ripple.style.top = (e.offsetY || e.touches?.[0]?.clientY || 0) + 'px';
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
      });
    });

    // Hero section text animation
    gsap.timeline()
      .from('.hero-title .title-line', {
        y: 50,
        opacity: 0,
        duration: 1,
        stagger: 0.2,
        ease: 'power3.out'
      })
      .from('.hero-subtitle', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      }, '-=0.5')
      .from('.hero-actions', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
      }, '-=0.3')
      .from('.stat-card', {
        y: 30,
        opacity: 0,
        duration: 0.8,
        stagger: 0.1,
        ease: 'power3.out'
      }, '-=0.5');

    // Section title animations
    gsap.utils.toArray('.section-title').forEach(title => {
      gsap.from(title, {
        scrollTrigger: {
          trigger: title,
          start: 'top 80%',
          end: 'bottom 20%',
          toggleActions: 'play none none reverse'
        },
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: 'power3.out'
            });
        });

    // Program cards stagger animation
    gsap.from('.program-card', {
      scrollTrigger: {
        trigger: '.programs-grid',
        start: 'top 80%',
        end: 'bottom 20%',
        toggleActions: 'play none none reverse'
      },
      y: 50,
      opacity: 0,
      duration: 0.8,
      stagger: 0.2,
      ease: 'power3.out'
    });

    // Campus items animation
    gsap.from('.campus-item', {
      scrollTrigger: {
        trigger: '.campus-showcase',
        start: 'top 80%',
        end: 'bottom 20%',
        toggleActions: 'play none none reverse'
      },
      x: (index) => index % 2 === 0 ? -50 : 50,
      opacity: 0,
      duration: 1,
      stagger: 0.3,
      ease: 'power3.out'
    });

    // Testimonial cards animation
    gsap.from('.testimonial-card', {
      scrollTrigger: {
        trigger: '.testimonials-container',
        start: 'top 80%',
        end: 'bottom 20%',
        toggleActions: 'play none none reverse'
      },
      y: 50,
      opacity: 0,
      duration: 0.8,
      stagger: 0.2,
      ease: 'power3.out'
    });

    // Contact form animation
    gsap.from('.contact-form', {
      scrollTrigger: {
        trigger: '.contact-section',
        start: 'top 80%',
        end: 'bottom 20%',
        toggleActions: 'play none none reverse'
      },
      x: 50,
      opacity: 0,
      duration: 1,
      ease: 'power3.out'
    });

    // Floating animation for admission tab
    gsap.to('#admissionTab', {
      y: -10,
      duration: 2,
      ease: 'power2.inOut',
      yoyo: true,
      repeat: -1
    });

    // Parallax effect for hero video
    gsap.to('.hero-video', {
      scrollTrigger: {
        trigger: '.hero',
        start: 'top bottom',
        end: 'bottom top',
        scrub: true
      },
      y: 100,
      ease: 'none'
    });
    console.log('GSAP advanced animations initialized');
  } catch (error) {
    console.error('Error initializing GSAP animations:', error);
  }
}

// ===== UTILITY FUNCTIONS =====
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'alert-circle' : 'info'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i data-lucide="x"></i>
        </button>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 1rem;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 400px;
    `;
    
    // Add to DOM
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Close button functionality
    const closeBtn = notification.querySelector('.notification-close');
    closeBtn.addEventListener('click', () => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
    
    // Reinitialize icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// ===== PERFORMANCE OPTIMIZATION =====
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ===== ACCESSIBILITY ENHANCEMENTS =====
function enhanceAccessibility() {
    // Add focus indicators
    const focusableElements = document.querySelectorAll('button, a, input, select, textarea');
    focusableElements.forEach(el => {
        el.addEventListener('focus', () => {
            el.style.outline = '2px solid #667eea';
            el.style.outlineOffset = '2px';
        });
        
        el.addEventListener('blur', () => {
            el.style.outline = '';
            el.style.outlineOffset = '';
            });
    });
    
    // Add skip to content link
    const skipLink = document.createElement('a');
    skipLink.href = '#main-content';
    skipLink.textContent = 'Skip to main content';
    skipLink.style.cssText = `
        position: absolute;
        top: -40px;
        left: 6px;
        background: #667eea;
        color: white;
        padding: 8px;
        text-decoration: none;
        border-radius: 4px;
        z-index: 10001;
        transition: top 0.3s ease;
    `;
    
    skipLink.addEventListener('focus', () => {
        skipLink.style.top = '6px';
    });
    
    skipLink.addEventListener('blur', () => {
        skipLink.style.top = '-40px';
    });
    
    document.body.insertBefore(skipLink, document.body.firstChild);
}

// ===== LAZY LOADING =====
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}



// ===== ERROR HANDLING =====
window.addEventListener('error', (e) => {
    console.error('JavaScript error:', e.error);
    // You can add error reporting logic here
});

// ===== INITIALIZE ACCESSIBILITY =====
enhanceAccessibility();

// ===== INITIALIZE LAZY LOADING =====
initLazyLoading();



function openVirtualTour() {
    // Create virtual tour overlay
    const tourOverlay = document.createElement('div');
    tourOverlay.className = 'virtual-tour-overlay';
    tourOverlay.innerHTML = `
        <div class="virtual-tour-container">
            <div class="tour-header">
                <div class="tour-header-content">
                    <div class="tour-title-section">
                        <h2>Virtual Campus Tour</h2>
                        <p class="tour-subtitle">Explore our world-class facilities</p>
                    </div>
                    <div class="tour-header-actions">
                        <button class="tour-fullscreen-btn" id="fullscreenBtn" title="Toggle Fullscreen">
                            <i data-lucide="maximize-2"></i>
                        </button>
                        <button class="close-tour" id="closeTour" title="Close Tour">
                            <i data-lucide="x"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="tour-content">
                <div class="tour-navigation">
                    <div class="tour-nav-header">
                        <h3>Locations</h3>
                        <div class="tour-nav-indicator">
                            <span class="current-location">1</span> of <span class="total-locations">6</span>
                        </div>
                    </div>
                    <div class="tour-nav-buttons">
                        <button class="tour-nav-btn active" data-location="entrance">
                            <div class="nav-btn-icon">
                                <i data-lucide="home"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Main Entrance</span>
                                <span class="nav-btn-desc">Grand welcome area</span>
                            </div>
                        </button>
                        <button class="tour-nav-btn" data-location="classrooms">
                            <div class="nav-btn-icon">
                                <i data-lucide="book-open"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Classrooms</span>
                                <span class="nav-btn-desc">Smart learning spaces</span>
                            </div>
                        </button>
                        <button class="tour-nav-btn" data-location="library">
                            <div class="nav-btn-icon">
                                <i data-lucide="library"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Library</span>
                                <span class="nav-btn-desc">Knowledge hub</span>
                            </div>
                        </button>
                        <button class="tour-nav-btn" data-location="labs">
                            <div class="nav-btn-icon">
                                <i data-lucide="flask-conical"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Science Labs</span>
                                <span class="nav-btn-desc">Research facilities</span>
                            </div>
                        </button>
                        <button class="tour-nav-btn" data-location="sports">
                            <div class="nav-btn-icon">
                                <i data-lucide="trophy"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Sports Complex</span>
                                <span class="nav-btn-desc">Fitness & recreation</span>
                            </div>
                        </button>
                        <button class="tour-nav-btn" data-location="auditorium">
                            <div class="nav-btn-icon">
                                <i data-lucide="users"></i>
                            </div>
                            <div class="nav-btn-content">
                                <span class="nav-btn-title">Auditorium</span>
                                <span class="nav-btn-desc">Events & performances</span>
                            </div>
                        </button>
                    </div>
                </div>
                <div class="tour-viewer">
                    <div class="tour-image-container">
                        <div class="tour-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Main Entrance" id="tourImage">
                            <div class="tour-image-overlay">
                                <div class="tour-overlay-info">
                                    <div class="tour-info-header">
                                        <h3 id="tourTitle">Main Entrance</h3>
                                        <div class="tour-info-badge">
                                            <i data-lucide="star"></i>
                                            <span>Featured</span>
                                        </div>
                                    </div>
                                    <p id="tourDescription">Welcome to Bharat English School & Jr. College. Our grand entrance reflects our commitment to excellence and provides a warm welcome to all students and visitors.</p>
                                    <div class="tour-info-features">
                                        <span class="feature-tag">Modern Design</span>
                                        <span class="feature-tag">Security</span>
                                        <span class="feature-tag">Accessibility</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tour-image-controls">
                            <button class="tour-zoom-btn" id="zoomInBtn" title="Zoom In">
                                <i data-lucide="zoom-in"></i>
                            </button>
                            <button class="tour-zoom-btn" id="zoomOutBtn" title="Zoom Out">
                                <i data-lucide="zoom-out"></i>
                            </button>
                            <button class="tour-reset-btn" id="resetViewBtn" title="Reset View">
                                <i data-lucide="refresh-cw"></i>
                            </button>
                        </div>
                    </div>
                    <div class="tour-controls">
                        <button class="tour-control-btn" id="prevLocation" title="Previous Location">
                            <i data-lucide="chevron-left"></i>
                        </button>
                        <div class="tour-progress">
                            <div class="progress-bar">
                                <div class="progress-fill"></div>
                            </div>
                            <span class="progress-text">1 of 6</span>
                        </div>
                        <button class="tour-control-btn" id="nextLocation" title="Next Location">
                            <i data-lucide="chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.body.appendChild(tourOverlay);
    
    // Add styles for virtual tour
    const tourStyles = document.createElement('style');
    tourStyles.textContent = `
        .virtual-tour-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            animation: modalFadeIn 0.4s ease forwards;
        }
        
        .virtual-tour-container {
            background: white;
            border-radius: 24px;
            width: 95%;
            max-width: 1400px;
            height: 85%;
            max-height: 900px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            transform: scale(0.8) translateY(50px);
            animation: modalSlideIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            position: relative;
        }
        
        .tour-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0;
            position: relative;
            overflow: hidden;
        }
        
        .tour-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .tour-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            position: relative;
            z-index: 1;
        }
        
        .tour-title-section h2 {
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .tour-subtitle {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .tour-header-actions {
            display: flex;
            gap: 10px;
        }
        
        .tour-fullscreen-btn, .close-tour {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .tour-fullscreen-btn:hover, .close-tour:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .tour-content {
            display: flex;
            height: calc(100% - 90px);
        }
        
        .tour-navigation {
            width: 300px;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            border-right: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
        }
        
        .tour-nav-header {
            padding: 20px 25px 15px;
            border-bottom: 1px solid #e2e8f0;
            background: white;
        }
        
        .tour-nav-header h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
        }
        
        .tour-nav-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: #64748b;
        }
        
        .current-location {
            color: #667eea;
            font-weight: 600;
        }
        
        .tour-nav-buttons {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .tour-nav-btn {
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            padding: 18px;
            margin-bottom: 12px;
            background: white;
            border: 2px solid transparent;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-align: left;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .tour-nav-btn:hover {
            border-color: #667eea;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }
        
        .tour-nav-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: #667eea;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .nav-btn-icon {
            width: 40px;
            height: 40px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .tour-nav-btn.active .nav-btn-icon {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .nav-btn-icon i {
            width: 20px;
            height: 20px;
        }
        
        .nav-btn-content {
            flex: 1;
        }
        
        .nav-btn-title {
            display: block;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 4px;
        }
        
        .nav-btn-desc {
            display: block;
            font-size: 13px;
            opacity: 0.7;
            font-weight: 400;
        }
        
        .tour-viewer {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #000;
        }
        
        .tour-image-container {
            flex: 1;
            position: relative;
            overflow: hidden;
        }
        
        .tour-image-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .tour-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .tour-image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.9));
            color: white;
            padding: 40px 30px 30px;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .tour-image-wrapper:hover .tour-image-overlay {
            transform: translateY(0);
        }
        
        .tour-info-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .tour-overlay-info h3 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .tour-info-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            background: rgba(250, 204, 21, 0.9);
            color: #1a1a1a;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .tour-overlay-info p {
            margin: 0 0 20px 0;
            font-size: 16px;
            line-height: 1.7;
            opacity: 0.95;
        }
        
        .tour-info-features {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .feature-tag {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }
        
        .tour-image-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
            z-index: 10;
        }
        
        .tour-zoom-btn, .tour-reset-btn {
            background: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tour-zoom-btn:hover, .tour-reset-btn:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }
        
        .tour-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 25px 30px;
            background: linear-gradient(135deg, #1e293b, #334155);
            color: white;
        }
        
        .tour-control-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .tour-control-btn:hover:not(:disabled) {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }
        
        .tour-control-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        .tour-progress {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .progress-bar {
            width: 250px;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            width: 16.67%;
            transition: width 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 4px;
        }
        
        .progress-text {
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }
        
        @media (max-width: 768px) {
            .virtual-tour-container {
                width: 100%;
                height: 100%;
                max-width: none;
                max-height: none;
                border-radius: 0;
                margin: 0;
            }
            
            .tour-header {
                padding: 15px 20px;
            }
            
            .tour-header-content {
                padding: 15px 20px;
            }
            
            .tour-title-section h2 {
                font-size: 20px;
                margin-bottom: 3px;
            }
            
            .tour-subtitle {
                font-size: 12px;
            }
            
            .tour-fullscreen-btn, .close-tour {
                width: 35px;
                height: 35px;
                font-size: 16px;
                padding: 8px;
            }
            
            .tour-content {
                flex-direction: column;
                height: calc(100% - 70px);
            }
            
            .tour-navigation {
                width: 100%;
                height: auto;
                max-height: 200px;
                overflow-y: auto;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .tour-nav-header {
                padding: 15px 20px 10px;
            }
            
            .tour-nav-header h3 {
                font-size: 16px;
                margin-bottom: 8px;
            }
            
            .tour-nav-buttons {
                padding: 15px 20px;
                display: flex;
                gap: 10px;
                overflow-x: auto;
                flex-wrap: nowrap;
            }
            
            .tour-nav-btn {
                min-width: 140px;
                padding: 12px;
                margin-bottom: 0;
                flex-shrink: 0;
                transform: none;
            }
            
            .tour-nav-btn:hover {
                transform: translateY(-2px) scale(1.02);
            }
            
            .tour-nav-btn.active {
                transform: translateY(-2px) scale(1.02);
            }
            
            .nav-btn-icon {
                width: 30px;
                height: 30px;
            }
            
            .nav-btn-title {
                font-size: 14px;
            }
            
            .nav-btn-desc {
                font-size: 11px;
            }
            
            .tour-viewer {
                flex: 1;
                min-height: 0;
            }
            
            .tour-image-container {
                position: relative;
            }
            
            .tour-image-wrapper {
                height: 100%;
            }
            
            .tour-image-overlay {
                padding: 20px 15px 15px;
                transform: translateY(0);
                background: linear-gradient(transparent 0%, rgba(0, 0, 0, 0.7) 30%, rgba(0, 0, 0, 0.9) 100%);
            }
            
            .tour-overlay-info h3 {
                font-size: 20px;
                margin-bottom: 8px;
            }
            
            .tour-overlay-info p {
                font-size: 14px;
                line-height: 1.5;
                margin-bottom: 15px;
            }
            
            .tour-info-features {
                gap: 8px;
            }
            
            .feature-tag {
                font-size: 11px;
                padding: 4px 8px;
            }
            
            .tour-image-controls {
                top: 15px;
                right: 15px;
                gap: 8px;
            }
            
            .tour-zoom-btn, .tour-reset-btn {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
            
            .tour-controls {
                padding: 15px 20px;
                flex-wrap: wrap;
                gap: 15px;
            }
            
            .tour-control-btn {
                width: 45px;
                height: 45px;
                font-size: 16px;
            }
            
            .tour-progress {
                flex: 1;
                min-width: 0;
            }
            
            .progress-bar {
                width: 100%;
                max-width: 200px;
                height: 6px;
            }
            
            .progress-text {
                font-size: 12px;
                white-space: nowrap;
            }
        }
        
        @media (max-width: 480px) {
            .virtual-tour-container {
                width: 100%;
                height: 100%;
            }
            
            .tour-header-content {
                padding: 12px 15px;
            }
            
            .tour-title-section h2 {
                font-size: 18px;
            }
            
            .tour-subtitle {
                font-size: 11px;
            }
            
            .tour-nav-buttons {
                padding: 12px 15px;
                gap: 8px;
            }
            
            .tour-nav-btn {
                min-width: 120px;
                padding: 10px;
            }
            
            .nav-btn-icon {
                width: 25px;
                height: 25px;
            }
            
            .nav-btn-title {
                font-size: 13px;
            }
            
            .nav-btn-desc {
                font-size: 10px;
            }
            
            .tour-image-overlay {
                padding: 15px 12px 12px;
            }
            
            .tour-overlay-info h3 {
                font-size: 18px;
            }
            
            .tour-overlay-info p {
                font-size: 13px;
            }
            
            .tour-controls {
                padding: 12px 15px;
            }
            
            .tour-control-btn {
                width: 40px;
                height: 40px;
            }
            
            .progress-bar {
                max-width: 150px;
            }
        }
        
        @media (max-width: 360px) {
            .tour-title-section h2 {
                font-size: 16px;
            }
            
            .tour-nav-btn {
                min-width: 100px;
                padding: 8px;
            }
            
            .nav-btn-icon {
                width: 20px;
                height: 20px;
            }
            
            .tour-overlay-info h3 {
                font-size: 16px;
            }
            
            .tour-overlay-info p {
                font-size: 12px;
            }
        }
        
        /* Mobile-specific enhancements */
        @media (max-width: 768px) {
            .virtual-tour-overlay {
                -webkit-overflow-scrolling: touch;
                overscroll-behavior: contain;
            }
            
            .tour-image-container {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                touch-action: manipulation;
            }
            
            .tour-image-container img {
                -webkit-user-drag: none;
                -khtml-user-drag: none;
                -moz-user-drag: none;
                -o-user-drag: none;
                user-drag: none;
            }
            
            .tour-nav-buttons {
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .tour-nav-buttons::-webkit-scrollbar {
                display: none;
            }
            
            .tour-control-btn {
                -webkit-tap-highlight-color: transparent;
                touch-action: manipulation;
            }
            
            .tour-nav-btn {
                -webkit-tap-highlight-color: transparent;
                touch-action: manipulation;
            }
            
            .tour-zoom-btn, .tour-reset-btn {
                -webkit-tap-highlight-color: transparent;
                touch-action: manipulation;
            }
        }
        
        /* Prevent zoom on input focus on iOS */
        @media screen and (-webkit-min-device-pixel-ratio: 0) {
            .virtual-tour-container {
                font-size: 16px;
            }
        }
        
        /* Landscape mobile optimizations */
        @media (max-width: 768px) and (orientation: landscape) {
            .virtual-tour-container {
                height: 100%;
            }
            
            .tour-navigation {
                max-height: 120px;
            }
            
            .tour-nav-buttons {
                padding: 8px 15px;
            }
            
            .tour-nav-btn {
                min-width: 100px;
                padding: 8px;
            }
            
            .nav-btn-icon {
                width: 20px;
                height: 20px;
            }
            
            .nav-btn-title {
                font-size: 12px;
            }
            
            .nav-btn-desc {
                font-size: 9px;
            }
        }
    `;
    
    document.head.appendChild(tourStyles);
    
    // Show overlay with animation
    setTimeout(() => {
        tourOverlay.classList.add('show');
    }, 10);
    
    // Initialize tour functionality
    const tourData = [
        {
            location: 'entrance',
            title: 'Main Entrance',
            description: 'Welcome to Bharat English School & Jr. College. Our grand entrance reflects our commitment to excellence and provides a warm welcome to all students and visitors.',
            image: 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Modern Design', 'Security', 'Accessibility'],
            featured: true,
            icon: 'home'
        },
        {
            location: 'classrooms',
            title: 'Modern Classrooms',
            description: 'State-of-the-art classrooms equipped with smart boards, comfortable seating, and technology-enhanced learning environments that foster creativity and engagement.',
            image: 'https://images.unsplash.com/photo-1509062522246-3755977927d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Smart Boards', 'Comfortable Seating', 'Technology'],
            featured: false,
            icon: 'book-open'
        },
        {
            location: 'library',
            title: 'Digital Library',
            description: 'Our extensive library houses thousands of books, digital resources, and study spaces where students can explore knowledge and develop research skills.',
            image: 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Digital Resources', 'Study Spaces', 'Research Tools'],
            featured: true,
            icon: 'library'
        },
        {
            location: 'labs',
            title: 'Science Laboratories',
            description: 'Well-equipped physics, chemistry, and biology laboratories where students conduct experiments and develop practical scientific skills.',
            image: 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Physics Lab', 'Chemistry Lab', 'Biology Lab'],
            featured: false,
            icon: 'flask-conical'
        },
        {
            location: 'sports',
            title: 'Sports Complex',
            description: 'Multi-purpose sports facilities including indoor and outdoor courts, swimming pool, and fitness center promoting physical well-being and sportsmanship.',
            image: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Indoor Courts', 'Swimming Pool', 'Fitness Center'],
            featured: true,
            icon: 'trophy'
        },
        {
            location: 'auditorium',
            title: 'Auditorium',
            description: 'A modern auditorium with advanced audio-visual systems, perfect for performances, presentations, and school events.',
            image: 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            features: ['Audio-Visual Systems', 'Performances', 'Events'],
            featured: false,
            icon: 'users'
        }
    ];
    
    let currentLocationIndex = 0;
    
    function updateTourView(locationIndex) {
        const location = tourData[locationIndex];
        const tourImage = document.getElementById('tourImage');
        const tourTitle = document.getElementById('tourTitle');
        const tourDescription = document.getElementById('tourDescription');
        const progressFill = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-text');
        const currentLocationSpan = document.querySelector('.current-location');
        const tourInfoBadge = document.querySelector('.tour-info-badge');
        const tourInfoFeatures = document.querySelector('.tour-info-features');
        
        // Update image with fade effect and zoom animation
        tourImage.style.opacity = '0';
        tourImage.style.transform = 'scale(1.1)';
        setTimeout(() => {
            tourImage.src = location.image;
            tourImage.alt = location.title;
            tourImage.style.opacity = '1';
            tourImage.style.transform = 'scale(1)';
            tourImage.style.animation = 'tourImageZoom 0.6s ease';
        }, 200);
        
        // Update text content
        tourTitle.textContent = location.title;
        tourDescription.textContent = location.description;
        
        // Update progress
        const progress = ((locationIndex + 1) / tourData.length) * 100;
        progressFill.style.width = progress + '%';
        progressText.textContent = `${locationIndex + 1} of ${tourData.length}`;
        currentLocationSpan.textContent = locationIndex + 1;
        
        // Update featured badge
        if (location.featured) {
            tourInfoBadge.style.display = 'flex';
            tourInfoBadge.innerHTML = '<i data-lucide="star"></i><span>Featured</span>';
        } else {
            tourInfoBadge.style.display = 'none';
        }
        
        // Update features
        tourInfoFeatures.innerHTML = location.features.map(feature => 
            `<span class="feature-tag">${feature}</span>`
        ).join('');
        
        // Update navigation buttons
        document.querySelectorAll('.tour-nav-btn').forEach((btn, index) => {
            btn.classList.toggle('active', index === locationIndex);
            const icon = btn.querySelector('.nav-btn-icon i');
            if (icon) {
                icon.setAttribute('data-lucide', tourData[index].icon);
            }
        });
        
        // Update control buttons
        document.getElementById('prevLocation').disabled = locationIndex === 0;
        document.getElementById('nextLocation').disabled = locationIndex === tourData.length - 1;
        
        // Reinitialize icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    
    // Enhanced functionality variables
    let isFullscreen = false;
    let currentZoom = 1;
    const maxZoom = 3;
    const minZoom = 0.5;
    
    // Event listeners
    document.getElementById('closeTour').addEventListener('click', () => {
        tourOverlay.style.animation = 'modalFadeIn 0.3s ease reverse';
        tourOverlay.style.opacity = '0';
        setTimeout(() => {
            tourOverlay.remove();
            tourStyles.remove();
        }, 300);
    });
    
    // Fullscreen functionality
    document.getElementById('fullscreenBtn').addEventListener('click', () => {
        const container = document.querySelector('.virtual-tour-container');
        if (!isFullscreen) {
            container.style.width = '100vw';
            container.style.height = '100vh';
            container.style.maxWidth = 'none';
            container.style.maxHeight = 'none';
            container.style.borderRadius = '0';
            document.getElementById('fullscreenBtn').innerHTML = '<i data-lucide="minimize-2"></i>';
        } else {
            container.style.width = '95%';
            container.style.height = '85%';
            container.style.maxWidth = '1400px';
            container.style.maxHeight = '900px';
            container.style.borderRadius = '24px';
            document.getElementById('fullscreenBtn').innerHTML = '<i data-lucide="maximize-2"></i>';
        }
        isFullscreen = !isFullscreen;
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
    
    // Zoom functionality
    document.getElementById('zoomInBtn').addEventListener('click', () => {
        if (currentZoom < maxZoom) {
            currentZoom += 0.5;
            updateImageZoom();
        }
    });
    
    document.getElementById('zoomOutBtn').addEventListener('click', () => {
        if (currentZoom > minZoom) {
            currentZoom -= 0.5;
            updateImageZoom();
        }
    });
    
    document.getElementById('resetViewBtn').addEventListener('click', () => {
        currentZoom = 1;
        updateImageZoom();
    });
    
    function updateImageZoom() {
        const tourImage = document.getElementById('tourImage');
        tourImage.style.transform = `scale(${currentZoom})`;
        
        // Update zoom button states
        document.getElementById('zoomInBtn').disabled = currentZoom >= maxZoom;
        document.getElementById('zoomOutBtn').disabled = currentZoom <= minZoom;
    }
    
    // Navigation event listeners
    document.querySelectorAll('.tour-nav-btn').forEach((btn, index) => {
        btn.addEventListener('click', () => {
            currentLocationIndex = index;
            currentZoom = 1; // Reset zoom when changing location
            updateTourView(currentLocationIndex);
            updateImageZoom();
        });
    });
    
    document.getElementById('prevLocation').addEventListener('click', () => {
        if (currentLocationIndex > 0) {
            currentLocationIndex--;
            currentZoom = 1; // Reset zoom when changing location
            updateTourView(currentLocationIndex);
            updateImageZoom();
        }
    });
    
    document.getElementById('nextLocation').addEventListener('click', () => {
        if (currentLocationIndex < tourData.length - 1) {
            currentLocationIndex++;
            currentZoom = 1; // Reset zoom when changing location
            updateTourView(currentLocationIndex);
            updateImageZoom();
        }
    });
    
    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('closeTour').click();
        } else if (e.key === 'ArrowLeft') {
            document.getElementById('prevLocation').click();
        } else if (e.key === 'ArrowRight') {
            document.getElementById('nextLocation').click();
        } else if (e.key === 'f' || e.key === 'F') {
            document.getElementById('fullscreenBtn').click();
        } else if (e.key === '+' || e.key === '=') {
            document.getElementById('zoomInBtn').click();
        } else if (e.key === '-') {
            document.getElementById('zoomOutBtn').click();
        } else if (e.key === '0') {
            document.getElementById('resetViewBtn').click();
        }
    });
    
    // Mouse wheel zoom
    const tourImageContainer = document.querySelector('.tour-image-container');
    tourImageContainer.addEventListener('wheel', (e) => {
        e.preventDefault();
        if (e.deltaY < 0 && currentZoom < maxZoom) {
            currentZoom += 0.2;
            updateImageZoom();
        } else if (e.deltaY > 0 && currentZoom > minZoom) {
            currentZoom -= 0.2;
            updateImageZoom();
        }
    });
    
    // Mobile touch interactions
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;
    let initialDistance = 0;
    let isPinching = false;
    
    // Touch start
    tourImageContainer.addEventListener('touchstart', (e) => {
        if (e.touches.length === 1) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        } else if (e.touches.length === 2) {
            isPinching = true;
            initialDistance = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
        }
    });
    
    // Touch move
    tourImageContainer.addEventListener('touchmove', (e) => {
        e.preventDefault();
        
        if (isPinching && e.touches.length === 2) {
            const currentDistance = Math.hypot(
                e.touches[0].clientX - e.touches[1].clientX,
                e.touches[0].clientY - e.touches[1].clientY
            );
            
            const scale = currentDistance / initialDistance;
            const newZoom = Math.max(minZoom, Math.min(maxZoom, currentZoom * scale));
            
            if (Math.abs(newZoom - currentZoom) > 0.1) {
                currentZoom = newZoom;
                updateImageZoom();
                initialDistance = currentDistance;
            }
        }
    });
    
    // Touch end
    tourImageContainer.addEventListener('touchend', (e) => {
        if (e.touches.length === 0) {
            if (!isPinching && touchStartX && touchStartY) {
                touchEndX = e.changedTouches[0].clientX;
                touchEndY = e.changedTouches[0].clientY;
                
                const deltaX = touchStartX - touchEndX;
                const deltaY = touchStartY - touchEndY;
                const minSwipeDistance = 50;
                
                // Horizontal swipe for navigation
                if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > minSwipeDistance) {
                    if (deltaX > 0 && currentLocationIndex < tourData.length - 1) {
                        // Swipe left - next location
                        currentLocationIndex++;
                        currentZoom = 1;
                        updateTourView(currentLocationIndex);
                        updateImageZoom();
                    } else if (deltaX < 0 && currentLocationIndex > 0) {
                        // Swipe right - previous location
                        currentLocationIndex--;
                        currentZoom = 1;
                        updateTourView(currentLocationIndex);
                        updateImageZoom();
                    }
                }
                
                // Vertical swipe for zoom reset
                if (Math.abs(deltaY) > Math.abs(deltaX) && Math.abs(deltaY) > minSwipeDistance) {
                    if (deltaY > 0 && currentZoom !== 1) {
                        // Swipe up - reset zoom
                        currentZoom = 1;
                        updateImageZoom();
                    }
                }
            }
            
            isPinching = false;
            touchStartX = 0;
            touchStartY = 0;
            touchEndX = 0;
            touchEndY = 0;
        }
    });
    
    // Double tap to reset zoom
    let lastTap = 0;
    tourImageContainer.addEventListener('touchend', (e) => {
        const currentTime = new Date().getTime();
        const tapLength = currentTime - lastTap;
        
        if (tapLength < 500 && tapLength > 0) {
            // Double tap detected
            currentZoom = 1;
            updateImageZoom();
            e.preventDefault();
        }
        lastTap = currentTime;
    });
    
    // Auto-advance tour (optional) - Mobile optimized
    let autoAdvanceInterval;
    let isMobile = window.innerWidth <= 768;
    
    function startAutoAdvance() {
        // Disable auto-advance on mobile for better user experience
        if (isMobile) return;
        
        autoAdvanceInterval = setInterval(() => {
            if (currentLocationIndex < tourData.length - 1) {
                currentLocationIndex++;
                currentZoom = 1;
                updateTourView(currentLocationIndex);
                updateImageZoom();
            } else {
                stopAutoAdvance();
            }
        }, 5000); // Change every 5 seconds
    }
    
    function stopAutoAdvance() {
        if (autoAdvanceInterval) {
            clearInterval(autoAdvanceInterval);
            autoAdvanceInterval = null;
        }
    }
    
    // Start auto-advance after 15 seconds of inactivity (longer on mobile)
    let inactivityTimer = setTimeout(startAutoAdvance, isMobile ? 15000 : 10000);
    
    // Reset inactivity timer on any interaction
    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        stopAutoAdvance();
        inactivityTimer = setTimeout(startAutoAdvance, isMobile ? 15000 : 10000);
    }
    
    // Add event listeners for inactivity detection
    tourOverlay.addEventListener('mousemove', resetInactivityTimer);
    tourOverlay.addEventListener('click', resetInactivityTimer);
    tourOverlay.addEventListener('keydown', resetInactivityTimer);
    tourOverlay.addEventListener('touchstart', resetInactivityTimer);
    tourOverlay.addEventListener('touchmove', resetInactivityTimer);
    
    // Mobile-specific optimizations
    function optimizeForMobile() {
        if (isMobile) {
            // Hide zoom controls on very small screens
            const zoomControls = document.querySelector('.tour-image-controls');
            if (window.innerWidth <= 480 && zoomControls) {
                zoomControls.style.display = 'none';
            }
            
            // Adjust navigation for better mobile experience
            const navButtons = document.querySelector('.tour-nav-buttons');
            if (navButtons) {
                navButtons.style.scrollBehavior = 'smooth';
            }
            
            // Add mobile-specific instructions
            const tourSubtitle = document.querySelector('.tour-subtitle');
            if (tourSubtitle) {
                tourSubtitle.textContent = 'Swipe to navigate • Pinch to zoom • Double-tap to reset';
            }
        }
    }
    
    // Call mobile optimization
    optimizeForMobile();
    
    // Handle orientation change
    window.addEventListener('orientationchange', () => {
        setTimeout(() => {
            isMobile = window.innerWidth <= 768;
            optimizeForMobile();
        }, 500);
    });
    
    // Handle resize
    window.addEventListener('resize', () => {
        isMobile = window.innerWidth <= 768;
        optimizeForMobile();
    });
    
    // Initialize first view
    updateTourView(currentLocationIndex);
    updateImageZoom();
    
    // Reinitialize Lucide icons for the new elements
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

// ===== FALLBACK FOR LOADING SCREEN =====
// Ensure loading screen is removed even if other scripts fail
window.addEventListener('load', () => {
    console.log('Window loaded');
    const loadingScreen = document.getElementById('loadingScreen');
    if (loadingScreen && loadingScreen.parentNode) {
        console.log('Force removing loading screen on window load');
        loadingScreen.classList.add('hidden');
        setTimeout(() => {
            if (loadingScreen && loadingScreen.parentNode) {
                loadingScreen.remove();
            }
        }, 500);
    }
});

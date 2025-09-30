// Optimized JavaScript for Car Rental Application

// Import essential dependencies
import './bootstrap';
import Alpine from 'alpinejs';

// Performance optimizations
class AppOptimizer {
    constructor() {
        this.init();
    }

    init() {
        this.setupLazyLoading();
        this.setupCriticalResources();
        this.setupServiceWorker();
        this.setupAnalytics();
    }

    // Lazy loading for images
    setupLazyLoading() {
        const images = document.querySelectorAll('img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.setAttribute('data-loaded', 'true');
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => imageObserver.observe(img));
    }

    // Preload critical resources
    setupCriticalResources() {
        const criticalResources = [
            '/css/style.css',
            '/js/plugins.js',
            '/images/logo.png'
        ];

        criticalResources.forEach(resource => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = resource;
            link.as = resource.endsWith('.css') ? 'style' : 
                     resource.endsWith('.js') ? 'script' : 'image';
            document.head.appendChild(link);
        });
    }

    // Service Worker registration
    setupServiceWorker() {
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('SW registered: ', registration);
                })
                .catch(registrationError => {
                    console.log('SW registration failed: ', registrationError);
                });
        }
    }

    // Analytics setup (placeholder)
    setupAnalytics() {
        // Implement your analytics tracking here
        console.log('Analytics initialized');
    }
}

// Car search functionality
class CarSearch {
    constructor() {
        this.setupSearchForm();
        this.setupFilters();
    }

    setupSearchForm() {
        const searchForm = document.querySelector('#car-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', this.handleSearch.bind(this));
        }
    }

    setupFilters() {
        const filterElements = document.querySelectorAll('.filter-option');
        filterElements.forEach(filter => {
            filter.addEventListener('change', this.applyFilters.bind(this));
        });
    }

    handleSearch(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const searchParams = new URLSearchParams(formData);
        
        // Implement search logic
        this.performSearch(searchParams);
    }

    applyFilters() {
        // Implement filter logic
        console.log('Filters applied');
    }

    async performSearch(params) {
        try {
            const response = await fetch(`/api/v1/cars?${params}`);
            const data = await response.json();
            this.displayResults(data);
        } catch (error) {
            console.error('Search error:', error);
        }
    }

    displayResults(data) {
        const resultsContainer = document.querySelector('#search-results');
        if (resultsContainer && data.success) {
            // Implement results display
            console.log('Results displayed:', data);
        }
    }
}

// Booking functionality
class BookingManager {
    constructor() {
        this.setupBookingForm();
        this.setupDatePickers();
    }

    setupBookingForm() {
        const bookingForm = document.querySelector('#booking-form');
        if (bookingForm) {
            bookingForm.addEventListener('submit', this.handleBooking.bind(this));
        }
    }

    setupDatePickers() {
        // Initialize date pickers with validation
        const datePickers = document.querySelectorAll('.date-picker');
        datePickers.forEach(picker => {
            // Implement date picker initialization
            picker.addEventListener('change', this.validateDates.bind(this));
        });
    }

    validateDates() {
        const pickupDate = document.querySelector('#pickup_date')?.value;
        const returnDate = document.querySelector('#return_date')?.value;
        
        if (pickupDate && returnDate) {
            const pickup = new Date(pickupDate);
            const returnD = new Date(returnDate);
            
            if (returnD <= pickup) {
                this.showError('Return date must be after pickup date');
                return false;
            }
        }
        return true;
    }

    async handleBooking(event) {
        event.preventDefault();
        
        if (!this.validateDates()) return;
        
        const formData = new FormData(event.target);
        
        try {
            const response = await fetch('/api/v1/bookings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.showSuccess('Booking created successfully!');
                window.location.href = `/bookings/${data.data.booking.id}`;
            } else {
                this.showError(data.message);
            }
        } catch (error) {
            this.showError('Booking failed. Please try again.');
        }
    }

    showError(message) {
        this.showAlert(message, 'error');
    }

    showSuccess(message) {
        this.showAlert(message, 'success');
    }

    showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.alert-container') || document.body;
        container.appendChild(alert);
        
        setTimeout(() => alert.remove(), 5000);
    }
}

// Theme manager
class ThemeManager {
    constructor() {
        this.currentTheme = localStorage.getItem('theme') || 'light';
        this.init();
    }

    init() {
        this.applyTheme();
        this.setupThemeToggle();
    }

    applyTheme() {
        document.documentElement.setAttribute('data-theme', this.currentTheme);
    }

    setupThemeToggle() {
        const themeToggle = document.querySelector('#theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', this.toggleTheme.bind(this));
        }
    }

    toggleTheme() {
        this.currentTheme = this.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', this.currentTheme);
        this.applyTheme();
    }
}

// Performance monitoring
class PerformanceMonitor {
    constructor() {
        this.metrics = {};
        this.init();
    }

    init() {
        this.measurePageLoad();
        this.setupResourceObserver();
    }

    measurePageLoad() {
        window.addEventListener('load', () => {
            const perfData = performance.getEntriesByType('navigation')[0];
            this.metrics.pageLoad = {
                loadTime: perfData.loadEventEnd - perfData.loadEventStart,
                domContentLoaded: perfData.domContentLoadedEventEnd - perfData.domContentLoadedEventStart,
                totalTime: perfData.loadEventEnd - perfData.fetchStart
            };
            
            console.log('Page Load Metrics:', this.metrics.pageLoad);
        });
    }

    setupResourceObserver() {
        if ('PerformanceObserver' in window) {
            const observer = new PerformanceObserver((list) => {
                list.getEntries().forEach((entry) => {
                    if (entry.duration > 100) { // Log slow resources
                        console.log('Slow resource:', entry.name, entry.duration);
                    }
                });
            });
            observer.observe({ entryTypes: ['resource'] });
        }
    }
}

// Initialize application
document.addEventListener('DOMContentLoaded', () => {
    new AppOptimizer();
    new CarSearch();
    new BookingManager();
    new ThemeManager();
    new PerformanceMonitor();
});

// Make Alpine.js available globally
window.Alpine = Alpine;
Alpine.start();

// Export for module usage
export { CarSearch, BookingManager, ThemeManager };
@props([
    'counters' => [],
    'animationDuration' => 2000,
    'animationDelay' => 100,
    'easing' => 'easeOutCubic',
    'triggerOnScroll' => true,
    'triggerOffset' => 0.8,
    'prefix' => '',
    'suffix' => '',
    'separator' => ',',
    'decimal' => '.',
    'decimals' => 0,
    'layout' => 'horizontal', // horizontal, vertical, grid
    'columns' => 4,
    'theme' => 'default', // default, minimal, card, circle
    'size' => 'md', // sm, md, lg
    'color' => 'primary',
    'background' => 'transparent',
    'textAlign' => 'center',
    'showProgress' => false,
    'progressStyle' => 'line', // line, circle, bar
    'iconPosition' => 'top', // top, left, right, bottom
    'responsive' => true
])

@php
$counterId = 'counters-' . uniqid();

// Size classes
$sizeClasses = [
    'sm' => 'counter-sm',
    'md' => 'counter-md',
    'lg' => 'counter-lg'
];

// Theme classes
$themeClasses = [
    'default' => 'counter-default',
    'minimal' => 'counter-minimal',
    'card' => 'counter-card',
    'circle' => 'counter-circle'
];

$containerClass = 'counters-container ' . ($themeClasses[$theme] ?? 'counter-default') . ' ' . ($sizeClasses[$size] ?? 'counter-md');

if ($layout === 'grid') {
    $containerClass .= ' counters-grid counters-grid-' . $columns;
} else {
    $containerClass .= ' counters-' . $layout;
}

if ($responsive) {
    $containerClass .= ' counters-responsive';
}
@endphp

<style>
/* Counter Container Styles */
.counters-container {
    display: flex;
    gap: 20px;
    align-items: center;
    justify-content: center;
}

.counters-horizontal {
    flex-direction: row;
    flex-wrap: wrap;
}

.counters-vertical {
    flex-direction: column;
}

.counters-grid {
    display: grid;
    gap: 20px;
}

.counters-grid-2 { grid-template-columns: repeat(2, 1fr); }
.counters-grid-3 { grid-template-columns: repeat(3, 1fr); }
.counters-grid-4 { grid-template-columns: repeat(4, 1fr); }
.counters-grid-5 { grid-template-columns: repeat(5, 1fr); }
.counters-grid-6 { grid-template-columns: repeat(6, 1fr); }

/* Individual Counter Styles */
.counter-item {
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: {{ $textAlign }};
    background: {{ $background }};
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

/* Size Variations */
.counter-sm .counter-item {
    padding: 15px;
    min-width: 120px;
}

.counter-sm .counter-number {
    font-size: 1.5rem;
    font-weight: 700;
}

.counter-sm .counter-label {
    font-size: 0.8rem;
    margin-top: 4px;
}

.counter-sm .counter-icon {
    font-size: 1.5rem;
    margin-bottom: 8px;
}

.counter-md .counter-item {
    padding: 20px;
    min-width: 150px;
}

.counter-md .counter-number {
    font-size: 2rem;
    font-weight: 700;
}

.counter-md .counter-label {
    font-size: 0.9rem;
    margin-top: 6px;
}

.counter-md .counter-icon {
    font-size: 2rem;
    margin-bottom: 10px;
}

.counter-lg .counter-item {
    padding: 30px;
    min-width: 200px;
}

.counter-lg .counter-number {
    font-size: 3rem;
    font-weight: 700;
}

.counter-lg .counter-label {
    font-size: 1rem;
    margin-top: 8px;
}

.counter-lg .counter-icon {
    font-size: 2.5rem;
    margin-bottom: 12px;
}

/* Theme Variations */
.counter-default .counter-item {
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.counter-default .counter-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.counter-minimal .counter-item {
    background: transparent;
    border: none;
}

.counter-minimal .counter-item:hover {
    transform: scale(1.05);
}

.counter-card .counter-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
}

.counter-card .counter-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.counter-circle .counter-item {
    border-radius: 50%;
    aspect-ratio: 1;
    flex-direction: column;
    background: linear-gradient(135deg, var(--bs-primary, #0d6efd), var(--bs-primary-dark, #0b5ed7));
    color: white;
    border: 3px solid rgba(255, 255, 255, 0.3);
}

.counter-circle .counter-item:hover {
    transform: scale(1.1) rotate(5deg);
}

/* Icon Positioning */
.counter-item.icon-top {
    flex-direction: column;
}

.counter-item.icon-left {
    flex-direction: row;
    text-align: left;
}

.counter-item.icon-left .counter-icon {
    margin-right: 15px;
    margin-bottom: 0;
}

.counter-item.icon-right {
    flex-direction: row-reverse;
    text-align: right;
}

.counter-item.icon-right .counter-icon {
    margin-left: 15px;
    margin-bottom: 0;
}

.counter-item.icon-bottom {
    flex-direction: column-reverse;
}

.counter-item.icon-bottom .counter-icon {
    margin-top: 10px;
    margin-bottom: 0;
}

/* Counter Content */
.counter-content {
    flex: 1;
}

.counter-number {
    display: block;
    line-height: 1;
    color: var(--bs-{{ $color }}, #0d6efd);
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.counter-label {
    display: block;
    color: #6c757d;
    font-weight: 500;
    line-height: 1.2;
    opacity: 0.8;
}

.counter-icon {
    color: var(--bs-{{ $color }}, #0d6efd);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Progress Indicators */
.counter-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: var(--bs-{{ $color }}, #0d6efd);
    transition: width 2s ease;
    border-radius: 0 0 8px 8px;
}

.counter-progress.line {
    width: 0%;
}

.counter-progress.line.animated {
    width: 100%;
}

.counter-progress-circle {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: conic-gradient(var(--bs-{{ $color }}, #0d6efd) 0deg, transparent 0deg);
    transition: background 2s ease;
}

.counter-progress-bar {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent 0%, var(--bs-{{ $color }}, #0d6efd) 0%);
    opacity: 0.1;
    transition: background 2s ease;
    border-radius: inherit;
}

/* Dark Theme Support */
[data-bs-theme="dark"] .counter-card .counter-item {
    background: #343a40;
    border-color: #495057;
    color: #fff;
}

[data-bs-theme="dark"] .counter-label {
    color: #adb5bd;
}

[data-bs-theme="dark"] .counter-default .counter-item {
    background: rgba(0, 0, 0, 0.3);
    border-color: rgba(255, 255, 255, 0.1);
}

/* Responsive Design */
.counters-responsive.counters-grid {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
}

@media (max-width: 768px) {
    .counters-responsive.counters-horizontal {
        flex-direction: column;
    }
    
    .counters-responsive.counters-grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .counters-responsive.counters-grid-3 {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .counters-responsive.counters-grid-5,
    .counters-responsive.counters-grid-6 {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .counter-lg .counter-item {
        padding: 20px;
        min-width: 140px;
    }
    
    .counter-lg .counter-number {
        font-size: 2rem;
    }
    
    .counter-lg .counter-icon {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .counters-responsive.counters-grid {
        grid-template-columns: 1fr;
    }
    
    .counter-item {
        min-width: auto !important;
        width: 100%;
    }
}

/* Animation Classes */
.counter-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.counter-animate.animated {
    opacity: 1;
    transform: translateY(0);
}

/* Pulse Animation */
.counter-pulse {
    animation: counterPulse 2s ease-in-out infinite;
}

@keyframes counterPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Glow Effect */
.counter-glow {
    position: relative;
}

.counter-glow::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, var(--bs-primary, #0d6efd), var(--bs-secondary, #6c757d), var(--bs-primary, #0d6efd));
    border-radius: inherit;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.counter-glow:hover::before {
    opacity: 0.7;
    animation: glowRotate 2s linear infinite;
}

@keyframes glowRotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div id="{{ $counterId }}" class="{{ $containerClass }}" 
     data-trigger-scroll="{{ $triggerOnScroll ? 'true' : 'false' }}"
     data-trigger-offset="{{ $triggerOffset }}"
     data-animation-duration="{{ $animationDuration }}"
     data-animation-delay="{{ $animationDelay }}"
     data-easing="{{ $easing }}">
    
    @foreach($counters as $index => $counter)
        @php
        $itemId = $counterId . '-item-' . $index;
        $iconClass = 'icon-' . $iconPosition;
        $counterValue = $counter['value'] ?? 0;
        $counterLabel = $counter['label'] ?? '';
        $counterIcon = $counter['icon'] ?? '';
        $counterPrefix = $counter['prefix'] ?? $prefix;
        $counterSuffix = $counter['suffix'] ?? $suffix;
        $counterColor = $counter['color'] ?? $color;
        $counterDecimals = $counter['decimals'] ?? $decimals;
        $counterAnimation = $counter['animation'] ?? '';
        @endphp
        
        <div class="counter-item {{ $iconClass }} {{ $counterAnimation }}" 
             id="{{ $itemId }}"
             data-target="{{ $counterValue }}"
             data-prefix="{{ $counterPrefix }}"
             data-suffix="{{ $counterSuffix }}"
             data-decimals="{{ $counterDecimals }}"
             data-separator="{{ $separator }}"
             data-decimal="{{ $decimal }}">
            
            @if($counterIcon && in_array($iconPosition, ['top', 'left']))
                <div class="counter-icon">
                    <i class="{{ $counterIcon }}" style="color: var(--bs-{{ $counterColor }}, #0d6efd);"></i>
                </div>
            @endif
            
            <div class="counter-content">
                <span class="counter-number" style="color: var(--bs-{{ $counterColor }}, #0d6efd);">
                    {{ $counterPrefix }}0{{ $counterSuffix }}
                </span>
                @if($counterLabel)
                    <span class="counter-label">{{ $counterLabel }}</span>
                @endif
            </div>
            
            @if($counterIcon && in_array($iconPosition, ['bottom', 'right']))
                <div class="counter-icon">
                    <i class="{{ $counterIcon }}" style="color: var(--bs-{{ $counterColor }}, #0d6efd);"></i>
                </div>
            @endif
            
            @if($showProgress)
                @if($progressStyle === 'line')
                    <div class="counter-progress line"></div>
                @elseif($progressStyle === 'circle')
                    <div class="counter-progress-circle"></div>
                @elseif($progressStyle === 'bar')
                    <div class="counter-progress-bar"></div>
                @endif
            @endif
        </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const counterId = '{{ $counterId }}';
    const container = document.getElementById(counterId);
    const triggerOnScroll = container.dataset.triggerScroll === 'true';
    const triggerOffset = parseFloat(container.dataset.triggerOffset);
    const animationDuration = parseInt(container.dataset.animationDuration);
    const animationDelay = parseInt(container.dataset.animationDelay);
    const easing = container.dataset.easing;
    
    let animated = false;
    
    // Easing functions
    const easingFunctions = {
        linear: t => t,
        easeInQuad: t => t * t,
        easeOutQuad: t => t * (2 - t),
        easeInOutQuad: t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t,
        easeInCubic: t => t * t * t,
        easeOutCubic: t => (--t) * t * t + 1,
        easeInOutCubic: t => t < 0.5 ? 4 * t * t * t : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1,
        easeInQuart: t => t * t * t * t,
        easeOutQuart: t => 1 - (--t) * t * t * t,
        easeInOutQuart: t => t < 0.5 ? 8 * t * t * t * t : 1 - 8 * (--t) * t * t * t,
        easeOutBounce: t => {
            const n1 = 7.5625;
            const d1 = 2.75;
            if (t < 1 / d1) return n1 * t * t;
            else if (t < 2 / d1) return n1 * (t -= 1.5 / d1) * t + 0.75;
            else if (t < 2.5 / d1) return n1 * (t -= 2.25 / d1) * t + 0.9375;
            else return n1 * (t -= 2.625 / d1) * t + 0.984375;
        }
    };
    
    // Format number with separators
    function formatNumber(num, decimals, separator, decimal) {
        const parts = num.toFixed(decimals).split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, separator);
        return parts.join(decimal);
    }
    
    // Animate single counter
    function animateCounter(element, delay = 0) {
        const target = parseFloat(element.dataset.target) || 0;
        const prefix = element.dataset.prefix || '';
        const suffix = element.dataset.suffix || '';
        const decimals = parseInt(element.dataset.decimals) || 0;
        const separator = element.dataset.separator || ',';
        const decimal = element.dataset.decimal || '.';
        
        const numberElement = element.querySelector('.counter-number');
        const progressElement = element.querySelector('.counter-progress, .counter-progress-circle, .counter-progress-bar');
        
        const easingFunction = easingFunctions[easing] || easingFunctions.easeOutCubic;
        
        setTimeout(() => {
            let startTime = null;
            let startValue = 0;
            
            function animate(currentTime) {
                if (startTime === null) startTime = currentTime;
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / animationDuration, 1);
                const easedProgress = easingFunction(progress);
                
                const currentValue = startValue + (target - startValue) * easedProgress;
                const formattedValue = formatNumber(currentValue, decimals, separator, decimal);
                
                numberElement.textContent = prefix + formattedValue + suffix;
                
                // Update progress indicator
                if (progressElement) {
                    if (progressElement.classList.contains('line')) {
                        progressElement.style.width = (progress * 100) + '%';
                        progressElement.classList.add('animated');
                    } else if (progressElement.classList.contains('counter-progress-circle')) {
                        const degrees = progress * 360;
                        progressElement.style.background = `conic-gradient(var(--bs-primary, #0d6efd) ${degrees}deg, transparent ${degrees}deg)`;
                    } else if (progressElement.classList.contains('counter-progress-bar')) {
                        const percentage = progress * 100;
                        progressElement.style.background = `linear-gradient(90deg, transparent ${percentage}%, var(--bs-primary, #0d6efd) ${percentage}%)`;
                    }
                }
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    // Animation complete - dispatch event
                    element.dispatchEvent(new CustomEvent('counter:complete', {
                        detail: { 
                            target: target, 
                            finalValue: formattedValue,
                            element: element
                        }
                    }));
                }
            }
            
            // Add animation class
            element.classList.add('counter-animate', 'animated');
            
            requestAnimationFrame(animate);
        }, delay);
    }
    
    // Start all counters
    function startCounters() {
        if (animated) return;
        animated = true;
        
        const counterItems = container.querySelectorAll('.counter-item');
        
        counterItems.forEach((item, index) => {
            const delay = index * animationDelay;
            animateCounter(item, delay);
        });
        
        // Dispatch start event
        container.dispatchEvent(new CustomEvent('counters:started', {
            detail: { counterId: counterId }
        }));
    }
    
    // Check if element is in viewport
    function isInViewport(element) {
        const rect = element.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        return rect.top <= windowHeight * triggerOffset;
    }
    
    // Initialize
    if (triggerOnScroll) {
        // Add scroll listener
        function handleScroll() {
            if (isInViewport(container)) {
                startCounters();
                window.removeEventListener('scroll', handleScroll);
            }
        }
        
        window.addEventListener('scroll', handleScroll);
        handleScroll(); // Check initial position
    } else {
        // Start immediately
        startCounters();
    }
    
    // Global functions for external control
    window.CounterUtils = window.CounterUtils || {};
    window.CounterUtils[counterId] = {
        start: startCounters,
        reset: function() {
            animated = false;
            const counterItems = container.querySelectorAll('.counter-item');
            counterItems.forEach(item => {
                const numberElement = item.querySelector('.counter-number');
                const prefix = item.dataset.prefix || '';
                const suffix = item.dataset.suffix || '';
                numberElement.textContent = prefix + '0' + suffix;
                
                item.classList.remove('counter-animate', 'animated');
                
                const progressElement = item.querySelector('.counter-progress, .counter-progress-circle, .counter-progress-bar');
                if (progressElement) {
                    if (progressElement.classList.contains('line')) {
                        progressElement.style.width = '0%';
                        progressElement.classList.remove('animated');
                    } else if (progressElement.classList.contains('counter-progress-circle')) {
                        progressElement.style.background = 'conic-gradient(var(--bs-primary, #0d6efd) 0deg, transparent 0deg)';
                    } else if (progressElement.classList.contains('counter-progress-bar')) {
                        progressElement.style.background = 'linear-gradient(90deg, transparent 0%, var(--bs-primary, #0d6efd) 0%)';
                    }
                }
            });
        },
        addCounter: function(counterData) {
            // Add new counter dynamically (implementation depends on use case)
            console.log('Adding counter:', counterData);
        }
    };
});
</script>

{{-- 
Usage Examples:

Basic Counters:
@include('components.counters', [
    'counters' => [
        ['value' => 1250, 'label' => 'Happy Customers', 'icon' => 'fas fa-users'],
        ['value' => 850, 'label' => 'Cars Available', 'icon' => 'fas fa-car'],
        ['value' => 95, 'label' => 'Satisfaction Rate', 'suffix' => '%', 'icon' => 'fas fa-star'],
        ['value' => 24, 'label' => 'Hours Service', 'suffix' => '/7', 'icon' => 'fas fa-clock']
    ]
])

Card Layout Counters:
@include('components.counters', [
    'counters' => [
        ['value' => 50000, 'label' => 'Total Bookings', 'icon' => 'fas fa-calendar-check', 'color' => 'success'],
        ['value' => 2500, 'label' => 'Revenue', 'prefix' => '$', 'icon' => 'fas fa-dollar-sign', 'color' => 'warning'],
        ['value' => 98.5, 'label' => 'Rating', 'suffix' => '%', 'decimals' => 1, 'icon' => 'fas fa-star', 'color' => 'info']
    ],
    'theme' => 'card',
    'layout' => 'grid',
    'columns' => 3,
    'size' => 'lg',
    'showProgress' => true
])

Circular Counters:
@include('components.counters', [
    'counters' => [
        ['value' => 100, 'label' => 'Cities', 'icon' => 'fas fa-map-marker-alt'],
        ['value' => 50, 'label' => 'Countries', 'icon' => 'fas fa-globe'],
        ['value' => 1000, 'label' => 'Locations', 'icon' => 'fas fa-building']
    ],
    'theme' => 'circle',
    'size' => 'md',
    'animationDuration' => 3000,
    'easing' => 'easeOutBounce'
])

Minimal Counters with Custom Animation:
@include('components.counters', [
    'counters' => [
        ['value' => 5, 'label' => 'Years Experience', 'animation' => 'counter-pulse'],
        ['value' => 10000, 'label' => 'Miles Driven', 'suffix' => '+', 'animation' => 'counter-glow'],
        ['value' => 99.9, 'label' => 'Uptime', 'suffix' => '%', 'decimals' => 1]
    ],
    'theme' => 'minimal',
    'layout' => 'horizontal',
    'triggerOnScroll' => true,
    'triggerOffset' => 0.7
])
--}}
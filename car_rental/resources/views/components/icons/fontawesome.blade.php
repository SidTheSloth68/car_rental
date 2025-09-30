@props([
    'icon' => 'home',
    'style' => 'solid', // solid (fas), regular (far), light (fal), brands (fab), duotone (fad)
    'size' => 'md', // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, 8xl, 9xl, 10xl
    'color' => '',
    'class' => '',
    'customStyle' => '',
    'title' => '',
    'clickable' => false,
    'spin' => false,
    'pulse' => false,
    'bounce' => false,
    'beat' => false,
    'fade' => false,
    'flip' => '', // horizontal, vertical, both
    'rotation' => '', // 90, 180, 270
    'fixedWidth' => false,
    'border' => false,
    'pull' => '', // left, right
    'stack' => false,
    'inverse' => false
])

@php
$stylePrefix = [
    'solid' => 'fas',
    'regular' => 'far',
    'light' => 'fal',
    'brands' => 'fab',
    'duotone' => 'fad',
    'thin' => 'fat'
][$style] ?? 'fas';

$sizeClasses = [
    'xs' => 'fa-xs',
    'sm' => 'fa-sm',
    'md' => '', // Default size
    'lg' => 'fa-lg',
    'xl' => 'fa-xl',
    '2xl' => 'fa-2xl',
    '3xl' => 'fa-2xl', // FontAwesome doesn't have 3xl, using 2xl
    '4xl' => 'fa-2xl',
    '5xl' => 'fa-2xl',
    '6xl' => 'fa-2xl',
    '7xl' => 'fa-2xl',
    '8xl' => 'fa-2xl',
    '9xl' => 'fa-2xl',
    '10xl' => 'fa-2xl'
];

$classes = collect([
    $stylePrefix,
    'fa-' . $icon,
    $sizeClasses[$size] ?? '',
    $color ? 'text-' . $color : '',
    $fixedWidth ? 'fa-fw' : '',
    $border ? 'fa-border' : '',
    $pull ? 'fa-pull-' . $pull : '',
    $inverse ? 'fa-inverse' : '',
    $spin ? 'fa-spin' : '',
    $pulse ? 'fa-pulse' : '',
    $bounce ? 'fa-bounce' : '',
    $beat ? 'fa-beat' : '',
    $fade ? 'fa-fade' : '',
    $flip ? 'fa-flip-' . $flip : '',
    $rotation ? 'fa-rotate-' . $rotation : '',
    $clickable ? 'fa-clickable' : '',
    $stack ? 'fa-stack-1x' : '',
    $class
])->filter()->implode(' ');
@endphp

<style>
/* Font Awesome Custom Extensions */
.fa-clickable {
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
}

.fa-clickable:hover {
    transform: scale(1.1);
    opacity: 0.8;
}

/* Custom size classes for larger icons */
.fa-3xl { font-size: 3em; }
.fa-4xl { font-size: 4em; }
.fa-5xl { font-size: 5em; }
.fa-6xl { font-size: 6em; }
.fa-7xl { font-size: 7em; }
.fa-8xl { font-size: 8em; }
.fa-9xl { font-size: 9em; }
.fa-10xl { font-size: 10em; }

/* Enhanced animations */
.fa-beat {
    animation: fa-beat 1s ease-in-out infinite;
}

.fa-bounce {
    animation: fa-bounce 1s ease-in-out infinite;
}

.fa-fade {
    animation: fa-fade 2s ease-in-out infinite;
}

@keyframes fa-beat {
    0%, 90% { transform: scale(1); }
    45% { transform: scale(1.25); }
}

@keyframes fa-bounce {
    0%, 10%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40%, 60% {
        transform: translateY(-15px);
    }
}

@keyframes fa-fade {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

/* Icon background and decorative styles */
.fa-icon-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: var(--bs-primary, #0d6efd);
    color: white;
    transition: all 0.3s ease;
}

.fa-icon-circle-sm {
    width: 2.5rem;
    height: 2.5rem;
    font-size: 1rem;
}

.fa-icon-circle-md {
    width: 3.5rem;
    height: 3.5rem;
    font-size: 1.25rem;
}

.fa-icon-circle-lg {
    width: 4.5rem;
    height: 4.5rem;
    font-size: 1.5rem;
}

.fa-icon-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.fa-icon-square {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    background-color: var(--bs-primary, #0d6efd);
    color: white;
    transition: all 0.3s ease;
}

.fa-icon-square-sm {
    width: 2.5rem;
    height: 2.5rem;
    font-size: 1rem;
}

.fa-icon-square-md {
    width: 3.5rem;
    height: 3.5rem;
    font-size: 1.25rem;
}

.fa-icon-square-lg {
    width: 4.5rem;
    height: 4.5rem;
    font-size: 1.5rem;
}

.fa-icon-square:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Color variants for backgrounds */
.fa-icon-primary { background-color: var(--bs-primary, #0d6efd); }
.fa-icon-secondary { background-color: var(--bs-secondary, #6c757d); }
.fa-icon-success { background-color: var(--bs-success, #198754); }
.fa-icon-danger { background-color: var(--bs-danger, #dc3545); }
.fa-icon-warning { background-color: var(--bs-warning, #ffc107); color: var(--bs-dark, #212529); }
.fa-icon-info { background-color: var(--bs-info, #0dcaf0); color: var(--bs-dark, #212529); }
.fa-icon-light { background-color: var(--bs-light, #f8f9fa); color: var(--bs-dark, #212529); }
.fa-icon-dark { background-color: var(--bs-dark, #212529); }

/* Dark theme adjustments */
[data-bs-theme="dark"] .fa-clickable:hover {
    opacity: 0.7;
}

[data-bs-theme="dark"] .fa-icon-light {
    background-color: var(--bs-gray-800, #495057);
    color: var(--bs-light, #f8f9fa);
}

[data-bs-theme="dark"] .fa-icon-warning,
[data-bs-theme="dark"] .fa-icon-info {
    color: var(--bs-light, #f8f9fa);
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .fa-10xl { font-size: 6em; }
    .fa-9xl { font-size: 5em; }
    .fa-8xl { font-size: 4em; }
    .fa-7xl { font-size: 3em; }
    .fa-6xl { font-size: 2.5em; }
    .fa-5xl { font-size: 2em; }
}

/* Utility classes for spacing */
.fa-me-1 { margin-right: 0.25rem; }
.fa-me-2 { margin-right: 0.5rem; }
.fa-me-3 { margin-right: 1rem; }
.fa-ms-1 { margin-left: 0.25rem; }
.fa-ms-2 { margin-left: 0.5rem; }
.fa-ms-3 { margin-left: 1rem; }
</style>

<i class="{{ $classes }}" 
   @if($customStyle) style="{{ $customStyle }}" @endif
   @if($title) title="{{ $title }}" @endif
   {{ $attributes->except(['icon', 'style', 'size', 'color', 'class', 'customStyle', 'title', 'clickable', 'spin', 'pulse', 'bounce', 'beat', 'fade', 'flip', 'rotation', 'fixedWidth', 'border', 'pull', 'stack', 'inverse']) }}>
</i>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event handlers for clickable FontAwesome icons
    const clickableIcons = document.querySelectorAll('.fa-clickable');
    
    clickableIcons.forEach(icon => {
        icon.addEventListener('click', function(event) {
            // Dispatch custom event
            const customEvent = new CustomEvent('fontawesome-icon-click', {
                detail: {
                    icon: this.classList[1], // Second class should be the fa-icon class
                    style: this.classList[0], // First class should be the style (fas, far, etc.)
                    element: this,
                    originalEvent: event
                }
            });
            
            this.dispatchEvent(customEvent);
            
            // Add click animation
            this.style.transform = 'scale(0.9)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
        
        // Enhanced hover effects
        icon.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Add special effects for circular and square icon containers
    const iconContainers = document.querySelectorAll('.fa-icon-circle, .fa-icon-square');
    
    iconContainers.forEach(container => {
        container.addEventListener('click', function(event) {
            // Add ripple effect
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = event.clientX - rect.left - size / 2;
            const y = event.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});

// Add ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Global utility functions for FontAwesome Icons
window.FontAwesomeIcons = {
    // Animation controls
    startSpin: function(iconElement) {
        if (iconElement) iconElement.classList.add('fa-spin');
    },
    
    stopSpin: function(iconElement) {
        if (iconElement) iconElement.classList.remove('fa-spin');
    },
    
    startPulse: function(iconElement) {
        if (iconElement) iconElement.classList.add('fa-pulse');
    },
    
    stopPulse: function(iconElement) {
        if (iconElement) iconElement.classList.remove('fa-pulse');
    },
    
    startBeat: function(iconElement) {
        if (iconElement) iconElement.classList.add('fa-beat');
    },
    
    stopBeat: function(iconElement) {
        if (iconElement) iconElement.classList.remove('fa-beat');
    },
    
    // Icon manipulation
    changeIcon: function(iconElement, newIcon, newStyle = null) {
        if (iconElement && newIcon) {
            // Remove old icon class
            const classList = Array.from(iconElement.classList);
            const oldIconClass = classList.find(cls => cls.startsWith('fa-') && !cls.match(/^fa-(xs|sm|lg|xl|2xl|fw|border|pull-|inverse|spin|pulse|bounce|beat|fade|flip-|rotate-)/));
            if (oldIconClass) {
                iconElement.classList.remove(oldIconClass);
            }
            
            // Change style if provided
            if (newStyle) {
                const styleMap = { solid: 'fas', regular: 'far', light: 'fal', brands: 'fab', duotone: 'fad' };
                const oldStyleClass = classList.find(cls => Object.values(styleMap).includes(cls));
                if (oldStyleClass) {
                    iconElement.classList.remove(oldStyleClass);
                }
                iconElement.classList.add(styleMap[newStyle] || 'fas');
            }
            
            // Add new icon class
            iconElement.classList.add('fa-' + newIcon);
        }
    },
    
    // Toggle between two icons
    toggleIcon: function(iconElement, icon1, icon2, style1 = null, style2 = null) {
        if (iconElement && icon1 && icon2) {
            const hasIcon1 = iconElement.classList.contains('fa-' + icon1);
            if (hasIcon1) {
                this.changeIcon(iconElement, icon2, style2);
            } else {
                this.changeIcon(iconElement, icon1, style1);
            }
        }
    },
    
    // Create icon with background
    createIconWithBackground: function(icon, style = 'solid', backgroundType = 'circle', size = 'md', color = 'primary') {
        const container = document.createElement('div');
        container.className = `fa-icon-${backgroundType} fa-icon-${backgroundType}-${size} fa-icon-${color}`;
        
        const iconElement = document.createElement('i');
        const stylePrefix = { solid: 'fas', regular: 'far', light: 'fal', brands: 'fab', duotone: 'fad' }[style] || 'fas';
        iconElement.className = `${stylePrefix} fa-${icon}`;
        
        container.appendChild(iconElement);
        return container;
    }
};
</script>

{{-- 
Usage Examples:

Basic Icon:
@include('components.icons.fontawesome', ['icon' => 'home'])

Different Styles:
@include('components.icons.fontawesome', ['icon' => 'heart', 'style' => 'regular'])
@include('components.icons.fontawesome', ['icon' => 'star', 'style' => 'solid'])
@include('components.icons.fontawesome', ['icon' => 'facebook', 'style' => 'brands'])

Large Icon with Color:
@include('components.icons.fontawesome', [
    'icon' => 'car', 
    'size' => '3xl', 
    'color' => 'primary'
])

Animated Icons:
@include('components.icons.fontawesome', ['icon' => 'spinner', 'spin' => true])
@include('components.icons.fontawesome', ['icon' => 'heart', 'beat' => true, 'color' => 'danger'])
@include('components.icons.fontawesome', ['icon' => 'bell', 'bounce' => true])

Clickable Icon:
@include('components.icons.fontawesome', [
    'icon' => 'thumbs-up', 
    'clickable' => true, 
    'size' => 'lg'
])

Icon with Circular Background:
<div class="fa-icon-circle fa-icon-circle-md fa-icon-primary">
    @include('components.icons.fontawesome', ['icon' => 'user', 'size' => 'lg'])
</div>

Icon with Square Background:
<div class="fa-icon-square fa-icon-square-lg fa-icon-success">
    @include('components.icons.fontawesome', ['icon' => 'check', 'size' => 'xl'])
</div>

Fixed Width Icons for Lists:
@include('components.icons.fontawesome', ['icon' => 'home', 'fixedWidth' => true])
@include('components.icons.fontawesome', ['icon' => 'car', 'fixedWidth' => true])
@include('components.icons.fontawesome', ['icon' => 'user', 'fixedWidth' => true])

Popular Icons Available:
- home, user, users, mail, phone, car, heart, star
- check, times, plus, minus, edit, trash, save
- search, filter, download, upload, share
- calendar, clock, map-marker, location-dot
- facebook, twitter, instagram, linkedin (brands style)
- and thousands more...
--}}
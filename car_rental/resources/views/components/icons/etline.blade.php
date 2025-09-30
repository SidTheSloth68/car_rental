@props([
    'icon' => 'home',
    'size' => 'md', // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl
    'color' => '',
    'class' => '',
    'style' => '',
    'title' => '',
    'clickable' => false,
    'spin' => false,
    'pulse' => false,
    'bounce' => false
])

@php
$sizeClasses = [
    'xs' => 'etline-xs',
    'sm' => 'etline-sm', 
    'md' => 'etline-md',
    'lg' => 'etline-lg',
    'xl' => 'etline-xl',
    '2xl' => 'etline-2xl',
    '3xl' => 'etline-3xl',
    '4xl' => 'etline-4xl',
    '5xl' => 'etline-5xl'
];

$iconClass = 'icon-' . $icon;
$classes = collect([
    $iconClass,
    $sizeClasses[$size] ?? $sizeClasses['md'],
    $color ? 'text-' . $color : '',
    $clickable ? 'etline-clickable' : '',
    $spin ? 'etline-spin' : '',
    $pulse ? 'etline-pulse' : '',
    $bounce ? 'etline-bounce' : '',
    $class
])->filter()->implode(' ');
@endphp

<style>
/* ET-Line Icons Custom Styles */
.etline-xs { font-size: 0.75rem; line-height: 1; }
.etline-sm { font-size: 0.875rem; line-height: 1; }
.etline-md { font-size: 1rem; line-height: 1; }
.etline-lg { font-size: 1.25rem; line-height: 1; }
.etline-xl { font-size: 1.5rem; line-height: 1; }
.etline-2xl { font-size: 2rem; line-height: 1; }
.etline-3xl { font-size: 3rem; line-height: 1; }
.etline-4xl { font-size: 4rem; line-height: 1; }
.etline-5xl { font-size: 5rem; line-height: 1; }

.etline-clickable {
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
}

.etline-clickable:hover {
    transform: scale(1.1) rotate(5deg);
    color: var(--bs-primary, #0d6efd);
}

.etline-spin {
    animation: etline-spin 2s linear infinite;
}

.etline-pulse {
    animation: etline-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.etline-bounce {
    animation: etline-bounce 1s ease-in-out infinite;
}

@keyframes etline-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes etline-pulse {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.5; 
        transform: scale(1.05);
    }
}

@keyframes etline-bounce {
    0%, 20%, 53%, 80%, 100% {
        animation-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
        transform: translate3d(0, -30px, 0);
    }
    70% {
        animation-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
        transform: translate3d(0, -15px, 0);
    }
    90% {
        transform: translate3d(0,-4px,0);
    }
}

/* Dark theme support */
[data-bs-theme="dark"] .etline-clickable:hover {
    color: var(--bs-primary, #6ea8fe);
}

/* Icon container styles for better alignment */
.etline-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

/* Icon background circle styles */
.etline-circle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: var(--bs-light, #f8f9fa);
    border: 2px solid var(--bs-border-color, #dee2e6);
    transition: all 0.3s ease;
}

.etline-circle-sm {
    width: 2rem;
    height: 2rem;
}

.etline-circle-md {
    width: 3rem;
    height: 3rem;
}

.etline-circle-lg {
    width: 4rem;
    height: 4rem;
}

.etline-circle:hover {
    background-color: var(--bs-primary, #0d6efd);
    border-color: var(--bs-primary, #0d6efd);
    color: white;
    transform: scale(1.1);
}

[data-bs-theme="dark"] .etline-circle {
    background-color: var(--bs-dark, #212529);
    border-color: var(--bs-border-color, rgba(255, 255, 255, 0.125));
}

[data-bs-theme="dark"] .etline-circle:hover {
    background-color: var(--bs-primary, #6ea8fe);
    border-color: var(--bs-primary, #6ea8fe);
    color: var(--bs-dark, #212529);
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .etline-5xl { font-size: 3rem; }
    .etline-4xl { font-size: 2.5rem; }
    .etline-3xl { font-size: 2rem; }
}

/* Icon spacing utilities */
.etline-me-1 { margin-right: 0.25rem; }
.etline-me-2 { margin-right: 0.5rem; }
.etline-me-3 { margin-right: 1rem; }
.etline-ms-1 { margin-left: 0.25rem; }
.etline-ms-2 { margin-left: 0.5rem; }
.etline-ms-3 { margin-left: 1rem; }
</style>

<i class="{{ $classes }}" 
   @if($style) style="{{ $style }}" @endif
   @if($title) title="{{ $title }}" @endif
   {{ $attributes->except(['icon', 'size', 'color', 'class', 'style', 'title', 'clickable', 'spin', 'pulse', 'bounce']) }}>
</i>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event handlers for clickable ET-Line icons
    const clickableIcons = document.querySelectorAll('.etline-clickable');
    
    clickableIcons.forEach(icon => {
        icon.addEventListener('click', function(event) {
            // Dispatch custom event
            const customEvent = new CustomEvent('etline-icon-click', {
                detail: {
                    icon: this.classList[0], // First class should be the icon class
                    element: this,
                    originalEvent: event
                }
            });
            
            this.dispatchEvent(customEvent);
            
            // Add click animation with rotation
            this.style.transform = 'scale(0.9) rotate(-5deg)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);
        });
        
        // Enhanced hover effects
        icon.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Add special effects for circular icons
    const circularIcons = document.querySelectorAll('.etline-circle');
    
    circularIcons.forEach(circle => {
        circle.addEventListener('mouseenter', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1.2)';
            }
        });
        
        circle.addEventListener('mouseleave', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.style.transform = 'scale(1)';
            }
        });
    });
});

// Global utility functions for ET-Line Icons
window.ETLineIcons = {
    // Start spinning animation
    startSpin: function(iconElement) {
        if (iconElement) {
            iconElement.classList.add('etline-spin');
        }
    },
    
    // Stop spinning animation
    stopSpin: function(iconElement) {
        if (iconElement) {
            iconElement.classList.remove('etline-spin');
        }
    },
    
    // Start pulse animation
    startPulse: function(iconElement) {
        if (iconElement) {
            iconElement.classList.add('etline-pulse');
        }
    },
    
    // Stop pulse animation
    stopPulse: function(iconElement) {
        if (iconElement) {
            iconElement.classList.remove('etline-pulse');
        }
    },
    
    // Start bounce animation
    startBounce: function(iconElement) {
        if (iconElement) {
            iconElement.classList.add('etline-bounce');
        }
    },
    
    // Stop bounce animation
    stopBounce: function(iconElement) {
        if (iconElement) {
            iconElement.classList.remove('etline-bounce');
        }
    },
    
    // Change icon
    changeIcon: function(iconElement, newIcon) {
        if (iconElement && newIcon) {
            // Remove old icon class (assuming first class is the icon)
            const classList = Array.from(iconElement.classList);
            const oldIconClass = classList.find(cls => cls.startsWith('icon-'));
            if (oldIconClass) {
                iconElement.classList.remove(oldIconClass);
            }
            
            // Add new icon class
            iconElement.classList.add('icon-' + newIcon);
        }
    },
    
    // Create circular icon wrapper
    createCircularIcon: function(iconElement, size = 'md') {
        if (iconElement) {
            const wrapper = document.createElement('div');
            wrapper.className = `etline-container etline-circle etline-circle-${size}`;
            
            iconElement.parentNode.insertBefore(wrapper, iconElement);
            wrapper.appendChild(iconElement);
            
            return wrapper;
        }
    }
};
</script>

{{-- 
Usage Examples:

Basic Icon:
@include('components.icons.etline', ['icon' => 'home'])

Large Icon with Color:
@include('components.icons.etline', [
    'icon' => 'heart', 
    'size' => 'lg', 
    'color' => 'danger'
])

Clickable Icon with Bounce Animation:
@include('components.icons.etline', [
    'icon' => 'mail', 
    'clickable' => true, 
    'bounce' => true
])

Icon with Circular Background:
<div class="etline-container etline-circle etline-circle-md">
    @include('components.icons.etline', ['icon' => 'user', 'size' => 'lg'])
</div>

Available Icons (subset - ET-Line has 100+ icons):
- home, user, users, mail, phone
- heart, star, thumbs-up, thumbs-down
- calendar, clock, timer, alarm
- camera, video, image, pictures
- music, headphones, volume-up, volume-down
- search, zoom-in, zoom-out, target
- edit, compose, pencil, pen
- trash, delete, close, check
- plus, minus, arrow-up, arrow-down
- arrow-left, arrow-right, refresh, loading
- cart, bag, credit-card, wallet
- lock, unlock, key, shield
- cloud, download, upload, link
- map, location, compass, flag
- and many more...
--}}
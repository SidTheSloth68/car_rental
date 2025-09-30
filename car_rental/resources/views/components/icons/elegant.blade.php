@props([
    'icon' => 'arrow_up',
    'size' => 'md', // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl
    'color' => '',
    'class' => '',
    'style' => '',
    'title' => '',
    'clickable' => false,
    'spin' => false,
    'pulse' => false
])

@php
$sizeClasses = [
    'xs' => 'elegant-xs',
    'sm' => 'elegant-sm', 
    'md' => 'elegant-md',
    'lg' => 'elegant-lg',
    'xl' => 'elegant-xl',
    '2xl' => 'elegant-2xl',
    '3xl' => 'elegant-3xl',
    '4xl' => 'elegant-4xl',
    '5xl' => 'elegant-5xl'
];

$iconClass = 'icon_' . $icon;
$classes = collect([
    $iconClass,
    $sizeClasses[$size] ?? $sizeClasses['md'],
    $color ? 'text-' . $color : '',
    $clickable ? 'elegant-clickable' : '',
    $spin ? 'elegant-spin' : '',
    $pulse ? 'elegant-pulse' : '',
    $class
])->filter()->implode(' ');
@endphp

<style>
/* Elegant Icons Custom Styles */
.elegant-xs { font-size: 0.75rem; }
.elegant-sm { font-size: 0.875rem; }
.elegant-md { font-size: 1rem; }
.elegant-lg { font-size: 1.25rem; }
.elegant-xl { font-size: 1.5rem; }
.elegant-2xl { font-size: 2rem; }
.elegant-3xl { font-size: 3rem; }
.elegant-4xl { font-size: 4rem; }
.elegant-5xl { font-size: 5rem; }

.elegant-clickable {
    cursor: pointer;
    transition: all 0.3s ease;
}

.elegant-clickable:hover {
    transform: scale(1.1);
    opacity: 0.8;
}

.elegant-spin {
    animation: elegant-spin 2s linear infinite;
}

.elegant-pulse {
    animation: elegant-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes elegant-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes elegant-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Dark theme support */
[data-bs-theme="dark"] .elegant-clickable:hover {
    opacity: 0.7;
}

/* Responsive icon adjustments */
@media (max-width: 576px) {
    .elegant-5xl { font-size: 3rem; }
    .elegant-4xl { font-size: 2.5rem; }
    .elegant-3xl { font-size: 2rem; }
}

/* Icon alignment utilities */
.elegant-align-center {
    vertical-align: middle;
}

.elegant-align-top {
    vertical-align: top;
}

.elegant-align-bottom {
    vertical-align: bottom;
}

/* Icon spacing utilities */
.elegant-me-1 { margin-right: 0.25rem; }
.elegant-me-2 { margin-right: 0.5rem; }
.elegant-me-3 { margin-right: 1rem; }
.elegant-ms-1 { margin-left: 0.25rem; }
.elegant-ms-2 { margin-left: 0.5rem; }
.elegant-ms-3 { margin-left: 1rem; }
</style>

<i class="{{ $classes }}" 
   @if($style) style="{{ $style }}" @endif
   @if($title) title="{{ $title }}" @endif
   {{ $attributes->except(['icon', 'size', 'color', 'class', 'style', 'title', 'clickable', 'spin', 'pulse']) }}>
</i>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event handlers for clickable icons
    const clickableIcons = document.querySelectorAll('.elegant-clickable');
    
    clickableIcons.forEach(icon => {
        icon.addEventListener('click', function(event) {
            // Dispatch custom event
            const customEvent = new CustomEvent('elegant-icon-click', {
                detail: {
                    icon: this.classList[0], // First class should be the icon class
                    element: this,
                    originalEvent: event
                }
            });
            
            this.dispatchEvent(customEvent);
            
            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
        
        // Add hover effects
        icon.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
});

// Global utility functions for Elegant Icons
window.ElegantIcons = {
    // Start spinning animation
    startSpin: function(iconElement) {
        if (iconElement) {
            iconElement.classList.add('elegant-spin');
        }
    },
    
    // Stop spinning animation
    stopSpin: function(iconElement) {
        if (iconElement) {
            iconElement.classList.remove('elegant-spin');
        }
    },
    
    // Start pulse animation
    startPulse: function(iconElement) {
        if (iconElement) {
            iconElement.classList.add('elegant-pulse');
        }
    },
    
    // Stop pulse animation
    stopPulse: function(iconElement) {
        if (iconElement) {
            iconElement.classList.remove('elegant-pulse');
        }
    },
    
    // Change icon
    changeIcon: function(iconElement, newIcon) {
        if (iconElement && newIcon) {
            // Remove old icon class (assuming first class is the icon)
            const classList = Array.from(iconElement.classList);
            const oldIconClass = classList.find(cls => cls.startsWith('icon_'));
            if (oldIconClass) {
                iconElement.classList.remove(oldIconClass);
            }
            
            // Add new icon class
            iconElement.classList.add('icon_' + newIcon);
        }
    },
    
    // Toggle icon between two states
    toggleIcon: function(iconElement, icon1, icon2) {
        if (iconElement && icon1 && icon2) {
            const hasIcon1 = iconElement.classList.contains('icon_' + icon1);
            if (hasIcon1) {
                this.changeIcon(iconElement, icon2);
            } else {
                this.changeIcon(iconElement, icon1);
            }
        }
    }
};
</script>

{{-- 
Usage Examples:

Basic Icon:
@include('components.icons.elegant', ['icon' => 'heart'])

Large Icon with Color:
@include('components.icons.elegant', [
    'icon' => 'star', 
    'size' => 'lg', 
    'color' => 'primary'
])

Clickable Icon with Animation:
@include('components.icons.elegant', [
    'icon' => 'loading', 
    'clickable' => true, 
    'spin' => true
])

Custom Styled Icon:
@include('components.icons.elegant', [
    'icon' => 'check', 
    'class' => 'me-2', 
    'style' => 'color: #28a745;'
])

Available Icons (subset - Elegant Icons has 300+ icons):
- arrow_up, arrow_down, arrow_left, arrow_right
- heart, heart_alt, star, star_alt
- check, close, plus, minus
- loading, refresh, settings, cog
- home, user, mail, phone
- calendar, clock, timer
- search, zoom_in, zoom_out
- edit, delete, trash, save
- upload, download, cloud
- lock, unlock, key, shield
- camera, video, image, gallery
- play, pause, stop, next, previous
- volume_up, volume_down, mute
- like, dislike, thumbs_up, thumbs_down
- and many more...
--}}
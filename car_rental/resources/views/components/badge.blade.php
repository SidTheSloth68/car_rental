{{-- Badge Component
    Usage: @include('components.badge', ['text' => 'New', 'type' => 'primary', 'size' => 'sm'])
    Types: primary, secondary, success, danger, warning, info, light, dark
    Sizes: sm, md, lg
--}}

@php
    $type = $type ?? 'primary';
    $size = $size ?? 'md';
    $text = $text ?? 'Badge';
    
    $sizeClasses = [
        'sm' => 'badge-sm',
        'md' => 'badge-md', 
        'lg' => 'badge-lg'
    ];
    
    $typeClasses = [
        'primary' => 'badge-primary',
        'secondary' => 'badge-secondary',
        'success' => 'badge-success',
        'danger' => 'badge-danger',
        'warning' => 'badge-warning',
        'info' => 'badge-info',
        'light' => 'badge-light',
        'dark' => 'badge-dark'
    ];
@endphp

<span class="badge {{ $typeClasses[$type] ?? 'badge-primary' }} {{ $sizeClasses[$size] ?? 'badge-md' }} {{ $class ?? '' }}"
      @if(isset($id)) id="{{ $id }}" @endif
      @if(isset($onclick)) onclick="{{ $onclick }}" @endif
      @if(isset($title)) title="{{ $title }}" @endif>
    @if(isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $text }}
    @if(isset($dismissible) && $dismissible)
        <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close"></button>
    @endif
</span>

<style>
/* Badge Styles */
.badge {
    display: inline-block;
    padding: 0.375em 0.75em;
    font-size: 0.75em;
    font-weight: 600;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.375rem;
    text-decoration: none;
    border: 1px solid transparent;
}

/* Badge Sizes */
.badge-sm {
    padding: 0.25em 0.5em;
    font-size: 0.65em;
}

.badge-md {
    padding: 0.375em 0.75em;
    font-size: 0.75em;
}

.badge-lg {
    padding: 0.5em 1em;
    font-size: 0.875em;
}

/* Badge Types */
.badge-primary {
    color: #ffffff;
    background-color: var(--primary-color);
}

.badge-secondary {
    color: #ffffff;
    background-color: #6c757d;
}

.badge-success {
    color: #ffffff;
    background-color: #198754;
}

.badge-danger {
    color: #ffffff;
    background-color: #dc3545;
}

.badge-warning {
    color: #000000;
    background-color: #ffc107;
}

.badge-info {
    color: #000000;
    background-color: #0dcaf0;
}

.badge-light {
    color: #000000;
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.badge-dark {
    color: #ffffff;
    background-color: #212529;
}

/* Dark theme support */
.dark-scheme .badge-light {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.2);
}

/* Hover effects */
.badge:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

/* Dismissible badges */
.badge .btn-close {
    padding: 0;
    margin: 0 0 0 0.5em;
    font-size: 0.6em;
}
</style>
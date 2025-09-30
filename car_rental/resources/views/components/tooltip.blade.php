{{-- Tooltip Component
    Usage: @include('components.tooltip', [
        'text' => 'Tooltip text',
        'position' => 'top',
        'trigger' => 'hover'
    ])
    
    Positions: top, bottom, left, right
    Triggers: hover, click, focus
--}}

@php
    $text = $text ?? 'Tooltip';
    $position = $position ?? 'top';
    $trigger = $trigger ?? 'hover';
    $delay = $delay ?? 0;
    $animation = $animation ?? true;
    $html = $html ?? false;
    $target = $target ?? '#tooltip-target-' . uniqid();
@endphp

<!-- Tooltip Target Element -->
<span class="tooltip-wrapper d-inline-block" 
      data-bs-toggle="tooltip" 
      data-bs-placement="{{ $position }}"
      data-bs-title="{{ $text }}"
      data-bs-trigger="{{ $trigger }}"
      data-bs-delay="{{ $delay }}"
      data-bs-animation="{{ $animation ? 'true' : 'false' }}"
      data-bs-html="{{ $html ? 'true' : 'false' }}"
      @if(isset($customClass)) data-bs-custom-class="{{ $customClass }}" @endif>
    {{ $slot ?? 'Hover me' }}
</span>

<style>
/* Tooltip Customizations */
.tooltip {
    font-size: 0.875rem;
    opacity: 0;
    transition: opacity 0.15s ease-in-out;
}

.tooltip.show {
    opacity: 1;
}

.tooltip .tooltip-inner {
    max-width: 200px;
    padding: 0.5rem 0.75rem;
    color: #ffffff;
    text-align: center;
    background-color: #000000;
    border-radius: 0.375rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.tooltip .tooltip-arrow {
    position: absolute;
    display: block;
    width: 0.8rem;
    height: 0.4rem;
}

.tooltip .tooltip-arrow::before {
    position: absolute;
    content: "";
    border-color: transparent;
    border-style: solid;
}

/* Tooltip positions */
.tooltip.bs-tooltip-top .tooltip-arrow::before {
    top: 0;
    border-width: 0.4rem 0.4rem 0;
    border-top-color: #000000;
}

.tooltip.bs-tooltip-bottom .tooltip-arrow::before {
    bottom: 0;
    border-width: 0 0.4rem 0.4rem;
    border-bottom-color: #000000;
}

.tooltip.bs-tooltip-start .tooltip-arrow::before {
    left: 0;
    border-width: 0.4rem 0 0.4rem 0.4rem;
    border-left-color: #000000;
}

.tooltip.bs-tooltip-end .tooltip-arrow::before {
    right: 0;
    border-width: 0.4rem 0.4rem 0.4rem 0;
    border-right-color: #000000;
}

/* Tooltip variants */
.tooltip.tooltip-primary .tooltip-inner {
    background-color: var(--primary-color);
}

.tooltip.tooltip-success .tooltip-inner {
    background-color: #198754;
}

.tooltip.tooltip-danger .tooltip-inner {
    background-color: #dc3545;
}

.tooltip.tooltip-warning .tooltip-inner {
    background-color: #ffc107;
    color: #000000;
}

.tooltip.tooltip-info .tooltip-inner {
    background-color: #0dcaf0;
    color: #000000;
}

/* Dark theme support */
.dark-scheme .tooltip .tooltip-inner {
    background-color: rgba(255, 255, 255, 0.9);
    color: #000000;
}

.dark-scheme .tooltip.bs-tooltip-top .tooltip-arrow::before {
    border-top-color: rgba(255, 255, 255, 0.9);
}

.dark-scheme .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
    border-bottom-color: rgba(255, 255, 255, 0.9);
}

.dark-scheme .tooltip.bs-tooltip-start .tooltip-arrow::before {
    border-left-color: rgba(255, 255, 255, 0.9);
}

.dark-scheme .tooltip.bs-tooltip-end .tooltip-arrow::before {
    border-right-color: rgba(255, 255, 255, 0.9);
}

/* Tooltip wrapper */
.tooltip-wrapper {
    cursor: help;
}

.tooltip-wrapper:hover {
    position: relative;
}

/* Animation effects */
.tooltip.fade {
    transition: opacity 0.15s ease-in-out;
}

.tooltip.show {
    opacity: 1;
    transform: scale(1);
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl, {
            container: 'body',
            boundary: 'window',
            fallbackPlacements: ['top', 'bottom', 'left', 'right']
        });
    });

    // Custom tooltip behaviors
    @if(isset($autoShow) && $autoShow)
        // Auto-show tooltip after delay
        setTimeout(function() {
            var targetElement = document.querySelector('{{ $target }}');
            if (targetElement) {
                var tooltip = bootstrap.Tooltip.getInstance(targetElement);
                if (tooltip) {
                    tooltip.show();
                }
            }
        }, {{ $autoShowDelay ?? 1000 }});
    @endif
    
    // Custom events
    document.addEventListener('show.bs.tooltip', function (event) {
        @if(isset($onShow))
            {{ $onShow }}
        @endif
    });
    
    document.addEventListener('hidden.bs.tooltip', function (event) {
        @if(isset($onHide))
            {{ $onHide }}
        @endif
    });
});
</script>
@endpush
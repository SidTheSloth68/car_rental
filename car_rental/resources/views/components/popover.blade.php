{{-- Popover Component
    Usage: @include('components.popover', [
        'title' => 'Popover Title',
        'content' => 'Popover content',
        'position' => 'top',
        'trigger' => 'click'
    ])
    
    Positions: top, bottom, left, right
    Triggers: click, hover, focus, manual
--}}

@php
    $title = $title ?? 'Popover Title';
    $content = $content ?? 'Popover content goes here...';
    $position = $position ?? 'top';
    $trigger = $trigger ?? 'click';
    $delay = $delay ?? 0;
    $animation = $animation ?? true;
    $html = $html ?? false;
    $dismissible = $dismissible ?? true;
    $target = $target ?? '#popover-target-' . uniqid();
@endphp

<!-- Popover Target Element -->
<span class="popover-wrapper d-inline-block" 
      data-bs-toggle="popover" 
      data-bs-placement="{{ $position }}"
      data-bs-title="{{ $title }}"
      data-bs-content="{{ $content }}"
      data-bs-trigger="{{ $trigger }}"
      data-bs-delay="{{ $delay }}"
      data-bs-animation="{{ $animation ? 'true' : 'false' }}"
      data-bs-html="{{ $html ? 'true' : 'false' }}"
      @if($dismissible) data-bs-dismiss="true" @endif
      @if(isset($customClass)) data-bs-custom-class="{{ $customClass }}" @endif
      @if(isset($container)) data-bs-container="{{ $container }}" @endif>
    {{ $slot ?? 'Click me' }}
</span>

<style>
/* Popover Customizations */
.popover {
    font-size: 0.875rem;
    max-width: 276px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.5rem;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    background-color: #ffffff;
    opacity: 0;
    transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
}

.popover.show {
    opacity: 1;
    transform: scale(1);
}

.popover .popover-header {
    padding: 0.75rem 1rem;
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #161C2D;
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    border-top-left-radius: calc(0.5rem - 1px);
    border-top-right-radius: calc(0.5rem - 1px);
}

.popover .popover-body {
    padding: 0.75rem 1rem;
    color: #6c757d;
    line-height: 1.5;
}

.popover .popover-arrow {
    position: absolute;
    display: block;
    width: 1rem;
    height: 0.5rem;
    margin: 0 0.5rem;
}

.popover .popover-arrow::before,
.popover .popover-arrow::after {
    position: absolute;
    display: block;
    content: "";
    border-color: transparent;
    border-style: solid;
}

/* Popover positions */
.popover.bs-popover-top > .popover-arrow::before {
    bottom: 0;
    border-width: 0.5rem 0.5rem 0;
    border-top-color: rgba(0, 0, 0, 0.2);
}

.popover.bs-popover-top > .popover-arrow::after {
    bottom: 1px;
    border-width: 0.5rem 0.5rem 0;
    border-top-color: #ffffff;
}

.popover.bs-popover-bottom > .popover-arrow::before {
    top: 0;
    border-width: 0 0.5rem 0.5rem;
    border-bottom-color: rgba(0, 0, 0, 0.2);
}

.popover.bs-popover-bottom > .popover-arrow::after {
    top: 1px;
    border-width: 0 0.5rem 0.5rem;
    border-bottom-color: #ffffff;
}

.popover.bs-popover-start > .popover-arrow::before {
    right: 0;
    border-width: 0.5rem 0 0.5rem 0.5rem;
    border-left-color: rgba(0, 0, 0, 0.2);
}

.popover.bs-popover-start > .popover-arrow::after {
    right: 1px;
    border-width: 0.5rem 0 0.5rem 0.5rem;
    border-left-color: #ffffff;
}

.popover.bs-popover-end > .popover-arrow::before {
    left: 0;
    border-width: 0.5rem 0.5rem 0.5rem 0;
    border-right-color: rgba(0, 0, 0, 0.2);
}

.popover.bs-popover-end > .popover-arrow::after {
    left: 1px;
    border-width: 0.5rem 0.5rem 0.5rem 0;
    border-right-color: #ffffff;
}

/* Popover variants */
.popover.popover-primary {
    border-color: var(--primary-color);
}

.popover.popover-primary .popover-header {
    background-color: var(--primary-color);
    color: #ffffff;
    border-bottom-color: var(--primary-color);
}

.popover.popover-success {
    border-color: #198754;
}

.popover.popover-success .popover-header {
    background-color: #198754;
    color: #ffffff;
    border-bottom-color: #198754;
}

.popover.popover-danger {
    border-color: #dc3545;
}

.popover.popover-danger .popover-header {
    background-color: #dc3545;
    color: #ffffff;
    border-bottom-color: #dc3545;
}

.popover.popover-warning {
    border-color: #ffc107;
}

.popover.popover-warning .popover-header {
    background-color: #ffc107;
    color: #000000;
    border-bottom-color: #ffc107;
}

/* Dark theme support */
.dark-scheme .popover {
    background-color: var(--bg-color-dark);
    border-color: rgba(255, 255, 255, 0.2);
}

.dark-scheme .popover .popover-header {
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border-bottom-color: rgba(255, 255, 255, 0.1);
}

.dark-scheme .popover .popover-body {
    color: rgba(255, 255, 255, 0.75);
}

.dark-scheme .popover.bs-popover-top > .popover-arrow::after,
.dark-scheme .popover.bs-popover-bottom > .popover-arrow::after,
.dark-scheme .popover.bs-popover-start > .popover-arrow::after,
.dark-scheme .popover.bs-popover-end > .popover-arrow::after {
    border-color: var(--bg-color-dark);
}

/* Popover wrapper */
.popover-wrapper {
    cursor: pointer;
}

.popover-wrapper:hover {
    position: relative;
}

/* Animation effects */
.popover.fade {
    transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
    transform: scale(0.9);
}

.popover.show {
    opacity: 1;
    transform: scale(1);
}

/* Dismissible popover close button */
.popover .btn-close {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    padding: 0.25rem;
    font-size: 0.75rem;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl, {
            container: 'body',
            boundary: 'window',
            fallbackPlacements: ['top', 'bottom', 'left', 'right'],
            sanitize: false // Allow HTML content
        });
    });

    // Dismissible popovers
    @if($dismissible)
        document.addEventListener('click', function (e) {
            var popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
            popovers.forEach(function(popover) {
                if (!popover.contains(e.target)) {
                    var popoverInstance = bootstrap.Popover.getInstance(popover);
                    if (popoverInstance) {
                        popoverInstance.hide();
                    }
                }
            });
        });
    @endif

    // Auto-show popover
    @if(isset($autoShow) && $autoShow)
        setTimeout(function() {
            var targetElement = document.querySelector('{{ $target }}');
            if (targetElement) {
                var popover = bootstrap.Popover.getInstance(targetElement);
                if (popover) {
                    popover.show();
                }
            }
        }, {{ $autoShowDelay ?? 1000 }});
    @endif
    
    // Custom events
    document.addEventListener('show.bs.popover', function (event) {
        @if(isset($onShow))
            {{ $onShow }}
        @endif
    });
    
    document.addEventListener('hidden.bs.popover', function (event) {
        @if(isset($onHide))
            {{ $onHide }}
        @endif
    });
});
</script>
@endpush
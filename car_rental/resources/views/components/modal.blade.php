@props([
    'id' => 'modal-' . uniqid(),
    'title' => '',
    'size' => 'md', // sm, md, lg, xl
    'centered' => false,
    'scrollable' => false,
    'backdrop' => 'true', // true, false, static
    'keyboard' => true,
    'focus' => true,
    'show' => false,
    'fade' => true,
    'headerClass' => '',
    'bodyClass' => '',
    'footerClass' => '',
    'showHeader' => true,
    'showFooter' => false,
    'closeButton' => true
])

@php
$modalClass = 'modal';
if ($fade) $modalClass .= ' fade';

$dialogClass = 'modal-dialog';
if ($centered) $dialogClass .= ' modal-dialog-centered';
if ($scrollable) $dialogClass .= ' modal-dialog-scrollable';

switch($size) {
    case 'sm':
        $dialogClass .= ' modal-sm';
        break;
    case 'lg':
        $dialogClass .= ' modal-lg';
        break;
    case 'xl':
        $dialogClass .= ' modal-xl';
        break;
    case 'fullscreen':
        $dialogClass .= ' modal-fullscreen';
        break;
    default:
        // md is default, no additional class needed
        break;
}
@endphp

<style>
.modal-custom {
    --bs-modal-zindex: 1055;
    --bs-modal-bg: var(--bs-body-bg);
    --bs-modal-border-color: var(--bs-border-color-translucent);
    --bs-modal-border-width: 1px;
    --bs-modal-border-radius: 0.5rem;
    --bs-modal-box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    --bs-modal-inner-border-radius: calc(0.5rem - 1px);
    --bs-modal-header-padding-x: 1rem;
    --bs-modal-header-padding-y: 1rem;
    --bs-modal-header-border-color: var(--bs-border-color);
    --bs-modal-header-border-width: 1px;
    --bs-modal-title-line-height: 1.5;
    --bs-modal-footer-gap: 0.5rem;
    --bs-modal-footer-bg: transparent;
    --bs-modal-footer-border-color: var(--bs-border-color);
    --bs-modal-footer-border-width: 1px;
}

/* Dark theme support */
[data-bs-theme="dark"] .modal-custom {
    --bs-modal-bg: var(--bs-dark);
    --bs-modal-border-color: rgba(255, 255, 255, 0.125);
    --bs-modal-box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
    --bs-modal-header-border-color: rgba(255, 255, 255, 0.125);
    --bs-modal-footer-border-color: rgba(255, 255, 255, 0.125);
}

.modal-custom .modal-content {
    background-color: var(--bs-modal-bg);
    border: var(--bs-modal-border-width) solid var(--bs-modal-border-color);
    border-radius: var(--bs-modal-border-radius);
    box-shadow: var(--bs-modal-box-shadow);
}

.modal-custom .modal-header {
    padding: var(--bs-modal-header-padding-y) var(--bs-modal-header-padding-x);
    border-bottom: var(--bs-modal-header-border-width) solid var(--bs-modal-header-border-color);
}

.modal-custom .modal-footer {
    padding: var(--bs-modal-header-padding-y) var(--bs-modal-header-padding-x);
    border-top: var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);
    background-color: var(--bs-modal-footer-bg);
}

.modal-custom .modal-title {
    margin-bottom: 0;
    line-height: var(--bs-modal-title-line-height);
}

/* Custom animations */
.modal-custom.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal-custom.show .modal-dialog {
    transform: none;
}

/* Responsive fullscreen modals */
@media (max-width: 575.98px) {
    .modal-custom .modal-dialog {
        margin: 0;
        width: auto;
        height: 100%;
        max-height: none;
    }
    
    .modal-custom .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }
}

/* Custom backdrop */
.modal-custom .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}

[data-bs-theme="dark"] .modal-custom .modal-backdrop {
    background-color: rgba(255, 255, 255, 0.1);
}
</style>

<!-- Modal -->
<div class="modal modal-custom {{ $modalClass }}" 
     id="{{ $id }}" 
     tabindex="-1" 
     aria-labelledby="{{ $id }}Label" 
     aria-hidden="true"
     data-bs-backdrop="{{ $backdrop }}"
     data-bs-keyboard="{{ $keyboard ? 'true' : 'false' }}"
     @if($show) style="display: block;" @endif>
    
    <div class="{{ $dialogClass }}">
        <div class="modal-content">
            
            @if($showHeader)
                <div class="modal-header {{ $headerClass }}">
                    @if($title)
                        <h5 class="modal-title" id="{{ $id }}Label">
                            {!! $title !!}
                        </h5>
                    @endif
                    
                    @isset($header)
                        {{ $header }}
                    @endisset
                    
                    @if($closeButton)
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
            @endif
            
            <div class="modal-body {{ $bodyClass }}">
                @isset($body)
                    {{ $body }}
                @else
                    {{ $slot }}
                @endisset
            </div>
            
            @if($showFooter)
                <div class="modal-footer {{ $footerClass }}">
                    @isset($footer)
                        {{ $footer }}
                    @else
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    @endisset
                </div>
            @endif
            
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('{{ $id }}');
    
    if (modalElement) {
        // Initialize Bootstrap modal
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: '{{ $backdrop }}',
            keyboard: {{ $keyboard ? 'true' : 'false' }},
            focus: {{ $focus ? 'true' : 'false' }}
        });
        
        // Store modal instance for external access
        modalElement._bootstrapModal = modal;
        
        // Auto-show if specified
        @if($show)
            modal.show();
        @endif
        
        // Custom events
        modalElement.addEventListener('show.bs.modal', function (event) {
            // Custom show logic
            modalElement.dispatchEvent(new CustomEvent('modal:show', {
                detail: { modalId: '{{ $id }}', trigger: event.relatedTarget }
            }));
        });
        
        modalElement.addEventListener('shown.bs.modal', function (event) {
            // Focus management
            @if($focus)
                const firstFocusable = modalElement.querySelector('button, input, textarea, select, a[href], [tabindex]:not([tabindex="-1"])');
                if (firstFocusable) {
                    firstFocusable.focus();
                }
            @endif
            
            modalElement.dispatchEvent(new CustomEvent('modal:shown', {
                detail: { modalId: '{{ $id }}' }
            }));
        });
        
        modalElement.addEventListener('hide.bs.modal', function (event) {
            modalElement.dispatchEvent(new CustomEvent('modal:hide', {
                detail: { modalId: '{{ $id }}' }
            }));
        });
        
        modalElement.addEventListener('hidden.bs.modal', function (event) {
            modalElement.dispatchEvent(new CustomEvent('modal:hidden', {
                detail: { modalId: '{{ $id }}' }
            }));
        });
        
        // Keyboard shortcuts
        modalElement.addEventListener('keydown', function(event) {
            // ESC key
            if (event.key === 'Escape' && {{ $keyboard ? 'true' : 'false' }}) {
                modal.hide();
            }
            
            // Tab navigation
            if (event.key === 'Tab') {
                const focusableElements = modalElement.querySelectorAll(
                    'button, input, textarea, select, a[href], [tabindex]:not([tabindex="-1"])'
                );
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];
                
                if (event.shiftKey && document.activeElement === firstElement) {
                    event.preventDefault();
                    lastElement.focus();
                } else if (!event.shiftKey && document.activeElement === lastElement) {
                    event.preventDefault();
                    firstElement.focus();
                }
            }
        });
    }
});

// Global modal control functions
window.openModal = function(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement && modalElement._bootstrapModal) {
        modalElement._bootstrapModal.show();
    }
};

window.closeModal = function(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement && modalElement._bootstrapModal) {
        modalElement._bootstrapModal.hide();
    }
};

window.toggleModal = function(modalId) {
    const modalElement = document.getElementById(modalId);
    if (modalElement && modalElement._bootstrapModal) {
        modalElement._bootstrapModal.toggle();
    }
};
</script>

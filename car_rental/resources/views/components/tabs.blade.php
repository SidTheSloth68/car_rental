{{-- Tabs Component
    Usage: @include('components.tabs', [
        'tabs' => [
            ['id' => 'tab1', 'title' => 'Tab 1', 'content' => 'Content 1', 'active' => true],
            ['id' => 'tab2', 'title' => 'Tab 2', 'content' => 'Content 2'],
            ['id' => 'tab3', 'title' => 'Tab 3', 'content' => 'Content 3']
        ],
        'type' => 'pills', // tabs or pills
        'justified' => false,
        'vertical' => false
    ])
--}}

@php
    $tabs = $tabs ?? [];
    $type = $type ?? 'tabs'; // tabs or pills
    $justified = $justified ?? false;
    $vertical = $vertical ?? false;
    $fade = $fade ?? true;
    $id = $id ?? 'tabs-' . uniqid();
    
    // Ensure at least one tab is active
    $hasActive = collect($tabs)->contains('active', true);
    if (!$hasActive && count($tabs) > 0) {
        $tabs[0]['active'] = true;
    }
@endphp

<div class="tabs-wrapper {{ $vertical ? 'd-flex align-items-start' : '' }}">
    <!-- Nav tabs -->
    <ul class="nav {{ $type === 'pills' ? 'nav-pills' : 'nav-tabs' }} {{ $justified ? 'nav-justified' : '' }} {{ $vertical ? 'flex-column me-3' : '' }}" 
        id="{{ $id }}-nav" 
        role="tablist"
        @if($vertical) style="min-width: 200px;" @endif>
        @foreach($tabs as $index => $tab)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ isset($tab['active']) && $tab['active'] ? 'active' : '' }} {{ $tab['disabled'] ?? false ? 'disabled' : '' }}"
                        id="{{ $tab['id'] ?? 'tab-' . $index }}-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#{{ $tab['id'] ?? 'tab-' . $index }}-pane"
                        type="button"
                        role="tab"
                        aria-controls="{{ $tab['id'] ?? 'tab-' . $index }}-pane"
                        aria-selected="{{ isset($tab['active']) && $tab['active'] ? 'true' : 'false' }}"
                        @if($tab['disabled'] ?? false) disabled @endif>
                    @if(isset($tab['icon']))
                        <i class="{{ $tab['icon'] }} me-2"></i>
                    @endif
                    {{ $tab['title'] ?? 'Tab ' . ($index + 1) }}
                    @if(isset($tab['badge']))
                        <span class="badge bg-secondary ms-2">{{ $tab['badge'] }}</span>
                    @endif
                </button>
            </li>
        @endforeach
    </ul>

    <!-- Tab content -->
    <div class="tab-content {{ $vertical ? 'flex-grow-1' : '' }}" id="{{ $id }}-content">
        @foreach($tabs as $index => $tab)
            <div class="tab-pane {{ $fade ? 'fade' : '' }} {{ isset($tab['active']) && $tab['active'] ? 'show active' : '' }}"
                 id="{{ $tab['id'] ?? 'tab-' . $index }}-pane"
                 role="tabpanel"
                 aria-labelledby="{{ $tab['id'] ?? 'tab-' . $index }}-tab"
                 tabindex="0">
                @if(isset($tab['content']))
                    {!! $tab['content'] !!}
                @elseif(isset($tab['view']))
                    @include($tab['view'], $tab['data'] ?? [])
                @else
                    <p>Tab content for {{ $tab['title'] ?? 'Tab ' . ($index + 1) }}</p>
                @endif
            </div>
        @endforeach
    </div>
</div>

<style>
/* Tabs Customizations */
.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 1rem;
}

.nav-tabs .nav-link {
    margin-bottom: -2px;
    border: 1px solid transparent;
    border-top-left-radius: 0.375rem;
    border-top-right-radius: 0.375rem;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1rem;
    transition: all 0.15s ease-in-out;
}

.nav-tabs .nav-link:hover {
    border-color: #e9ecef #e9ecef #dee2e6;
    color: #495057;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    background-color: #ffffff;
    border-color: #dee2e6 #dee2e6 #ffffff;
    border-bottom-color: transparent;
}

.nav-tabs .nav-link.disabled {
    color: #6c757d;
    background-color: transparent;
    border-color: transparent;
    opacity: 0.5;
    cursor: not-allowed;
}

/* Pills */
.nav-pills .nav-link {
    border-radius: 0.375rem;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1rem;
    margin-bottom: 0.25rem;
    transition: all 0.15s ease-in-out;
}

.nav-pills .nav-link:hover {
    color: var(--primary-color);
    background-color: rgba(var(--primary-color-rgb), 0.1);
}

.nav-pills .nav-link.active {
    color: #ffffff;
    background-color: var(--primary-color);
}

.nav-pills .nav-link.disabled {
    color: #6c757d;
    background-color: transparent;
    opacity: 0.5;
    cursor: not-allowed;
}

/* Justified tabs */
.nav-justified .nav-item {
    flex-basis: 0;
    flex-grow: 1;
    text-align: center;
}

/* Vertical tabs */
.nav.flex-column .nav-link {
    text-align: left;
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
}

.nav.flex-column.nav-tabs .nav-link {
    border: 1px solid transparent;
    margin-right: -1px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.nav.flex-column.nav-tabs .nav-link.active {
    border-color: #dee2e6 transparent #dee2e6 #dee2e6;
    border-right-color: transparent;
}

/* Tab content */
.tab-content {
    background-color: #ffffff;
    border-radius: 0.375rem;
    padding: 1.5rem;
    border: 1px solid #dee2e6;
}

.tab-pane {
    min-height: 100px;
}

/* Dark theme support */
.dark-scheme .nav-tabs {
    border-bottom-color: rgba(255, 255, 255, 0.2);
}

.dark-scheme .nav-tabs .nav-link {
    color: rgba(255, 255, 255, 0.65);
}

.dark-scheme .nav-tabs .nav-link:hover {
    border-color: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.85);
}

.dark-scheme .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: var(--bg-color-dark);
    border-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.2) var(--bg-color-dark);
}

.dark-scheme .nav-pills .nav-link {
    color: rgba(255, 255, 255, 0.65);
}

.dark-scheme .nav-pills .nav-link:hover {
    color: #ffffff;
    background-color: rgba(255, 255, 255, 0.1);
}

.dark-scheme .tab-content {
    background-color: var(--bg-color-dark);
    border-color: rgba(255, 255, 255, 0.2);
}

/* Animation effects */
.tab-pane.fade {
    transition: opacity 0.15s linear;
}

.tab-pane:not(.show) {
    display: none;
}

.tab-pane.active {
    display: block;
}

/* Badge in tabs */
.nav-link .badge {
    font-size: 0.75em;
}

/* Icon spacing */
.nav-link i {
    margin-right: 0.5rem;
}

/* Responsive behavior */
@media (max-width: 768px) {
    .nav-tabs,
    .nav-pills {
        flex-wrap: wrap;
    }
    
    .nav-justified .nav-item {
        flex-basis: auto;
    }
    
    .tabs-wrapper.d-flex {
        flex-direction: column;
    }
    
    .nav.flex-column {
        flex-direction: row !important;
        margin-bottom: 1rem;
    }
    
    .tab-content {
        padding: 1rem;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#{{ $id }}-nav button[data-bs-toggle="tab"]'));
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl);
        
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault();
            tabTrigger.show();
        });
    });

    // Custom tab events
    document.addEventListener('show.bs.tab', function (event) {
        // event.target = newly activated tab
        // event.relatedTarget = previous active tab
        
        @if(isset($onTabShow))
            {{ $onTabShow }}
        @endif
    });
    
    document.addEventListener('shown.bs.tab', function (event) {
        @if(isset($onTabShown))
            {{ $onTabShown }}
        @endif
    });
    
    document.addEventListener('hide.bs.tab', function (event) {
        @if(isset($onTabHide))
            {{ $onTabHide }}
        @endif
    });
    
    document.addEventListener('hidden.bs.tab', function (event) {
        @if(isset($onTabHidden))
            {{ $onTabHidden }}
        @endif
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(event) {
        if (event.target.matches('.nav-link[data-bs-toggle="tab"]')) {
            var currentTab = event.target;
            var tabList = currentTab.closest('.nav').querySelectorAll('.nav-link[data-bs-toggle="tab"]:not(.disabled)');
            var currentIndex = Array.from(tabList).indexOf(currentTab);
            
            if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                event.preventDefault();
                var nextIndex = (currentIndex + 1) % tabList.length;
                tabList[nextIndex].focus();
                tabList[nextIndex].click();
            } else if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                event.preventDefault();
                var prevIndex = (currentIndex - 1 + tabList.length) % tabList.length;
                tabList[prevIndex].focus();
                tabList[prevIndex].click();
            } else if (event.key === 'Home') {
                event.preventDefault();
                tabList[0].focus();
                tabList[0].click();
            } else if (event.key === 'End') {
                event.preventDefault();
                tabList[tabList.length - 1].focus();
                tabList[tabList.length - 1].click();
            }
        }
    });
});
</script>
@endpush
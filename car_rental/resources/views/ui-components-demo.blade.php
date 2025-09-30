@extends('layouts.app')

@section('title', 'UI Components Demo - Caravel')
@section('description', 'Showcase of Caravel UI components including badges, modals, tooltips, popovers, and tabs')

@section('content')
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            
            <!-- section begin -->
            <section id="subheader" class="jarallax text-light">
                <img src="{{ asset('images/background/subheader.jpg') }}" class="jarallax-img" alt="">
                <div class="center-y relative text-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h1>UI Components</h1>
                                <p class="lead">Interactive components showcase</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->
            
            <section aria-label="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Badges</h2>
                            <p>Various badge styles and sizes for labels and notifications.</p>
                            
                            <div class="mb-4">
                                <h5>Basic Badges</h5>
                                @include('components.badge', ['text' => 'Primary', 'type' => 'primary'])
                                @include('components.badge', ['text' => 'Secondary', 'type' => 'secondary'])
                                @include('components.badge', ['text' => 'Success', 'type' => 'success'])
                                @include('components.badge', ['text' => 'Danger', 'type' => 'danger'])
                                @include('components.badge', ['text' => 'Warning', 'type' => 'warning'])
                                @include('components.badge', ['text' => 'Info', 'type' => 'info'])
                                @include('components.badge', ['text' => 'Light', 'type' => 'light'])
                                @include('components.badge', ['text' => 'Dark', 'type' => 'dark'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Badge Sizes</h5>
                                @include('components.badge', ['text' => 'Small', 'size' => 'sm'])
                                @include('components.badge', ['text' => 'Medium', 'size' => 'md'])
                                @include('components.badge', ['text' => 'Large', 'size' => 'lg'])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Badges with Icons</h5>
                                @include('components.badge', ['text' => 'New', 'type' => 'success', 'icon' => 'fa fa-star'])
                                @include('components.badge', ['text' => 'Hot', 'type' => 'danger', 'icon' => 'fa fa-fire'])
                                @include('components.badge', ['text' => 'Featured', 'type' => 'primary', 'icon' => 'fa fa-crown'])
                            </div>
                        </div>
                    </div>
                    
                    <div class="spacer-single"></div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Tooltips</h2>
                            <p>Hover over the elements below to see tooltips in different positions.</p>
                            
                            <div class="mb-4">
                                <h5>Tooltip Positions</h5>
                                @include('components.tooltip', ['text' => 'Top tooltip', 'position' => 'top'])
                                    <button class="btn btn-outline-primary me-2">Top</button>
                                @endinclude
                                
                                @include('components.tooltip', ['text' => 'Right tooltip', 'position' => 'right'])
                                    <button class="btn btn-outline-primary me-2">Right</button>
                                @endinclude
                                
                                @include('components.tooltip', ['text' => 'Bottom tooltip', 'position' => 'bottom'])
                                    <button class="btn btn-outline-primary me-2">Bottom</button>
                                @endinclude
                                
                                @include('components.tooltip', ['text' => 'Left tooltip', 'position' => 'left'])
                                    <button class="btn btn-outline-primary me-2">Left</button>
                                @endinclude
                            </div>
                        </div>
                    </div>
                    
                    <div class="spacer-single"></div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Popovers</h2>
                            <p>Click on the buttons below to see popovers with titles and content.</p>
                            
                            <div class="mb-4">
                                <h5>Basic Popovers</h5>
                                @include('components.popover', [
                                    'title' => 'Popover Title',
                                    'content' => 'This is the popover content. It can contain more detailed information.',
                                    'position' => 'top'
                                ])
                                    <button class="btn btn-primary me-2">Top Popover</button>
                                @endinclude
                                
                                @include('components.popover', [
                                    'title' => 'Information',
                                    'content' => 'Right positioned popover with useful information.',
                                    'position' => 'right'
                                ])
                                    <button class="btn btn-info me-2">Right Popover</button>
                                @endinclude
                                
                                @include('components.popover', [
                                    'title' => 'Details',
                                    'content' => 'Bottom popover with detailed content and longer text to show how it wraps.',
                                    'position' => 'bottom'
                                ])
                                    <button class="btn btn-success me-2">Bottom Popover</button>
                                @endinclude
                                
                                @include('components.popover', [
                                    'title' => 'Note',
                                    'content' => 'Left positioned popover for notes and additional information.',
                                    'position' => 'left'
                                ])
                                    <button class="btn btn-warning me-2">Left Popover</button>
                                @endinclude
                            </div>
                        </div>
                    </div>
                    
                    <div class="spacer-single"></div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Tabs</h2>
                            <p>Interactive tab components with different styles and orientations.</p>
                            
                            <div class="mb-4">
                                <h5>Basic Tabs</h5>
                                @include('components.tabs', [
                                    'tabs' => [
                                        [
                                            'id' => 'home',
                                            'title' => 'Home',
                                            'content' => '<h4>Home Content</h4><p>This is the home tab content. It contains information about the home section.</p>',
                                            'active' => true,
                                            'icon' => 'fa fa-home'
                                        ],
                                        [
                                            'id' => 'profile',
                                            'title' => 'Profile',
                                            'content' => '<h4>Profile Content</h4><p>This is the profile tab content. Here you can manage your profile information.</p>',
                                            'icon' => 'fa fa-user'
                                        ],
                                        [
                                            'id' => 'settings',
                                            'title' => 'Settings',
                                            'content' => '<h4>Settings Content</h4><p>This is the settings tab content. Configure your preferences here.</p>',
                                            'icon' => 'fa fa-cog',
                                            'badge' => '3'
                                        ]
                                    ],
                                    'type' => 'tabs'
                                ])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Pills Tabs</h5>
                                @include('components.tabs', [
                                    'tabs' => [
                                        [
                                            'id' => 'cars',
                                            'title' => 'Cars',
                                            'content' => '<h4>Cars Section</h4><p>Browse our collection of available rental cars.</p>',
                                            'active' => true,
                                            'icon' => 'fa fa-car'
                                        ],
                                        [
                                            'id' => 'bookings',
                                            'title' => 'Bookings',
                                            'content' => '<h4>Bookings Section</h4><p>View and manage your car rental bookings.</p>',
                                            'icon' => 'fa fa-calendar'
                                        ],
                                        [
                                            'id' => 'support',
                                            'title' => 'Support',
                                            'content' => '<h4>Support Section</h4><p>Get help and contact our support team.</p>',
                                            'icon' => 'fa fa-support'
                                        ]
                                    ],
                                    'type' => 'pills'
                                ])
                            </div>
                            
                            <div class="mb-4">
                                <h5>Vertical Tabs</h5>
                                @include('components.tabs', [
                                    'tabs' => [
                                        [
                                            'id' => 'overview',
                                            'title' => 'Overview',
                                            'content' => '<h4>Overview</h4><p>General overview of the platform and services.</p>',
                                            'active' => true
                                        ],
                                        [
                                            'id' => 'features',
                                            'title' => 'Features',
                                            'content' => '<h4>Features</h4><p>Detailed list of platform features and capabilities.</p>'
                                        ],
                                        [
                                            'id' => 'pricing',
                                            'title' => 'Pricing',
                                            'content' => '<h4>Pricing</h4><p>Transparent pricing information for all services.</p>'
                                        ]
                                    ],
                                    'type' => 'pills',
                                    'vertical' => true
                                ])
                            </div>
                        </div>
                    </div>
                    
                    <div class="spacer-single"></div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Modal</h2>
                            <p>Modal dialogs for displaying content in overlay windows.</p>
                            
                            <div class="mb-4">
                                <h5>Modal Sizes</h5>
                                <!-- Small Modal Trigger -->
                                <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#smallModal">
                                    <i class="fa fa-compress me-2"></i>Small Modal
                                </button>
                                
                                <!-- Basic Modal Trigger -->
                                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#basicModal">
                                    <i class="fa fa-window-maximize me-2"></i>Basic Modal
                                </button>
                                
                                <!-- Large Modal Trigger -->
                                <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#largeModal">
                                    <i class="fa fa-expand me-2"></i>Large Modal
                                </button>
                                
                                <!-- Extra Large Modal Trigger -->
                                <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#xlModal">
                                    <i class="fa fa-arrows-alt me-2"></i>XL Modal
                                </button>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Modal Options</h5>
                                <!-- Centered Modal Trigger -->
                                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#centeredModal">
                                    <i class="fa fa-center-align me-2"></i>Centered Modal
                                </button>
                                
                                <!-- Scrollable Modal Trigger -->
                                <button type="button" class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#scrollableModal">
                                    <i class="fa fa-scroll me-2"></i>Scrollable Modal
                                </button>
                                
                                <!-- Static Modal Trigger -->
                                <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#staticModal">
                                    <i class="fa fa-lock me-2"></i>Static Modal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->


<!-- Small Modal -->
@include('components.modal', [
    'id' => 'smallModal',
    'title' => '<i class="fa fa-compress me-2"></i>Small Modal',
    'size' => 'sm',
    'showFooter' => true
])
    @slot('body')
        <p>This is a small modal dialog. It's perfect for simple confirmations or brief messages.</p>
        <p>Small modals are great for:</p>
        <ul>
            <li>Quick confirmations</li>
            <li>Simple alerts</li>
            <li>Brief notifications</li>
        </ul>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm</button>
    @endslot
@endinclude

<!-- Basic Modal -->
@include('components.modal', [
    'id' => 'basicModal',
    'title' => '<i class="fa fa-info-circle me-2"></i>Basic Modal',
    'size' => 'md',
    'showFooter' => true
])
    @slot('body')
        <p>This is a basic modal dialog. It can contain any type of content including forms, images, or text.</p>
        <p>Modal dialogs are useful for:</p>
        <ul>
            <li>Displaying detailed information</li>
            <li>Collecting user input</li>
            <li>Confirming actions</li>
            <li>Showing media content</li>
        </ul>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save Changes</button>
    @endslot
@endinclude

<!-- Large Modal -->
@include('components.modal', [
    'id' => 'largeModal',
    'title' => '<i class="fa fa-expand me-2"></i>Large Modal',
    'size' => 'lg',
    'showFooter' => true
])
    @slot('body')
        <div class="row">
            <div class="col-md-6">
                <h6>Left Column</h6>
                <p>This is a large modal that provides more space for content. It's perfect for complex forms or detailed information.</p>
                <img src="{{ asset('images/cars/car-1.jpg') }}" class="img-fluid rounded" alt="Sample Car">
            </div>
            <div class="col-md-6">
                <h6>Right Column</h6>
                <p>Large modals can contain multiple columns and complex layouts.</p>
                <form>
                    <div class="mb-3">
                        <label for="modalName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="modalName">
                    </div>
                    <div class="mb-3">
                        <label for="modalEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="modalEmail">
                    </div>
                    <div class="mb-3">
                        <label for="modalMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="modalMessage" rows="3"></textarea>
                    </div>
                </form>
            </div>
        </div>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary">Submit</button>
    @endslot
@endinclude

<!-- Extra Large Modal -->
@include('components.modal', [
    'id' => 'xlModal',
    'title' => '<i class="fa fa-arrows-alt me-2"></i>Extra Large Modal',
    'size' => 'xl',
    'showFooter' => true
])
    @slot('body')
        <div class="row">
            <div class="col-md-8">
                <h4>Main Content Area</h4>
                <p>Extra large modals provide maximum space for complex content, forms, or data visualization.</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Features</h6>
                        <ul>
                            <li>Wide layout support</li>
                            <li>Complex form handling</li>
                            <li>Multiple content sections</li>
                            <li>Advanced components integration</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Use Cases</h6>
                        <ul>
                            <li>Data entry forms</li>
                            <li>Content editors</li>
                            <li>Configuration panels</li>
                            <li>Media galleries</li>
                        </ul>
                    </div>
                </div>
                
                <h6>Sample Form</h6>
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName">
                    </div>
                    <div class="col-md-6">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName">
                    </div>
                    <div class="col-md-8">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city">
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <h6>Sidebar Content</h6>
                <p>Additional information or controls can be placed in the sidebar.</p>
                
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Quick Stats</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <span>Total Cars:</span>
                            <strong>156</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Available:</span>
                            <strong>89</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Rented:</span>
                            <strong>67</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-warning">Save Draft</button>
        <button type="button" class="btn btn-primary">Save & Continue</button>
    @endslot
@endinclude

<!-- Centered Modal -->
@include('components.modal', [
    'id' => 'centeredModal',
    'title' => '<i class="fa fa-check-circle me-2"></i>Centered Modal',
    'size' => 'md',
    'centered' => true,
    'showFooter' => true,
    'bodyClass' => 'text-center'
])
    @slot('body')
        <div class="mb-3">
            <i class="fa fa-check-circle text-success" style="font-size: 4rem;"></i>
        </div>
        <h4>Success!</h4>
        <p>This is a centered modal that appears in the middle of the screen. Perfect for confirmations and alerts.</p>
    @endslot
    
    @slot('footer')
        <div class="w-100 text-center">
            <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                <i class="fa fa-check me-2"></i>OK
            </button>
        </div>
    @endslot
@endinclude

<!-- Scrollable Modal -->
@include('components.modal', [
    'id' => 'scrollableModal',
    'title' => '<i class="fa fa-scroll me-2"></i>Scrollable Modal',
    'size' => 'lg',
    'scrollable' => true,
    'showFooter' => true
])
    @slot('body')
        <h6>Long Content Example</h6>
        <p>This modal demonstrates scrollable content when the modal body exceeds the viewport height.</p>
        
        @for($i = 1; $i <= 20; $i++)
            <div class="mb-3 p-3 border rounded">
                <h6>Section {{ $i }}</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                
                @if($i % 5 == 0)
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        This is milestone section {{ $i }}! The content continues below.
                    </div>
                @endif
            </div>
        @endfor
        
        <div class="alert alert-success">
            <i class="fa fa-check-circle me-2"></i>
            You've reached the end of the scrollable content!
        </div>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Action</button>
    @endslot
@endinclude

<!-- Static Modal -->
@include('components.modal', [
    'id' => 'staticModal',
    'title' => '<i class="fa fa-lock me-2"></i>Static Modal',
    'size' => 'md',
    'backdrop' => 'static',
    'keyboard' => false,
    'showFooter' => true
])
    @slot('body')
        <div class="alert alert-warning">
            <i class="fa fa-exclamation-triangle me-2"></i>
            <strong>Important Notice:</strong> This modal cannot be closed by clicking outside or pressing Escape.
        </div>
        
        <p>Static modals are useful for:</p>
        <ul>
            <li>Critical confirmations</li>
            <li>Required form submissions</li>
            <li>Important warnings</li>
            <li>Preventing accidental dismissal</li>
        </ul>
        
        <p>You must click one of the buttons below to close this modal.</p>
    @endslot
    
    @slot('footer')
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
            <i class="fa fa-times me-2"></i>Force Close
        </button>
    @endslot
@endinclude

@endsection
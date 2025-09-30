@props([
    'images' => [],
    'thumbnails' => [],
    'id' => 'gallery-popup-' . uniqid(),
    'title' => '',
    'description' => '',
    'showThumbnails' => true,
    'showCounter' => true,
    'showNavigation' => true,
    'showZoom' => true,
    'autoPlay' => false,
    'autoPlayInterval' => 5000,
    'enableSwipe' => true,
    'enableKeyboard' => true,
    'transition' => 'fade', // fade, slide, zoom
    'theme' => 'dark' // dark, light
])

@php
$galleryId = $id;
$imageCount = count($images);
@endphp

<style>
/* Gallery Popup Styles */
.gallery-popup {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.9);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-popup.active {
    display: flex;
    opacity: 1;
}

.gallery-popup.light {
    background: rgba(255, 255, 255, 0.95);
}

.gallery-container {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.gallery-main {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    overflow: hidden;
    border-radius: 8px;
}

.gallery-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

.gallery-image.zoomed {
    cursor: zoom-out;
    transform: scale(1.5);
}

.gallery-image.fade-transition {
    transition: opacity 0.3s ease;
}

.gallery-image.slide-transition {
    transition: transform 0.3s ease;
}

.gallery-image.zoom-transition {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Navigation Controls */
.gallery-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
}

.gallery-nav:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: translateY(-50%) scale(1.1);
}

.gallery-nav.prev {
    left: 20px;
}

.gallery-nav.next {
    right: 20px;
}

.light .gallery-nav {
    background: rgba(255, 255, 255, 0.8);
    color: #333;
}

.light .gallery-nav:hover {
    background: rgba(255, 255, 255, 0.95);
}

/* Close Button */
.gallery-close {
    position: absolute;
    top: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
}

.gallery-close:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.light .gallery-close {
    background: rgba(255, 255, 255, 0.8);
    color: #333;
}

.light .gallery-close:hover {
    background: rgba(255, 255, 255, 0.95);
}

/* Counter */
.gallery-counter {
    position: absolute;
    top: 20px;
    left: 20px;
    background: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.light .gallery-counter {
    background: rgba(255, 255, 255, 0.8);
    color: #333;
}

/* Thumbnails */
.gallery-thumbnails {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding: 0 20px;
    max-width: 100%;
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 6px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: transparent;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.gallery-thumbnail {
    flex-shrink: 0;
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    opacity: 0.6;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.gallery-thumbnail:hover {
    opacity: 0.9;
    transform: scale(1.05);
}

.gallery-thumbnail.active {
    opacity: 1;
    border-color: #fff;
    transform: scale(1.1);
}

.light .gallery-thumbnail.active {
    border-color: #333;
}

/* Title and Description */
.gallery-info {
    text-align: center;
    color: white;
    margin-top: 15px;
    padding: 0 20px;
}

.light .gallery-info {
    color: #333;
}

.gallery-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.gallery-description {
    font-size: 0.9rem;
    opacity: 0.8;
    line-height: 1.4;
}

/* Loading Spinner */
.gallery-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 2rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .gallery-container {
        max-width: 95vw;
        max-height: 95vh;
    }
    
    .gallery-image {
        max-height: 70vh;
    }
    
    .gallery-nav {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .gallery-nav.prev {
        left: 10px;
    }
    
    .gallery-nav.next {
        right: 10px;
    }
    
    .gallery-close {
        top: 10px;
        right: 10px;
        width: 35px;
        height: 35px;
        font-size: 1.2rem;
    }
    
    .gallery-counter {
        top: 10px;
        left: 10px;
        padding: 6px 12px;
        font-size: 0.8rem;
    }
    
    .gallery-thumbnail {
        width: 60px;
        height: 45px;
    }
}

/* Zoom Controls */
.gallery-zoom-controls {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
}

.gallery-zoom-btn {
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.gallery-zoom-btn:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.light .gallery-zoom-btn {
    background: rgba(255, 255, 255, 0.8);
    color: #333;
}

.light .gallery-zoom-btn:hover {
    background: rgba(255, 255, 255, 0.95);
}

/* Auto-play Controls */
.gallery-play-controls {
    position: absolute;
    bottom: 20px;
    left: 20px;
}

.gallery-play-btn {
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.gallery-play-btn:hover {
    background: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.light .gallery-play-btn {
    background: rgba(255, 255, 255, 0.8);
    color: #333;
}

.light .gallery-play-btn:hover {
    background: rgba(255, 255, 255, 0.95);
}
</style>

<!-- Gallery Trigger (can be customized) -->
<div class="gallery-trigger" data-gallery="{{ $galleryId }}">
    {{ $slot }}
</div>

<!-- Gallery Popup -->
<div id="{{ $galleryId }}" class="gallery-popup {{ $theme }}" data-transition="{{ $transition }}">
    <div class="gallery-container">
        
        <!-- Close Button -->
        <button class="gallery-close" onclick="closeGallery('{{ $galleryId }}')">
            <i class="fas fa-times"></i>
        </button>
        
        @if($showCounter)
            <!-- Counter -->
            <div class="gallery-counter">
                <span class="current-image">1</span> / <span class="total-images">{{ $imageCount }}</span>
            </div>
        @endif
        
        <!-- Main Image Container -->
        <div class="gallery-main">
            @if($showNavigation && $imageCount > 1)
                <button class="gallery-nav prev" onclick="previousImage('{{ $galleryId }}')">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="gallery-nav next" onclick="nextImage('{{ $galleryId }}')">
                    <i class="fas fa-chevron-right"></i>
                </button>
            @endif
            
            <div class="gallery-loading">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            
            <img class="gallery-image {{ $transition }}-transition" src="" alt="" style="display: none;">
            
            @if($showZoom)
                <div class="gallery-zoom-controls">
                    <button class="gallery-zoom-btn" onclick="zoomImage('{{ $galleryId }}')">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button class="gallery-zoom-btn" onclick="resetZoom('{{ $galleryId }}')">
                        <i class="fas fa-search-minus"></i>
                    </button>
                </div>
            @endif
        </div>
        
        @if($autoPlay && $imageCount > 1)
            <!-- Auto-play Controls -->
            <div class="gallery-play-controls">
                <button class="gallery-play-btn" onclick="toggleAutoPlay('{{ $galleryId }}')">
                    <i class="fas fa-play"></i>
                </button>
            </div>
        @endif
        
        @if($showThumbnails && count($thumbnails) > 0)
            <!-- Thumbnails -->
            <div class="gallery-thumbnails">
                @foreach($thumbnails as $index => $thumbnail)
                    <img class="gallery-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                         src="{{ $thumbnail }}" 
                         alt="Thumbnail {{ $index + 1 }}"
                         onclick="goToImage('{{ $galleryId }}', {{ $index }})">
                @endforeach
            </div>
        @endif
        
        @if($title || $description)
            <!-- Title and Description -->
            <div class="gallery-info">
                @if($title)
                    <div class="gallery-title">{{ $title }}</div>
                @endif
                @if($description)
                    <div class="gallery-description">{{ $description }}</div>
                @endif
            </div>
        @endif
        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize gallery
    const galleryId = '{{ $galleryId }}';
    const images = @json($images);
    const autoPlay = {{ $autoPlay ? 'true' : 'false' }};
    const autoPlayInterval = {{ $autoPlayInterval }};
    const enableSwipe = {{ $enableSwipe ? 'true' : 'false' }};
    const enableKeyboard = {{ $enableKeyboard ? 'true' : 'false' }};
    
    let currentImageIndex = 0;
    let isAutoPlaying = false;
    let autoPlayTimer = null;
    let isZoomed = false;
    
    const gallery = document.getElementById(galleryId);
    const trigger = document.querySelector(`[data-gallery="${galleryId}"]`);
    const imageElement = gallery.querySelector('.gallery-image');
    const loading = gallery.querySelector('.gallery-loading');
    const counterCurrent = gallery.querySelector('.current-image');
    const thumbnails = gallery.querySelectorAll('.gallery-thumbnail');
    
    // Initialize gallery data
    window.galleryData = window.galleryData || {};
    window.galleryData[galleryId] = {
        images: images,
        currentIndex: 0,
        isAutoPlaying: false,
        autoPlayTimer: null,
        isZoomed: false
    };
    
    // Open gallery when trigger is clicked
    if (trigger) {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            openGallery(galleryId);
        });
    }
    
    // Load first image
    if (images.length > 0) {
        loadImage(galleryId, 0);
    }
    
    // Keyboard navigation
    if (enableKeyboard) {
        document.addEventListener('keydown', function(e) {
            if (!gallery.classList.contains('active')) return;
            
            switch(e.key) {
                case 'Escape':
                    closeGallery(galleryId);
                    break;
                case 'ArrowLeft':
                    previousImage(galleryId);
                    break;
                case 'ArrowRight':
                    nextImage(galleryId);
                    break;
                case ' ':
                    e.preventDefault();
                    toggleAutoPlay(galleryId);
                    break;
                case '+':
                case '=':
                    zoomImage(galleryId);
                    break;
                case '-':
                    resetZoom(galleryId);
                    break;
            }
        });
    }
    
    // Touch/Swipe support
    if (enableSwipe) {
        let startX = 0;
        let startY = 0;
        
        gallery.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        gallery.addEventListener('touchend', function(e) {
            if (!startX || !startY) return;
            
            const endX = e.changedTouches[0].clientX;
            const endY = e.changedTouches[0].clientY;
            
            const diffX = startX - endX;
            const diffY = startY - endY;
            
            // Only handle horizontal swipes
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    nextImage(galleryId);
                } else {
                    previousImage(galleryId);
                }
            }
            
            startX = 0;
            startY = 0;
        });
    }
    
    // Close gallery when clicking outside image
    gallery.addEventListener('click', function(e) {
        if (e.target === gallery) {
            closeGallery(galleryId);
        }
    });
    
    // Auto-play initialization
    if (autoPlay) {
        startAutoPlay(galleryId);
    }
});

// Global gallery functions
window.openGallery = function(galleryId) {
    const gallery = document.getElementById(galleryId);
    gallery.classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Dispatch custom event
    gallery.dispatchEvent(new CustomEvent('gallery:opened', {
        detail: { galleryId: galleryId }
    }));
};

window.closeGallery = function(galleryId) {
    const gallery = document.getElementById(galleryId);
    gallery.classList.remove('active');
    document.body.style.overflow = '';
    
    // Stop auto-play
    stopAutoPlay(galleryId);
    
    // Reset zoom
    resetZoom(galleryId);
    
    // Dispatch custom event
    gallery.dispatchEvent(new CustomEvent('gallery:closed', {
        detail: { galleryId: galleryId }
    }));
};

window.loadImage = function(galleryId, index) {
    const data = window.galleryData[galleryId];
    if (!data || !data.images[index]) return;
    
    const gallery = document.getElementById(galleryId);
    const imageElement = gallery.querySelector('.gallery-image');
    const loading = gallery.querySelector('.gallery-loading');
    const counterCurrent = gallery.querySelector('.current-image');
    const thumbnails = gallery.querySelectorAll('.gallery-thumbnail');
    
    // Show loading
    loading.style.display = 'block';
    imageElement.style.display = 'none';
    
    // Load new image
    const img = new Image();
    img.onload = function() {
        imageElement.src = img.src;
        imageElement.style.display = 'block';
        loading.style.display = 'none';
        
        // Update counter
        if (counterCurrent) {
            counterCurrent.textContent = index + 1;
        }
        
        // Update thumbnails
        thumbnails.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === index);
        });
        
        // Update data
        data.currentIndex = index;
        
        // Dispatch custom event
        gallery.dispatchEvent(new CustomEvent('gallery:imageChanged', {
            detail: { galleryId: galleryId, index: index, image: data.images[index] }
        }));
    };
    
    img.src = data.images[index];
};

window.nextImage = function(galleryId) {
    const data = window.galleryData[galleryId];
    if (!data) return;
    
    const nextIndex = (data.currentIndex + 1) % data.images.length;
    loadImage(galleryId, nextIndex);
};

window.previousImage = function(galleryId) {
    const data = window.galleryData[galleryId];
    if (!data) return;
    
    const prevIndex = data.currentIndex === 0 ? data.images.length - 1 : data.currentIndex - 1;
    loadImage(galleryId, prevIndex);
};

window.goToImage = function(galleryId, index) {
    loadImage(galleryId, index);
};

window.zoomImage = function(galleryId) {
    const gallery = document.getElementById(galleryId);
    const imageElement = gallery.querySelector('.gallery-image');
    const data = window.galleryData[galleryId];
    
    if (!data.isZoomed) {
        imageElement.classList.add('zoomed');
        data.isZoomed = true;
    }
};

window.resetZoom = function(galleryId) {
    const gallery = document.getElementById(galleryId);
    const imageElement = gallery.querySelector('.gallery-image');
    const data = window.galleryData[galleryId];
    
    imageElement.classList.remove('zoomed');
    data.isZoomed = false;
};

window.toggleAutoPlay = function(galleryId) {
    const data = window.galleryData[galleryId];
    if (!data) return;
    
    if (data.isAutoPlaying) {
        stopAutoPlay(galleryId);
    } else {
        startAutoPlay(galleryId);
    }
};

window.startAutoPlay = function(galleryId) {
    const data = window.galleryData[galleryId];
    if (!data || data.images.length <= 1) return;
    
    const gallery = document.getElementById(galleryId);
    const playBtn = gallery.querySelector('.gallery-play-btn i');
    
    data.isAutoPlaying = true;
    if (playBtn) playBtn.className = 'fas fa-pause';
    
    data.autoPlayTimer = setInterval(() => {
        nextImage(galleryId);
    }, {{ $autoPlayInterval }});
};

window.stopAutoPlay = function(galleryId) {
    const data = window.galleryData[galleryId];
    if (!data) return;
    
    const gallery = document.getElementById(galleryId);
    const playBtn = gallery.querySelector('.gallery-play-btn i');
    
    data.isAutoPlaying = false;
    if (playBtn) playBtn.className = 'fas fa-play';
    
    if (data.autoPlayTimer) {
        clearInterval(data.autoPlayTimer);
        data.autoPlayTimer = null;
    }
};
</script>

{{-- 
Usage Examples:

Basic Gallery:
@include('components.gallery-popup', [
    'images' => [
        asset('images/cars/car-1.jpg'),
        asset('images/cars/car-2.jpg'),
        asset('images/cars/car-3.jpg')
    ]
])
    <button class="btn btn-primary">Open Gallery</button>
@endinclude

Gallery with Thumbnails:
@include('components.gallery-popup', [
    'images' => [
        asset('images/cars/car-1.jpg'),
        asset('images/cars/car-2.jpg')
    ],
    'thumbnails' => [
        asset('images/cars/car-1-thumb.jpg'),
        asset('images/cars/car-2-thumb.jpg')
    ],
    'title' => 'Car Gallery',
    'description' => 'Beautiful car collection'
])
    <img src="{{ asset('images/cars/car-1-thumb.jpg') }}" class="img-thumbnail" alt="Open Gallery">
@endinclude

Auto-play Gallery:
@include('components.gallery-popup', [
    'images' => $carImages,
    'autoPlay' => true,
    'autoPlayInterval' => 3000,
    'theme' => 'light'
])
    <div class="gallery-grid">
        @foreach($carImages as $image)
            <img src="{{ $image }}" class="img-fluid" alt="Gallery Image">
        @endforeach
    </div>
@endinclude
--}}
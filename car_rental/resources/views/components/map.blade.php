@props([
    'latitude' => 40.7128,
    'longitude' => -74.0060,
    'zoom' => 13,
    'height' => '400px',
    'width' => '100%',
    'markers' => [],
    'center' => null,
    'mapType' => 'roadmap', // roadmap, satellite, hybrid, terrain
    'controls' => true,
    'scrollWheel' => true,
    'draggable' => true,
    'zoomControl' => true,
    'streetViewControl' => true,
    'fullscreenControl' => true,
    'mapTypeControl' => true,
    'clickable' => true,
    'infoWindow' => true,
    'clustering' => false,
    'customStyle' => null,
    'id' => 'map-' . uniqid(),
    'apiKey' => null,
    'libraries' => ['places'],
    'theme' => 'default' // default, dark, retro, silver
])

@php
$mapId = $id;
$centerLat = $center['lat'] ?? $latitude;
$centerLng = $center['lng'] ?? $longitude;

// Predefined map themes
$mapThemes = [
    'dark' => [
        ['elementType' => 'geometry', 'stylers' => [['color' => '#242f3e']]],
        ['elementType' => 'labels.text.stroke', 'stylers' => [['color' => '#242f3e']]],
        ['elementType' => 'labels.text.fill', 'stylers' => [['color' => '#746855']]],
        ['featureType' => 'administrative.locality', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#d59563']]],
        ['featureType' => 'poi', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#d59563']]],
        ['featureType' => 'poi.park', 'elementType' => 'geometry', 'stylers' => [['color' => '#263c3f']]],
        ['featureType' => 'poi.park', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#6b9a76']]],
        ['featureType' => 'road', 'elementType' => 'geometry', 'stylers' => [['color' => '#38414e']]],
        ['featureType' => 'road', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#212a37']]],
        ['featureType' => 'road', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#9ca5b3']]],
        ['featureType' => 'road.highway', 'elementType' => 'geometry', 'stylers' => [['color' => '#746855']]],
        ['featureType' => 'road.highway', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#1f2835']]],
        ['featureType' => 'road.highway', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#f3d19c']]],
        ['featureType' => 'transit', 'elementType' => 'geometry', 'stylers' => [['color' => '#2f3948']]],
        ['featureType' => 'transit.station', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#d59563']]],
        ['featureType' => 'water', 'elementType' => 'geometry', 'stylers' => [['color' => '#17263c']]],
        ['featureType' => 'water', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#515c6d']]],
        ['featureType' => 'water', 'elementType' => 'labels.text.stroke', 'stylers' => [['color' => '#17263c']]]
    ],
    'retro' => [
        ['elementType' => 'geometry', 'stylers' => [['color' => '#ebe3cd']]],
        ['elementType' => 'labels.text.fill', 'stylers' => [['color' => '#523735']]],
        ['elementType' => 'labels.text.stroke', 'stylers' => [['color' => '#f5f1e6']]],
        ['featureType' => 'administrative', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#c9b2a6']]],
        ['featureType' => 'administrative.land_parcel', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#dcd2be']]],
        ['featureType' => 'administrative.land_parcel', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#ae9e90']]],
        ['featureType' => 'landscape.natural', 'elementType' => 'geometry', 'stylers' => [['color' => '#dfd2ae']]],
        ['featureType' => 'poi', 'elementType' => 'geometry', 'stylers' => [['color' => '#dfd2ae']]],
        ['featureType' => 'poi', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#93817c']]],
        ['featureType' => 'poi.park', 'elementType' => 'geometry.fill', 'stylers' => [['color' => '#a5b076']]],
        ['featureType' => 'poi.park', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#447530']]],
        ['featureType' => 'road', 'elementType' => 'geometry', 'stylers' => [['color' => '#f5f1e6']]],
        ['featureType' => 'road.arterial', 'elementType' => 'geometry', 'stylers' => [['color' => '#fdfcf8']]],
        ['featureType' => 'road.highway', 'elementType' => 'geometry', 'stylers' => [['color' => '#f8c967']]],
        ['featureType' => 'road.highway', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#e9bc62']]],
        ['featureType' => 'road.highway.controlled_access', 'elementType' => 'geometry', 'stylers' => [['color' => '#e98d58']]],
        ['featureType' => 'road.highway.controlled_access', 'elementType' => 'geometry.stroke', 'stylers' => [['color' => '#db8555']]],
        ['featureType' => 'road.local', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#806b63']]],
        ['featureType' => 'transit.line', 'elementType' => 'geometry', 'stylers' => [['color' => '#dfd2ae']]],
        ['featureType' => 'transit.line', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#8f7d77']]],
        ['featureType' => 'transit.line', 'elementType' => 'labels.text.stroke', 'stylers' => [['color' => '#ebe3cd']]],
        ['featureType' => 'transit.station', 'elementType' => 'geometry', 'stylers' => [['color' => '#dfd2ae']]],
        ['featureType' => 'water', 'elementType' => 'geometry.fill', 'stylers' => [['color' => '#b9d3c2']]],
        ['featureType' => 'water', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#92998d']]]
    ],
    'silver' => [
        ['elementType' => 'geometry', 'stylers' => [['color' => '#f5f5f5']]],
        ['elementType' => 'labels.icon', 'stylers' => [['visibility' => 'off']]],
        ['elementType' => 'labels.text.fill', 'stylers' => [['color' => '#616161']]],
        ['elementType' => 'labels.text.stroke', 'stylers' => [['color' => '#f5f5f5']]],
        ['featureType' => 'administrative.land_parcel', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#bdbdbd']]],
        ['featureType' => 'poi', 'elementType' => 'geometry', 'stylers' => [['color' => '#eeeeee']]],
        ['featureType' => 'poi', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#757575']]],
        ['featureType' => 'poi.park', 'elementType' => 'geometry', 'stylers' => [['color' => '#e5e5e5']]],
        ['featureType' => 'poi.park', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#9e9e9e']]],
        ['featureType' => 'road', 'elementType' => 'geometry', 'stylers' => [['color' => '#ffffff']]],
        ['featureType' => 'road.arterial', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#757575']]],
        ['featureType' => 'road.highway', 'elementType' => 'geometry', 'stylers' => [['color' => '#dadada']]],
        ['featureType' => 'road.highway', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#616161']]],
        ['featureType' => 'road.local', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#9e9e9e']]],
        ['featureType' => 'transit.line', 'elementType' => 'geometry', 'stylers' => [['color' => '#e5e5e5']]],
        ['featureType' => 'transit.station', 'elementType' => 'geometry', 'stylers' => [['color' => '#eeeeee']]],
        ['featureType' => 'water', 'elementType' => 'geometry', 'stylers' => [['color' => '#c9c9c9']]],
        ['featureType' => 'water', 'elementType' => 'labels.text.fill', 'stylers' => [['color' => '#9e9e9e']]]
    ]
];

$selectedTheme = $mapThemes[$theme] ?? null;
if ($customStyle) {
    $selectedTheme = $customStyle;
}
@endphp

<style>
.map-container {
    position: relative;
    width: {{ $width }};
    height: {{ $height }};
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.map-canvas {
    width: 100%;
    height: 100%;
}

.map-loading {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #6c757d;
    z-index: 1;
}

.map-loading.hidden {
    display: none;
}

.map-error {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: none;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #dc3545;
    text-align: center;
    padding: 20px;
    z-index: 2;
}

.map-error.show {
    display: flex;
}

.map-controls {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 3;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.map-control-btn {
    background: white;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.map-control-btn:hover {
    background: #f8f9fa;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.map-info-panel {
    position: absolute;
    bottom: 10px;
    left: 10px;
    background: white;
    padding: 10px 15px;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    font-size: 0.9rem;
    max-width: 250px;
    z-index: 3;
    display: none;
}

.map-info-panel.show {
    display: block;
}

/* Dark theme support */
[data-bs-theme="dark"] .map-loading {
    background: #212529;
    color: #adb5bd;
}

[data-bs-theme="dark"] .map-error {
    background: #212529;
}

[data-bs-theme="dark"] .map-control-btn {
    background: #343a40;
    border-color: #495057;
    color: #fff;
}

[data-bs-theme="dark"] .map-control-btn:hover {
    background: #495057;
}

[data-bs-theme="dark"] .map-info-panel {
    background: #343a40;
    color: #fff;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .map-controls {
        top: 5px;
        right: 5px;
    }
    
    .map-control-btn {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .map-info-panel {
        bottom: 5px;
        left: 5px;
        max-width: 200px;
        font-size: 0.8rem;
        padding: 8px 12px;
    }
}

/* Marker clustering styles */
.cluster-marker {
    background: #4285f4;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* Custom info window styles */
.custom-info-window {
    max-width: 300px;
    padding: 15px;
}

.custom-info-window h6 {
    margin: 0 0 8px 0;
    color: #333;
    font-weight: 600;
}

.custom-info-window p {
    margin: 0 0 8px 0;
    color: #666;
    font-size: 0.9rem;
    line-height: 1.4;
}

.custom-info-window .info-actions {
    margin-top: 10px;
}

.custom-info-window .btn {
    font-size: 0.8rem;
    padding: 4px 8px;
}
</style>

<div class="map-container" id="{{ $mapId }}-container">
    <!-- Loading State -->
    <div class="map-loading" id="{{ $mapId }}-loading">
        <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
        <div>Loading map...</div>
        <small class="mt-1">Please wait while we initialize the map</small>
    </div>
    
    <!-- Error State -->
    <div class="map-error" id="{{ $mapId }}-error">
        <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
        <div><strong>Map Error</strong></div>
        <small>Unable to load the map. Please check your internet connection.</small>
        <button class="btn btn-sm btn-outline-danger mt-2" onclick="retryMapLoad('{{ $mapId }}')">
            <i class="fas fa-redo me-1"></i>Retry
        </button>
    </div>
    
    <!-- Map Canvas -->
    <div class="map-canvas" id="{{ $mapId }}"></div>
    
    <!-- Custom Controls -->
    @if($controls)
    <div class="map-controls">
        <button class="map-control-btn" onclick="toggleMapType('{{ $mapId }}')" title="Toggle Map Type">
            <i class="fas fa-layer-group"></i>
        </button>
        <button class="map-control-btn" onclick="centerMap('{{ $mapId }}')" title="Center Map">
            <i class="fas fa-crosshairs"></i>
        </button>
        <button class="map-control-btn" onclick="toggleTraffic('{{ $mapId }}')" title="Toggle Traffic">
            <i class="fas fa-car"></i>
        </button>
    </div>
    @endif
    
    <!-- Info Panel -->
    <div class="map-info-panel" id="{{ $mapId }}-info">
        <div class="info-content"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map data
    const mapId = '{{ $mapId }}';
    const mapConfig = {
        center: { lat: {{ $centerLat }}, lng: {{ $centerLng }} },
        zoom: {{ $zoom }},
        mapTypeId: '{{ $mapType }}',
        disableDefaultUI: {{ $controls ? 'false' : 'true' }},
        scrollwheel: {{ $scrollWheel ? 'true' : 'false' }},
        draggable: {{ $draggable ? 'true' : 'false' }},
        zoomControl: {{ $zoomControl ? 'true' : 'false' }},
        streetViewControl: {{ $streetViewControl ? 'true' : 'false' }},
        fullscreenControl: {{ $fullscreenControl ? 'true' : 'false' }},
        mapTypeControl: {{ $mapTypeControl ? 'true' : 'false' }},
        clickableIcons: {{ $clickable ? 'true' : 'false' }},
        @if($selectedTheme)
        styles: @json($selectedTheme)
        @endif
    };
    
    const markers = @json($markers);
    const clustering = {{ $clustering ? 'true' : 'false' }};
    const infoWindowEnabled = {{ $infoWindow ? 'true' : 'false' }};
    
    // Store map data globally
    window.mapData = window.mapData || {};
    window.mapData[mapId] = {
        map: null,
        markers: [],
        infoWindow: null,
        trafficLayer: null,
        markerCluster: null,
        currentMapType: '{{ $mapType }}'
    };
    
    // Load Google Maps if not already loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
        loadGoogleMaps(() => initializeMap(mapId, mapConfig, markers));
    } else {
        initializeMap(mapId, mapConfig, markers);
    }
});

// Load Google Maps API
function loadGoogleMaps(callback) {
    const apiKey = '{{ $apiKey }}' || 'YOUR_GOOGLE_MAPS_API_KEY';
    const libraries = @json($libraries);
    
    if (apiKey === 'YOUR_GOOGLE_MAPS_API_KEY') {
        console.warn('Google Maps API key not provided. Using demo mode.');
        showMapError('{{ $mapId }}', 'Google Maps API key required');
        return;
    }
    
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&libraries=${libraries.join(',')}&callback=googleMapsLoaded`;
    script.async = true;
    script.defer = true;
    
    script.onerror = function() {
        showMapError('{{ $mapId }}', 'Failed to load Google Maps API');
    };
    
    window.googleMapsLoaded = callback;
    document.head.appendChild(script);
}

// Initialize map
function initializeMap(mapId, config, markers) {
    try {
        const mapContainer = document.getElementById(mapId);
        const loadingElement = document.getElementById(mapId + '-loading');
        const data = window.mapData[mapId];
        
        // Create map
        data.map = new google.maps.Map(mapContainer, config);
        
        // Create info window
        if ({{ $infoWindow ? 'true' : 'false' }}) {
            data.infoWindow = new google.maps.InfoWindow();
        }
        
        // Add markers
        if (markers && markers.length > 0) {
            addMarkers(mapId, markers);
        }
        
        // Setup clustering if enabled
        if ({{ $clustering ? 'true' : 'false' }} && markers.length > 1) {
            setupMarkerClustering(mapId);
        }
        
        // Add click listener
        if ({{ $clickable ? 'true' : 'false' }}) {
            data.map.addListener('click', function(event) {
                handleMapClick(mapId, event);
            });
        }
        
        // Hide loading
        loadingElement.classList.add('hidden');
        
        // Dispatch loaded event
        mapContainer.dispatchEvent(new CustomEvent('map:loaded', {
            detail: { mapId: mapId, map: data.map }
        }));
        
    } catch (error) {
        console.error('Map initialization error:', error);
        showMapError(mapId, 'Failed to initialize map');
    }
}

// Add markers to map
function addMarkers(mapId, markers) {
    const data = window.mapData[mapId];
    if (!data || !data.map) return;
    
    markers.forEach((markerData, index) => {
        const marker = new google.maps.Marker({
            position: { lat: markerData.lat, lng: markerData.lng },
            map: data.map,
            title: markerData.title || `Marker ${index + 1}`,
            icon: markerData.icon || null,
            animation: markerData.animation ? google.maps.Animation[markerData.animation.toUpperCase()] : null
        });
        
        // Add click listener for info window
        if (data.infoWindow && markerData.info) {
            marker.addListener('click', function() {
                const content = typeof markerData.info === 'string' 
                    ? markerData.info 
                    : createInfoWindowContent(markerData.info);
                    
                data.infoWindow.setContent(content);
                data.infoWindow.open(data.map, marker);
            });
        }
        
        // Store marker
        data.markers.push(marker);
    });
}

// Create custom info window content
function createInfoWindowContent(info) {
    return `
        <div class="custom-info-window">
            ${info.title ? `<h6>${info.title}</h6>` : ''}
            ${info.description ? `<p>${info.description}</p>` : ''}
            ${info.address ? `<p><i class="fas fa-map-marker-alt me-1"></i>${info.address}</p>` : ''}
            ${info.phone ? `<p><i class="fas fa-phone me-1"></i>${info.phone}</p>` : ''}
            ${info.website ? `<p><i class="fas fa-globe me-1"></i><a href="${info.website}" target="_blank">Visit Website</a></p>` : ''}
            ${info.actions ? `<div class="info-actions">${info.actions}</div>` : ''}
        </div>
    `;
}

// Setup marker clustering
function setupMarkerClustering(mapId) {
    const data = window.mapData[mapId];
    if (!data || !data.markers.length) return;
    
    // Note: This requires the MarkerClusterer library
    // Include: <script src="https://unpkg.com/@googlemaps/markerclusterer/dist/index.min.js"></script>
    if (typeof MarkerClusterer !== 'undefined') {
        data.markerCluster = new MarkerClusterer({
            map: data.map,
            markers: data.markers,
            renderer: {
                render: ({ count, position }) => {
                    const marker = new google.maps.Marker({
                        position,
                        icon: {
                            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                                    <circle cx="20" cy="20" r="18" fill="#4285f4" stroke="#fff" stroke-width="2"/>
                                    <text x="20" y="25" font-family="Arial" font-size="12" font-weight="bold" text-anchor="middle" fill="#fff">${count}</text>
                                </svg>
                            `),
                            scaledSize: new google.maps.Size(40, 40)
                        },
                        label: {
                            text: count.toString(),
                            color: 'white',
                            fontSize: '12px',
                            fontWeight: 'bold'
                        }
                    });
                    return marker;
                }
            }
        });
    }
}

// Handle map click
function handleMapClick(mapId, event) {
    const data = window.mapData[mapId];
    const infoPanel = document.getElementById(mapId + '-info');
    
    // Close any open info windows
    if (data.infoWindow) {
        data.infoWindow.close();
    }
    
    // Show click coordinates
    if (infoPanel) {
        const lat = event.latLng.lat().toFixed(6);
        const lng = event.latLng.lng().toFixed(6);
        
        infoPanel.querySelector('.info-content').innerHTML = `
            <strong>Clicked Location</strong><br>
            <small>Lat: ${lat}<br>Lng: ${lng}</small>
        `;
        infoPanel.classList.add('show');
        
        // Hide after 3 seconds
        setTimeout(() => {
            infoPanel.classList.remove('show');
        }, 3000);
    }
    
    // Dispatch click event
    document.getElementById(mapId).dispatchEvent(new CustomEvent('map:click', {
        detail: { 
            mapId: mapId, 
            latLng: { lat: event.latLng.lat(), lng: event.latLng.lng() },
            event: event
        }
    }));
}

// Map control functions
window.toggleMapType = function(mapId) {
    const data = window.mapData[mapId];
    if (!data || !data.map) return;
    
    const types = ['roadmap', 'satellite', 'hybrid', 'terrain'];
    const currentIndex = types.indexOf(data.currentMapType);
    const nextIndex = (currentIndex + 1) % types.length;
    const nextType = types[nextIndex];
    
    data.map.setMapTypeId(nextType);
    data.currentMapType = nextType;
};

window.centerMap = function(mapId) {
    const data = window.mapData[mapId];
    if (!data || !data.map) return;
    
    data.map.setCenter({ lat: {{ $centerLat }}, lng: {{ $centerLng }} });
    data.map.setZoom({{ $zoom }});
};

window.toggleTraffic = function(mapId) {
    const data = window.mapData[mapId];
    if (!data || !data.map) return;
    
    if (data.trafficLayer) {
        data.trafficLayer.setMap(null);
        data.trafficLayer = null;
    } else {
        data.trafficLayer = new google.maps.TrafficLayer();
        data.trafficLayer.setMap(data.map);
    }
};

window.retryMapLoad = function(mapId) {
    const errorElement = document.getElementById(mapId + '-error');
    const loadingElement = document.getElementById(mapId + '-loading');
    
    errorElement.classList.remove('show');
    loadingElement.classList.remove('hidden');
    
    // Retry loading
    setTimeout(() => {
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            loadGoogleMaps(() => initializeMap(mapId, mapConfig, markers));
        } else {
            initializeMap(mapId, mapConfig, markers);
        }
    }, 1000);
};

function showMapError(mapId, message) {
    const loadingElement = document.getElementById(mapId + '-loading');
    const errorElement = document.getElementById(mapId + '-error');
    
    loadingElement.classList.add('hidden');
    errorElement.classList.add('show');
    
    if (message) {
        errorElement.querySelector('small').textContent = message;
    }
}

// Global map utility functions
window.MapUtils = {
    // Add marker to existing map
    addMarker: function(mapId, markerData) {
        const data = window.mapData[mapId];
        if (!data || !data.map) return null;
        
        const marker = new google.maps.Marker({
            position: { lat: markerData.lat, lng: markerData.lng },
            map: data.map,
            title: markerData.title || 'New Marker',
            icon: markerData.icon || null
        });
        
        data.markers.push(marker);
        return marker;
    },
    
    // Remove all markers
    clearMarkers: function(mapId) {
        const data = window.mapData[mapId];
        if (!data) return;
        
        data.markers.forEach(marker => marker.setMap(null));
        data.markers = [];
        
        if (data.markerCluster) {
            data.markerCluster.clearMarkers();
        }
    },
    
    // Fit map to show all markers
    fitBounds: function(mapId) {
        const data = window.mapData[mapId];
        if (!data || !data.markers.length) return;
        
        const bounds = new google.maps.LatLngBounds();
        data.markers.forEach(marker => bounds.extend(marker.getPosition()));
        data.map.fitBounds(bounds);
    },
    
    // Get map instance
    getMap: function(mapId) {
        return window.mapData[mapId]?.map || null;
    }
};
</script>

{{-- 
Usage Examples:

Basic Map:
@include('components.map', [
    'latitude' => 40.7128,
    'longitude' => -74.0060,
    'zoom' => 13,
    'height' => '400px'
])

Map with Markers:
@include('components.map', [
    'latitude' => 40.7128,
    'longitude' => -74.0060,
    'markers' => [
        [
            'lat' => 40.7128,
            'lng' => -74.0060,
            'title' => 'New York City',
            'info' => [
                'title' => 'NYC Office',
                'description' => 'Our main office location',
                'address' => '123 Main St, New York, NY',
                'phone' => '+1 (555) 123-4567'
            ]
        ],
        [
            'lat' => 40.7589,
            'lng' => -73.9851,
            'title' => 'Central Park',
            'info' => 'Beautiful park in Manhattan'
        ]
    ],
    'theme' => 'dark',
    'clustering' => true
])

Interactive Map with Custom Controls:
@include('components.map', [
    'center' => ['lat' => 37.7749, 'lng' => -122.4194],
    'zoom' => 12,
    'mapType' => 'hybrid',
    'height' => '500px',
    'controls' => true,
    'clickable' => true,
    'apiKey' => config('services.google_maps.key')
])
--}}
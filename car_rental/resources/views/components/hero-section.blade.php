<!-- Hero Section Component -->
<section id="section-hero" aria-label="section" class="jarallax">
    <img src="{{ asset('images/background/1.jpg') }}" class="jarallax-img" alt="">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 text-light">
                <div class="spacer-double"></div>
                <div class="spacer-double"></div>
                <h1 class="mb-2">{{ $title ?? 'Looking for a' }} <span class="id-color">{{ $highlight ?? 'vehicle' }}</span>{{ $subtitle ?? "? You're at the right place." }}</h1>
                <div class="spacer-single"></div>
            </div>

            <div class="col-lg-12">
                <div class="spacer-single sm-hide"></div>
                <div class="p-4 rounded-3 shadow-soft" data-bgcolor="#ffffff">
                    <!-- Include Car Search Form Component -->
                    <x-car-search-form />
                </div>
            </div>

            <div class="spacer-double"></div>

            <div class="row">
                <div class="col-lg-12 text-light">
                    <div class="container-timeline">
                        <ul>
                            <li class="timeline-step">
                                <i class="fa fa-car bg-color"></i>
                                <h4>Choose A Car</h4>
                                <p>View our range of cars, find your perfect car for the coming days.</p>
                            </li>
                            <li class="timeline-step">
                                <i class="fa fa-calendar bg-color"></i>
                                <h4>Pick Dates & Times</h4>
                                <p>Pick your preferred dates and times, and we'll prepare the car for you.</p>
                            </li>
                            <li class="timeline-step">
                                <i class="fa fa-road bg-color"></i>
                                <h4>Book & Enjoy</h4>
                                <p>Book the car and enjoy your trip, it's that simple to travel with us.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
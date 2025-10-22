<!-- Hero Section Component -->
<section id="section-hero" aria-label="section" class="jarallax vh-100" style="min-height: 600px;">
    <img src="{{ asset('images/background/1.jpg') }}" class="jarallax-img" alt="">
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-lg-8 col-xl-7 text-light">
                <div class="hero-content text-center text-lg-start" style="padding: 40px 0;">
                    <h1 class="display-3 fw-bold mb-4" style="line-height: 1.2;">
                        We are the <span class="id-color">largest</span><br>
                        leading commercial<br>
                        and luxury cars<br>
                        rental.
                    </h1>
                    <p class="lead mb-4 mx-auto mx-lg-0" style="font-size: 1.1rem; max-width: 600px; opacity: 0.95;">
                        Embark on unforgettable adventures and discover the world in unparalleled comfort and style with our fleet of exceptionally comfortable cars.
                    </p>
                    <button onclick="smoothScroll()" class="btn btn-primary px-4 py-2" style="background: #8bc34a; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem;">
                        Explore
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section Responsive Styles */
#section-hero {
    position: relative;
    display: flex;
    align-items: center;
}

#section-hero h1 {
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

#section-hero .lead {
    font-size: 1.15rem;
    line-height: 1.7;
}

/* Tablet and below */
@media (max-width: 991px) {
    #section-hero h1 {
        font-size: 2.5rem;
    }
    
    #section-hero .lead {
        font-size: 1rem;
    }
    
    #section-hero .hero-content {
        padding: 30px 0 !important;
    }
    
    #section-hero {
        min-height: 500px !important;
    }
}

/* Mobile */
@media (max-width: 767px) {
    #section-hero h1 {
        font-size: 2rem;
    }
    
    #section-hero .lead {
        font-size: 0.95rem;
    }
    
    #section-hero .btn-lg {
        font-size: 1rem !important;
        padding: 0.75rem 2rem !important;
    }
    
    #section-hero {
        min-height: 450px !important;
    }
    
    #section-hero .hero-content {
        padding: 20px 0 !important;
    }
}

/* Small mobile */
@media (max-width: 575px) {
    #section-hero h1 {
        font-size: 1.75rem;
    }
    
    #section-hero .lead {
        font-size: 0.9rem;
        margin-bottom: 1.5rem !important;
    }
}
</style>

<script>
function smoothScroll() {
    // Scroll down to show more content (approximately one viewport height)
    const scrollTarget = window.innerHeight * 0.85;
    window.scrollTo({
        top: scrollTarget,
        behavior: 'smooth'
    });
}
</script>
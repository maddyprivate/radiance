@extends('layouts.frontend')

@section('content')
    <section class="hero-section">
        <div class="hero-slider owl-carousel">
            <div class="hero-item set-bg" data-setbg="{{ asset('fw/img/hero-slider/1')}}.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8">
                            <h2><span>Lets Bring Earth</span><span>Back to</span><span>Its</span></h2>
                            <a href="#" class="site-btn sb-white mr-4 mb-3">Read More</a>
                            <a href="#" class="site-btn sb-dark">our Services</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-item set-bg" data-setbg="{{ asset('fw/img/hero-slider/2')}}.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8">
                            <h2><span>Natural</span><span>Glory</span><span>By using LPG</span></h2>
                            <a href="#" class="site-btn sb-white mr-4 mb-3">Read More</a>
                            <a href="#" class="site-btn sb-dark">our Services</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero section end  -->

    <!-- Services section  -->
    <section class="services-section">
        <div class="services-warp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/cogwheel.png')}}" alt="">
                                </div>
                                <h5>Mechanical Engineering</h5>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/helmet.png')}}" alt="">
                                </div>
                                <h5>Profesional Workers</h5>
                            </div>
                            <p>Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/wind-engine')}}.png" alt="">
                                </div>
                                <h5>Green Energy</h5>
                            </div>
                            <p>Sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec con-sequat arcu et commodo interdum. </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/pollution.png')}}" alt="">
                                </div>
                                <h5>Power Engineering</h5>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/pumpjack.png')}}" alt="">
                                </div>
                                <h5>Oil & Lubricants</h5>
                            </div>
                            <p>Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="service-item">
                            <div class="si-head">
                                <div class="si-icon">
                                    <img src="{{ asset('fw/img/icons/light-bulb')}}.png" alt="">
                                </div>
                                <h5>Power & Energy</h5>
                            </div>
                            <p>Sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec con-sequat arcu et commodo interdum. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Services section end  -->

    <!-- Features section   -->
    <section class="features-section spad set-bg" data-setbg="{{ asset('fw/img/features-bg.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box">
                        <img src="{{ asset('fw/img/features/1.jpg')}}" alt="">
                        <div class="fb-text">
                            <h5>Chemichal Reserach</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi-scing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. </p>
                            <a href="" class="fb-more-btn">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box">
                        <img src="{{ asset('fw/img/features/2.jpg')}}" alt="">
                        <div class="fb-text">
                            <h5>Engineering</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi-scing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. </p>
                            <a href="" class="fb-more-btn">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="feature-box">
                        <img src="{{ asset('fw/img/features/3.jpg')}}" alt="">
                        <div class="fb-text">
                            <h5>Manufactoring</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipi-scing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. </p>
                            <a href="" class="fb-more-btn">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Features section end  -->


    <!-- Clients section  -->
    <section class="clients-section spad">
        <div class="container">
            <div class="client-text">
                <h2>A group of productive enterprises that produce or supply Goods, Services, or Sources of Income</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
            </div>
            <div id="client-carousel" class="client-slider owl-carousel">
                <div class="single-brand">
                    <a href="#">
                        <img src="{{ asset('fw/img/clients/1.png')}}" alt="">
                    </a>
                </div>
                <div class="single-brand">
                    <a href="#">
                        <img src="{{ asset('fw/img/clients/2.png')}}" alt="">
                    </a>
                </div>
                <div class="single-brand">
                    <a href="#">
                        <img src="{{ asset('fw/img/clients/3.png')}}" alt="">
                    </a>
                </div>
                <div class="single-brand">
                    <a href="#">
                        <img src="{{ asset('fw/img/clients/4.png')}}" alt="">
                    </a>
                </div>
                <div class="single-brand">
                    <a href="#">
                        <img src="{{ asset('fw/img/clients/5.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- Clients section end  -->


    <!-- Testimonial section -->
    <section class="testimonial-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="testimonial-bg set-bg" data-setbg="{{ asset('fw/img/testimonial-bg.jpg')}}"></div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="testimonial-box">
                        <div class="testi-box-warp">
                            <h2>Client’s Testimonials</h2>
                            <div class="testimonial-slider owl-carousel">
                                <div class="testimonial">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consecte-tur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
                                    <img src="{{ asset('fw/img/testimonial-thumb.jpg')}}" alt="" class="testi-thumb">
                                    <div class="testi-info">
                                        <h5>Michael Smith</h5>
                                        <span>CEO Industrial INC</span>
                                    </div>
                                </div>
                                <div class="testimonial">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consecte-tur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
                                    <img src="{{ asset('fw/img/testimonial-thumb.jpg')}}" alt="" class="testi-thumb">
                                    <div class="testi-info">
                                        <h5>Michael Smith</h5>
                                        <span>CEO Industrial INC</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial section end  -->


    <!-- Call to action section  -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 d-flex align-items-center">
                    <h2>We provide solution for all LPG related problems aries in market</h2>
                </div>
                <div class="col-lg-3 text-lg-right" >
                    <a href="#" class="site-btn sb-dark">contact us</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to action section end  -->

    <!-- Video section  -->
    <section class="video-section spad" >
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="video-text">
                        <h2>We produce or supply Goods, & Services</h2>
                        <p>RPPL is the first LPG company in India to come up with Cylinder Accounting & Tracking Software(CATS). Safety Audit, Safety Maintenance and Safety training to be priority. With CATS software , we can track each and every cylinder movement with which maximum problems are solved. Orders will be placed through our application. Company will decide pricing and highlight on cylinders, shops. Poor People will having options to buy 2kg, 4kg, 8kg, cylinders. RPPL will have solutions like Portable Vaporizer's to Restaurants by 33kg LOT cylinders. Reticulated Pipeline systems to Complexes with 15kg, 17kg and 21kg cylinder options. And FOC cylinders to hardworking dealers.
</p>
                        <a href="#" class="site-btn">contact us</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="video-box set-bg" data-setbg="{{ asset('fw/img/video-box.jpg')}}">
                        <a href="https://www.youtube.com/watch?v=wbnaHgSttVo" class="video-popup">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video section end  -->

@endsection

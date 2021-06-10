@extends('layouts.frontend')

@section('content')
    <!-- Page top section  -->
    <section class="page-top-section set-bg" data-setbg="{{ asset('fw/img/page-top-bg/1.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <h2>About us</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. </p>
                    <a href="" class="site-btn">Contact us</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Page top section end  -->


    <!-- About section -->
    <section class="about-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <img src="{{ asset('fw/img/about.jpg')}}" alt="">
                </div>
                <div class="col-lg-6">
                    <div class="about-text">
                        <h2>We produce or supply Goods, & Services</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. </p>
                        <div class="about-sign">
                            <div class="sign">
                                <img src="{{ asset('fw/img/sign.png')}}" alt="">
                            </div>
                            <div class="sign-info">
                                <h5>Michael Smith</h5>
                                <span>CEO Industrial INC</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About section end -->

    <!-- Milestones section -->
    <section class="milestones-section set-bg" data-setbg="{{ asset('fw/img/milestones-bg.jpg')}}">
        <div class="container text-white">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone">
                        <div class="milestone-icon">
                            <img src="{{ asset('fw/img/icons/plug.png')}}" alt="">
                        </div>
                        <div class="milestone-text">
                            <span>Clients</span>
                            <h2>725</h2>
                            <p>Nam ornare ipsum </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone">
                        <div class="milestone-icon">
                            <img src="{{ asset('fw/img/icons/light.png')}}" alt="">
                        </div>
                        <div class="milestone-text">
                            <span>Growth</span>
                            <h2>45%</h2>
                            <p>Nam ornare ipsum </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone">
                        <div class="milestone-icon">
                            <img src="{{ asset('fw/img/icons/traffic-cone.png')}}" alt="">
                        </div>
                        <div class="milestone-text">
                            <span>Projects</span>
                            <h2>59</h2>
                            <p>Nam ornare ipsum </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="milestone">
                        <div class="milestone-icon">
                            <img src="{{ asset('fw/img/icons/worker.png')}}" alt="">
                        </div>
                        <div class="milestone-text">
                            <span>Emploees</span>
                            <h2>138</h2>
                            <p>Nam ornare ipsum </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Milestones section end -->

    <!-- Team section -->
    <section class="team-section spad">
        <div class="container">
            <div class="team-text">
                <h2>Our Amazing Team</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est. Nam ornare ipsum ac accumsan auctor. Donec consequat arcu et commodo interdum. Vivamus posuere lorem lacus.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque orci purus, sodales in est quis, blandit sollicitudin est.</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('fw/img/team/1.jpg')}}" alt="">
                        <div class="member-info">
                            <h3>Michael Smith</h3>
                            <p>Engeneer Chemist </p>
                            <a href="#" class="site-btn">See C.V.</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('fw/img/team/2.jpg')}}" alt="">
                        <div class="member-info">
                            <h3>Jessica Steing</h3>
                            <p>Engeneer Chemist </p>
                            <a href="#" class="site-btn">See C.V.</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('fw/img/team/3.jpg')}}" alt="">
                        <div class="member-info">
                            <h3>Chris Williams</h3>
                            <p>Engeneer Chemist </p>
                            <a href="#" class="site-btn">See C.V.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team section end -->

    <!-- Call to action section  -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 d-flex align-items-center">
                    <h2>We produce or supply Goods, Services, or Sources</h2>
                </div>
                <div class="col-lg-3 text-lg-right" >
                    <a href="#" class="site-btn sb-dark">contact us</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Call to action section end  -->
@endsection

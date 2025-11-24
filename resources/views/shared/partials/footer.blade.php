<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap -mx-5">
            <div class="w-full sm:w-1/2 lg:w-1/3 px-5">
                <img src="{{ config('r2.endpoint') }}/images/logo.png" alt="DB Dental Care Logo" class="logo-footer">
                <div class="spacer-20"></div>
                <p>We provides quality and affordable dental services for patients of all ages. With a team of skilled dentists and modern equipment, the clinic offers comprehensive oral care—from routine check-ups and cleanings to advanced restorative and cosmetic treatments—ensuring every patient leaves with a healthy and confident smile.</p>

                <div class="social-icons mb-sm-30">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="w-full sm:w-full lg:w-1/3 order-2 lg:order-1">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full sm:w-1/2 lg:w-1/2 px-4">
                        <div class="widget">
                            <h5>Links</h5>
                            <ul>                                        
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('services') }}">Services</a></li>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 lg:w-1/2 px-4">
                        <div class="widget">
                            <h5>Our Services</h5>
                            <ul>
                                <li><a href="service-general-dentistry.html">General Dentistry</a></li>
                                <li><a href="service-cosmetic-dentistry.html">Cosmetic Dentistry</a></li>
                                <li><a href="service-pediatric-dentistry.html">Pediatric Dentistry</a></li>
                                <li><a href="service-restorative-dentistry.html">Restorative Dentistry</a></li>
                                <li><a href="service-preventive-dentistry.html">Preventive Dentistry</a></li>
                                <li><a href="service-orthodontics.html">Orthodontics</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full sm:w-full lg:w-1/3 order-1 lg:order-2">
                <div class="widget">
                    <h5>Contact Us</h5>
                    <div class="fw-bold text-white"><i class="icofont-location-pin me-2 id-color"></i>Clinic Location</div>
                        Trece Martires City, Cavite, Philippines

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-white"><i class="icofont-phone me-2 id-color"></i>Call Us</div>
                    +63 9xx - xxx - xxxx

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-white"><i class="icofont-envelope me-2 id-color"></i>Send a Message</div>
                    <a href="#" class="__cf_email__">email@example.com</a>                            
                </div>
            </div>
        </div>
    </div>
    <div class="subfooter">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full">
                    <div class="flex items-center justify-between">
                        <div class="flex flex-col">
                            Copyright 2025
                        </div>
                        <ul class="menu-simple">
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
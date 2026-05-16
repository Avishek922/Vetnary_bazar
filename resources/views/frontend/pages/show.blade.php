<x-app-layout>
    <div class="bg-primary-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold text-gray-900 font-sans tracking-tight">{{ $page->title }}</h1>
            <nav class="flex mt-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600">
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $page->title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($page->slug == 'about-us')
                {{-- About Us Page with Images --}}
                <div class="space-y-16">
                    {{-- Our Mission Section --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div class="p-4">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Mission</h2>
                            <p class="text-gray-600 leading-relaxed text-lg">At Veterinary Bazzar, we are dedicated to providing the highest quality veterinary supplies and pet care products to ensure the health and happiness of your beloved companions. Our mission is to bridge the gap between premium care and accessibility, making top-tier veterinary products available to everyone.</p>
                        </div>
                        <div class="p-4">
                            <img src="{{ asset('images/about/vet-clinic-care.png') }}" alt="Veterinary Care" class="rounded-xl shadow-2xl w-full h-auto transform hover:scale-105 transition duration-500">
                        </div>
                    </div>

                    {{-- Our Story Section --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div class="order-2 md:order-1 p-4">
                            <img src="{{ asset('images/about/vet-team.png') }}" alt="Our Team" class="rounded-xl shadow-2xl w-full h-auto transform hover:scale-105 transition duration-500">
                        </div>
                        <div class="order-1 md:order-2 p-4">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                            <p class="text-gray-600 leading-relaxed text-lg">Founded by a team of passionate veterinary professionals and pet lovers, Veterinary Bazzar started as a small local clinic supply store. Today, we have grown into a comprehensive online marketplace, serving thousands of veterinarians and pet owners across the country.</p>
                        </div>
                    </div>

                    {{-- Location Section for About Us --}}
                    <div class="mt-20 pt-10 border-t border-gray-100">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Visit Our Store</h2>
                            <p class="mt-4 text-lg text-gray-600">Located in the heart of Parsa, we're here to serve you and your pets.</p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                            <div class="bg-primary-50 p-8 rounded-2xl shadow-sm border border-primary-100 h-full">
                                <h3 class="text-xl font-bold text-primary-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Main HQ
                                </h3>
                                <div class="space-y-4 text-gray-700">
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Address:</span>
                                        <span>Birgunj 17, Nepal<br>Veterinary Shop,Allau Chowk</span>
                                    </p>
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Delivery Hours:</span>
                                        <span>Sun - Fri: 10:00 AM - 6:00 PM<br>Sat: Closed</span>
                                    </p>
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Phone:</span>
                                        <span>+977-9700023669<br>+977-9815230018</span>
                                    </p>
                                    
                                    {{-- Social Media Links --}}
                                    <div class="pt-6 border-t border-gray-100">
                                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Follow Us</h4>
                                        <div class="flex space-x-4">
                                            <a href="#" class="text-gray-400 hover:text-blue-600 transition" aria-label="Facebook">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-pink-600 transition" aria-label="Instagram">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.9c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Twitter">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-blue-700 transition" aria-label="LinkedIn">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-pink-500 transition" aria-label="TikTok">
                                                 <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-2 overflow-hidden rounded-2xl shadow-lg border border-gray-100 h-[350px]">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.5799830566383!2d84.84137120743401!3d27.026856445886498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399357f236a4eed1%3A0xa1b1a61193800a1c!2sAlau%20Bazar!5e1!3m2!1sen!2snp!4v1768410141212!5m2!1sen!2snp" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(in_array($page->slug, ['contact-us', 'contact']))
                {{-- Contact Us Page with Form and Mapping --}}
                <div class="space-y-20">
                    <div class="max-w-4xl mx-auto prose prose-primary prose-lg text-gray-600">
                        @php
                            $content = $page->content;
                            
                            // Define the new form HTML to replace the placeholder
                            // We use PHP string concatenation here because we are building a string variable.
                            $formHtml = '
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 shadow-sm h-full">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                                <p class="text-gray-500 text-sm mb-6">We usually respond within 24 hours.</p>
                                
                                <form action="' . route('contact.query.store') . '" method="POST" class="space-y-4">
                                    ' . csrf_field() . '
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="John Doe">
                                    </div>
                                    
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                                            <input type="email" name="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="john@example.com">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input type="tel" name="phone" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="+977-98XXXXXXXX">
                                        </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Your Message</label>
                                        <textarea name="message" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm resize-none" placeholder="How can we help?"></textarea>
                                    </div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition">
                                        Send Message
                                    </button>
                                </form>
                            </div>';

                            // Replace the specific form container from the database content with the new form
                            $pattern = '/<div class="bg-gray-50 p-6 rounded-xl border border-gray-200">.*?<\/form>\s*<\/div>/s';
                            $content = preg_replace($pattern, $formHtml, $content);
                        @endphp
                        
                        {{-- Render the content --}}
                        {!! $content !!}
                    </div>

                    <div class="mt-8 pt-10 border-t border-gray-100">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Connect with Us</h2>
                            <p class="mt-4 text-lg text-gray-600">Located in the heart of Birgunj, we're here to serve you and your pets.</p>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                            <div class="bg-primary-50 p-8 rounded-2xl shadow-sm border border-primary-100 h-full">
                                <h3 class="text-xl font-bold text-primary-900 mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Contact Details
                                </h3>
                                <div class="space-y-4 text-gray-700">
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Address:</span>
                                        <span>Birgunj 17, Nepal<br>Veterinary Shop,Allau Chowk</span>
                                    </p>
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Email:</span>
                                        <span>vetbazzar720@gmail.com</span>
                                    </p>
                                    <p class="flex items-start">
                                        <span class="font-semibold w-24">Phone:</span>
                                        <span>+977-9700023669<br>+977-9815230018</span>
                                    </p>


                                    {{-- Social Media Links --}}
                                    <div class="pt-6 border-t border-gray-100">
                                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Follow Us</h4>
                                        <div class="flex space-x-4">
                                            <a href="#" class="text-gray-400 hover:text-blue-600 transition" aria-label="Facebook">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-pink-600 transition" aria-label="Instagram">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.9c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-blue-400 transition" aria-label="Twitter">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-blue-700 transition" aria-label="LinkedIn">
                                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                            </a>
                                            <a href="#" class="text-gray-400 hover:text-pink-500 transition" aria-label="TikTok">
                                                 <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-span-2 overflow-hidden rounded-2xl shadow-lg border border-gray-100 h-[350px]">
                                <iframe 
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.5799830566383!2d84.84137120743401!3d27.026856445886498!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399357f236a4eed1%3A0xa1b1a61193800a1c!2sAlau%20Bazar!5e1!3m2!1sen!2snp!4v1768410141212!5m2!1sen!2snp" 
                                    width="100%" 
                                    height="100%" 
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Other Pages --}}
                <div class="max-w-4xl mx-auto prose prose-primary prose-lg text-gray-600">
                    {!! $page->content !!}
                </div>
            @endif
        </div>
    </div>

    <!-- Need Help Section (Common for About/Contact) -->
    <div class="bg-gray-50 py-16 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Still have questions?</h2>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">Our veterinary support team is standing by to help you choose the right products for your pet.</p>
            <div class="flex justify-center gap-4">
                <a href="mailto:vetbazzar720@gmail.com" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition">
                    Email Support
                </a>
                <a href="tel:+977-9700023669" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 transition">
                    Call Us Now
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

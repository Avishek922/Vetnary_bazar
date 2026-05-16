<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Page::updateOrCreate(
            ['slug' => 'about-us'],
            [
                'title' => 'About Veterinary Bazaar',
                'content' => '
                    <div class="space-y-6">
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h2>
                            <p class="text-gray-600 leading-relaxed">At Veterinary Bazaar, we are dedicated to providing the highest quality veterinary supplies and pet care products to ensure the health and happiness of your beloved companions. Our mission is to bridge the gap between premium care and accessibility, making top-tier veterinary products available to everyone.</p>
                        </section>
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Story</h2>
                            <p class="text-gray-600 leading-relaxed">Founded by a team of passionate veterinary professionals and pet lovers, Veterinary Bazaar started as a small local clinic supply store. Today, we have grown into a comprehensive online marketplace, serving thousands of veterinarians and pet owners across the country.</p>
                        </section>
                        <section>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Why Choose Us?</h2>
                            <ul class="list-disc pl-6 space-y-2 text-gray-600">
                                <li><strong>Expertly Curated:</strong> Every product in our store is selected by veterinary experts.</li>
                                <li><strong>Quality Guaranteed:</strong> we only partner with trusted brands and reputable suppliers.</li>
                                <li><strong>Fast Delivery:</strong> We understand that pet health cannot wait, so we prioritize speedy shipping.</li>
                                <li><strong>Dedicated Support:</strong> Our team is always here to help you find the right supplies for your specific needs.</li>
                            </ul>
                        </section>
                    </div>
                ',
                'is_active' => true,
            ]
        );

        \App\Models\Page::updateOrCreate(
            ['slug' => 'contact-us'],
            [
                'title' => 'Contact Us',
                'content' => '
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Get in Touch</h2>
                            <p class="text-gray-600 mb-6">Have questions or need assistance? We are here to help! Reach out to us through any of the following channels.</p>
                            
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-primary-100 rounded-lg">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Our Location</h3>
                                        <p class="text-gray-600">Kathmandu, Nepal<br>Veterinary Plaza, 5th Floor</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-primary-100 rounded-lg">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Email Address</h3>
                                        <p class="text-gray-600">vetbazzar720@gmail.com</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start gap-3">
                                    <div class="p-2 bg-primary-100 rounded-lg">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900">Phone Number</h3>
                                        <p class="text-gray-600">+977-9700023669<br>+977-9815230018</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                            <form class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="john@example.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="+977-1-4XXXXXX">
                                </div>  
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Message</label>
                                    <textarea rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm" placeholder="How can we help?"></textarea>
                                </div>
                                <button type="button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition">
                                    Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                ',
                'is_active' => true,
            ]
        );
    }
}

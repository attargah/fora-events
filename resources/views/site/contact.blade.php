@extends('site.layouts.app')

@section('title', 'Contact and Support | ForaEvents')

@section('content')
<div class="relative flex h-auto min-h-screen w-full flex-col">
    <main class="px-4 md:px-10 py-6">
        <div class="max-w-[1440px] mx-auto flex flex-col w-full">
            <!-- Page Heading -->
            <div class="flex flex-wrap justify-between gap-3 p-4">
                <div class="flex min-w-72 flex-col gap-3">
                    <p class="text-white text-4xl md:text-5xl font-black leading-tight tracking-[-0.033em]">How can we help?</p>
                    <p class="text-slate-400 text-lg font-normal leading-normal max-w-xl">Whether you have questions about your booking, need technical help, or just want to say hello, our team is here for you.</p>
                </div>
            </div>
            
            <!-- Contact Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-10 p-4">
                <!-- Left Column: Form -->
                <div class="flex flex-col gap-6 bg-slate-100 dark:bg-slate-800/50 p-8 rounded-xl border border-slate-200 dark:border-white/10">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Send us a message</h3>
                    <form action="{{ route('contact.store') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div class="flex flex-wrap gap-4">
                            <label class="flex flex-col flex-1 min-w-[200px]">
                                <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">First Name</p>
                                <input type="text" name="first_name" required class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-700 h-14 p-[15px] text-base font-normal leading-normal"/>
                            </label>
                            <label class="flex flex-col flex-1 min-w-[200px]">
                                <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">Last Name</p>
                                <input type="text" name="last_name" required class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-700 h-14 p-[15px] text-base font-normal leading-normal"/>
                            </label>
                        </div>
                        
                        <label class="flex flex-col w-full">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">Email</p>
                            <input type="email" name="email" required class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-700 h-14 p-[15px] text-base font-normal leading-normal"/>
                        </label>
                        
                        <label class="flex flex-col w-full">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">Subject</p>
                            <select name="subject" required class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-700 h-14 p-[15px] text-base font-normal leading-normal appearance-none cursor-pointer">
                                <option value="">Select a subject</option>
                                <option value="booking">Booking Issue</option>
                                <option value="payment">Payment Problem</option>
                                <option value="technical">Technical Support</option>
                                <option value="refund">Refund Request</option>
                                <option value="general">General Inquiry</option>
                                <option value="other">Other</option>
                            </select>
                        </label>
                        
                        <label class="flex flex-col w-full">
                            <p class="text-slate-900 dark:text-white text-sm font-medium leading-normal pb-2">Message</p>
                            <textarea name="message" required rows="6" placeholder="Tell us what's on your mind..." class="form-input flex w-full min-w-0 flex-1 rounded-lg text-slate-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-700 p-[15px] text-base font-normal leading-normal resize-none"></textarea>
                        </label>
                        
                        <button type="submit" class="flex w-full items-center justify-center rounded-lg h-14 bg-primary text-white text-base font-bold transition-all hover:bg-primary/90 active:scale-[0.98] mt-2">
                            Send Message
                        </button>
                    </form>
                </div>
                
                <!-- Right Column: Info & Socials -->
                <div class="flex flex-col gap-10">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Direct Contact</h3>
                        <div class="flex flex-col gap-6">
                            <div class="flex items-start gap-4 p-4 rounded-lg bg-slate-100 dark:bg-slate-800/30 border border-slate-200 dark:border-white/10">
                                <div class="text-primary mt-1">
                                    <span class="material-symbols-outlined text-2xl">phone</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white mb-1">Phone</p>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm">+1 (555) 123-4567</p>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs">Mon-Fri, 9am-6pm EST</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-4 rounded-lg bg-slate-100 dark:bg-slate-800/30 border border-slate-200 dark:border-white/10">
                                <div class="text-primary mt-1">
                                    <span class="material-symbols-outlined text-2xl">mail</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white mb-1">Email</p>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm">info@foraevents.com</p>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs">We'll respond within 24 hours</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-4 p-4 rounded-lg bg-slate-100 dark:bg-slate-800/30 border border-slate-200 dark:border-white/10">
                                <div class="text-primary mt-1">
                                    <span class="material-symbols-outlined text-2xl">location_on</span>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white mb-1">Address</p>
                                    <p class="text-slate-600 dark:text-slate-400 text-sm">123 Event Street, NY 10001</p>
                                    <p class="text-slate-500 dark:text-slate-400 text-xs">Visit us during business hours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Follow Us</h3>
                        <div class="flex gap-4">
                            <a class="size-12 rounded-full bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-white/10 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <span class="material-symbols-outlined">Phone_Enabled</span>
                            </a>
                            <a class="size-12 rounded-full bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-white/10 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <span class="material-symbols-outlined">language</span>
                            </a>
                            <a class="size-12 rounded-full bg-slate-200 dark:bg-slate-700 border border-slate-300 dark:border-white/10 flex items-center justify-center hover:bg-primary hover:text-white hover:border-primary transition-all" href="#">
                                <span class="material-symbols-outlined">mail</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Section -->
            <div class="mt-20 p-4 w-full">
                <div class="flex flex-col gap-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-black text-slate-900 dark:text-white">Frequently Asked Questions</h2>
                        <p class="text-slate-500 dark:text-slate-400 mt-2">Find quick answers to common questions about our platform.</p>
                    </div>
                    
                    <div class="flex flex-col gap-4 max-w-3xl mx-auto w-full">
                        <!-- FAQ Item 1 -->
                        <details class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 group">
                            <summary class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer list-none">
                                <span class="font-bold text-slate-900 dark:text-white">How do I purchase tickets?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-200 dark:border-white/10">
                                <p>Simply browse our events, select your preferred tickets, choose the quantity, and proceed to checkout. We accept all major credit cards and digital payment methods.</p>
                            </div>
                        </details>
                        
                        <!-- FAQ Item 2 -->
                        <details class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 group">
                            <summary class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer list-none">
                                <span class="font-bold text-slate-900 dark:text-white">Can I get a refund?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-200 dark:border-white/10">
                                <p>Refunds depend on the event's refund policy. Most events are non-refundable, but some allow cancellations up to 7 days before the event. Check the event details for specific terms.</p>
                            </div>
                        </details>
                        
                        <!-- FAQ Item 3 -->
                        <details class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 group">
                            <summary class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer list-none">
                                <span class="font-bold text-slate-900 dark:text-white">How will I receive my tickets?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-200 dark:border-white/10">
                                <p>Digital tickets are sent to your email immediately after purchase. You can also access them in your account dashboard. For physical tickets, they'll be delivered based on the method you choose at checkout.</p>
                            </div>
                        </details>
                        
                        <!-- FAQ Item 4 -->
                        <details class="rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 group">
                            <summary class="w-full flex items-center justify-between p-6 text-left hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors cursor-pointer list-none">
                                <span class="font-bold text-slate-900 dark:text-white">Is it safe to buy tickets on ForaEvents?</span>
                                <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-600 dark:text-slate-300 leading-relaxed border-t border-slate-200 dark:border-white/10">
                                <p>Absolutely! We use industry-standard SSL encryption and PCI-DSS compliance to protect your personal and payment information. Your security is our top priority.</p>
                            </div>
                        </details>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection

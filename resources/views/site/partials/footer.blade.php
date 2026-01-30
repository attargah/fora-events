<!-- Footer -->
<footer class="bg-slate-100 dark:bg-slate-900 border-t border-slate-200 dark:border-white/10 pt-16 pb-8">
    <div class="mx-auto max-w-[1440px] px-6 lg:px-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            <div class="space-y-6">
                <div class="flex items-center gap-2">
                    <div class="text-primary">
                        <img src="{{asset('/logo_light.png')}}" class="w-[250px] h-full" alt="">
                    </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Your ultimate destination for live event tickets. Experience the moments that matter.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">phone_enabled</span>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">language</span>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">mail</span>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6">Popular Categories</h4>
                <ul class="space-y-4 text-sm text-slate-500">
                    <li><a href="{{ route('events.index', ['category' => 'concerts']) }}" class="hover:text-primary transition-colors">Concerts</a></li>
                    <li><a href="{{ route('events.index', ['category' => 'sports']) }}" class="hover:text-primary transition-colors">Sports</a></li>
                    <li><a href="{{ route('events.index', ['category' => 'theater']) }}" class="hover:text-primary transition-colors">Theater</a></li>
                    <li><a href="{{ route('events.index') }}" class="hover:text-primary transition-colors">All Events</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6">Support</h4>
                <ul class="space-y-4 text-sm text-slate-500">
                    <li><a href="{{ route('contact.index') }}" class="hover:text-primary transition-colors">Contact Us</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Help & FAQ</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-primary transition-colors">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="space-y-6">
                <h4 class="font-bold">Join our Newsletter</h4>
                <p class="text-slate-500 text-sm">Get the latest event news and exclusive presale codes.</p>
                <form action="{{ route('newsletter.store') }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <input type="email" name="email" required placeholder="Enter your email" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-primary"/>
                    <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 rounded-lg transition-colors">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="border-t border-slate-200 dark:border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 font-medium">
            <p>© 2026 ForaEvents Global Ltd. All rights reserved.</p>
            <div class="flex gap-6">
                <span>Made with ❤️ for live fans everywhere.</span>
            </div>
        </div>
    </div>
</footer>

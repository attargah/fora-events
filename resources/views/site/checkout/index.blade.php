@extends('site.layouts.app')

@section('title', 'Checkout - ForaEvents')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-12 gap-y-12">
        
        <!-- CHECKOUT FORM -->
        <div class="lg:col-span-7">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-8">Checkout</h1>
            
            <form action="{{ route('checkout.store', ['hash' => $checkout->hash]) }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Contact Info -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-white/10">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Contact Information</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Full Name</label>
                            <input type="text" name="name" id="name" required
                                class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                placeholder="John Doe" value="{{ old('name', $checkout->name) }}">
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    placeholder="john@example.com" value="{{ old('email', $checkout->email_address) }}">
                                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Phone Number</label>
                                <input type="tel" name="phone" id="phone" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    placeholder="+1 234 567 8900" value="{{ old('phone', $checkout->phone_number) }}">
                                @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendee Information -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-white/10">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Attendee Information</h2>

                    <div class="space-y-6">
                        @for($i = 0; $i < $checkout->quantity; $i++)
                            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-600">
                                <h3 class="text-md font-medium text-slate-900 dark:text-white mb-3">Attendee #{{ $i + 1 }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="attendee_{{ $i }}_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Name</label>
                                        <input type="text" name="attendees[{{ $i }}][name]" id="attendee_{{ $i }}_name" required
                                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                               placeholder="Name" value="{{ old('attendees.'.$i.'.name') }}">
                                        @error('attendees.'.$i.'.name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="attendee_{{ $i }}_email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email</label>
                                        <input type="email" name="attendees[{{ $i }}][email]" id="attendee_{{ $i }}_email" required
                                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                               placeholder="Email" value="{{ old('attendees.'.$i.'.email') }}">
                                        @error('attendees.'.$i.'.email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label for="attendee_{{ $i }}_phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Phone</label>
                                        <input type="tel" name="attendees[{{ $i }}][phone]" id="attendee_{{ $i }}_phone" required
                                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                               placeholder="Phone" value="{{ old('attendees.'.$i.'.phone') }}">
                                        @error('attendees.'.$i.'.phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white dark:bg-slate-800 p-6 rounded-xl shadow-sm border border-slate-200 dark:border-white/10">
                    <h2 class="text-xl font-semibold text-slate-900 dark:text-white mb-4">Billing Address</h2>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="country" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Country</label>
                                <input type="text" name="country" id="country" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    placeholder="United States" value="{{ old('country', $checkout->country) }}">
                                @error('country') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">City</label>
                                <input type="text" name="city" id="city" required
                                    class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                    placeholder="New York" value="{{ old('city', $checkout->city) }}">
                                @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">State / Province</label>
                            <input type="text" name="state" id="state" required
                                class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                placeholder="NY" value="{{ old('state', $checkout->state) }}">
                            @error('state') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Address</label>
                            <textarea name="address" id="address" rows="3" required
                                class="w-full rounded-lg border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-primary focus:border-primary"
                                placeholder="123 Main St, Apt 4B">{{ old('address', $checkout->address) }}</textarea>
                            @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:-translate-y-0.5"
                >
                    Complete Order
                </button>
            </form>
        </div>

        <!-- ORDER SUMMARY -->
        <div class="lg:col-span-5">
            <div class="sticky top-24 bg-white dark:bg-slate-800 rounded-xl p-6 shadow-lg border border-slate-200 dark:border-white/10">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Order Summary</h2>

                <div class="flex gap-4 mb-6">
                    <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden bg-slate-100">
                        <img src="{{ $checkout->event->getBanner() }}" alt="{{ $checkout->event->title }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 dark:text-white line-clamp-2">{{ $checkout->event->title }}</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ $checkout->event->start_date?->format('F d, Y • H:i') }}
                        </p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                             {{ $checkout->event->city }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-slate-200 dark:border-white/10 py-4 space-y-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $checkout->ticket->name }}</p>
                            <p class="text-xs text-slate-500">Qty: {{ $checkout->quantity }}</p>
                        </div>
                        <p class="font-medium text-slate-900 dark:text-white">
                            ${{ number_format($checkout->total, 2) }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-slate-200 dark:border-white/10 pt-4 mt-2">
                    <div class="flex justify-between items-center text-lg font-bold text-slate-900 dark:text-white">
                        <span>Total</span>
                        <span>${{ number_format($checkout->total, 2) }}</span>
                    </div>
                </div>
                
                <div class="mt-6 bg-slate-50 dark:bg-slate-700/50 p-4 rounded-lg text-xs text-slate-500 dark:text-slate-400 text-center">
                    By proceeding, you agree to our <a href="#" class="underline hover:text-primary">Terms of Service</a> and <a href="#" class="underline hover:text-primary">Privacy Policy</a>.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

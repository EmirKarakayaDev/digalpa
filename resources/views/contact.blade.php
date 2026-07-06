<x-layouts.app title="İletişim — Digalpa">

    <x-breadcrumb :items="['İletişim' => null]" />

    <div class="container-content py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

            {{-- Sol: Form --}}
            <div>
                <div class="label-caps mb-3">Bize Ulaşın</div>
                <h1 class="text-4xl mb-8">İletişim</h1>

                @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded text-green-800 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Ad Soyad <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" required
                                   value="{{ old('full_name') }}"
                                   class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors @error('full_name') border-red-400 @enderror">
                            @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                E-posta <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                   value="{{ old('email') }}"
                                   class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Telefon</label>
                            <input type="tel" name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Firma</label>
                            <input type="text" name="company"
                                   value="{{ old('company') }}"
                                   class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Konu <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="subject" required
                               value="{{ old('subject') }}"
                               class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors @error('subject') border-red-400 @enderror">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">
                            Mesaj <span class="text-red-500">*</span>
                        </label>
                        <textarea name="message" rows="6" required
                                  class="w-full border border-gray-200 rounded px-3 py-2.5 text-sm focus:outline-none focus:border-navy transition-colors resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full justify-center">
                        Mesajı Gönder
                    </button>
                </form>
            </div>

            {{-- Sağ: İletişim Bilgileri --}}
            <div>
                <div class="label-caps mb-3">Bilgiler</div>
                <h2 class="text-3xl mb-8">Nerede<br><em>Bulunuyoruz?</em></h2>

                <div class="space-y-6 text-sm text-gray-700">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-navy-10 rounded flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-navy mb-1">Adres</div>
                            <p class="text-gray-600 leading-relaxed">İstanbul, Türkiye</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-navy-10 rounded flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-medium text-navy mb-1">E-posta</div>
                            <a href="mailto:info@digalpa.com" class="text-navy-60 hover:text-navy transition-colors">
                                info@digalpa.com
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Harita placeholder --}}
                <div class="mt-10 aspect-video bg-gray-100 rounded-sm flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Harita</span>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app>

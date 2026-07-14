<div id="doc-request-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-title">

    {{-- Arka plan --}}
    <div id="modal-backdrop" class="absolute inset-0 bg-navy/60 backdrop-blur-sm"></div>

    {{-- Panel --}}
    <div class="relative bg-white rounded-sm shadow-2xl w-full max-w-lg">

        {{-- Başlık --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 id="modal-title" class="text-lg font-medium text-navy">Teknik Doküman Talebi</h3>
            <button id="modal-close" class="text-gray-400 hover:text-gray-600 transition-colors" aria-label="Kapat">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Başarı mesajı --}}
        @if (session('document_request_success'))
        <div class="m-6 p-4 bg-green-50 border border-green-200 rounded text-green-800 text-sm">
            {{ session('document_request_success') }}
        </div>
        @else

        {{-- Form --}}
        <form action="{{ route('document-request.store') }}" method="POST" class="px-6 pb-6 pt-4 space-y-4">
            @csrf

            <input type="hidden" name="product_id" id="modal-product-id">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Ürün Adı</label>
                <input type="text" name="product_name" id="modal-product-name"
                       class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors"
                       value="{{ old('product_name') }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Ad Soyad <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" required
                           class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors"
                           value="{{ old('full_name') }}">
                    @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">E-posta <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required
                           class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors"
                           value="{{ old('email') }}">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Telefon <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" required
                           class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors"
                           value="{{ old('phone') }}">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Firma <span class="text-red-500">*</span></label>
                    <input type="text" name="company" required
                           class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors"
                           value="{{ old('company') }}">
                    @error('company')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-2">Doküman Türü <span class="text-red-500">*</span> <span class="text-gray-400 font-normal">(birden fazla seçilebilir)</span></label>
                    <div class="flex flex-col gap-2" id="modal-doc-types">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="document_type[]" value="tds" class="accent-navy" data-doc-type="tds">
                            <span class="text-sm">TDS (Teknik Veri)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="document_type[]" value="sds" class="accent-navy" data-doc-type="sds">
                            <span class="text-sm">SDS (Güvenlik)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="document_type[]" value="ce" class="accent-navy" data-doc-type="ce">
                            <span class="text-sm">CE (Uygunluk)</span>
                        </label>
                    </div>
                    @error('document_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    @error('document_type.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex flex-col">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Not (isteğe bağlı)</label>
                    <textarea name="message"
                              class="w-full flex-1 border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-navy transition-colors resize-none">{{ old('message') }}</textarea>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full justify-center mt-6">
                Doküman Talep Et
            </button>
        </form>
        @endif
    </div>
</div>

<script>
    const modal = document.getElementById('doc-request-modal');
    const backdrop = document.getElementById('modal-backdrop');
    const closeBtn = document.getElementById('modal-close');

    function openDocModal(productId, productName, availableTypes) {
        document.getElementById('modal-product-id').value = productId || '';
        document.getElementById('modal-product-name').value = productName || '';

        // Ürüne göre hangi belgeler mevcutsa sadece onları seçilebilir bırak
        // (availableTypes verilmezse hepsi seçilebilir kalır — örn. genel talep)
        var checkboxes = document.querySelectorAll('#modal-doc-types input[data-doc-type]');
        checkboxes.forEach(function (cb) {
            var isAvailable = !availableTypes || availableTypes.indexOf(cb.dataset.docType) !== -1;
            cb.disabled = !isAvailable;
            cb.checked = isAvailable;
            cb.closest('label').classList.toggle('opacity-40', !isAvailable);
        });

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeDocModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    closeBtn?.addEventListener('click', closeDocModal);
    backdrop?.addEventListener('click', closeDocModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDocModal(); });

    @if(session('document_request_success'))
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    @endif
</script>

@if(session('success') || session('error'))
    <div id="flash-toast" class="fixed top-6 right-6 z-50">
        <div id="flash-toast-inner" class="max-w-sm w-full">
            @php
                $type = session('success') ? 'success' : 'error';
                $message = session('success') ?? session('error');
            @endphp
            <div class="w-full rounded-lg shadow-lg overflow-hidden ring-1 ring-black ring-opacity-5"
                 style="background-color: {{ $type === 'success' ? '#ecfdf5' : '#fef2f2' }}; border-left: 4px solid {{ $type === 'success' ? '#10b981' : '#ef4444' }};">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ $message }}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button id="flash-toast-close" class="text-gray-500 hover:text-gray-700">×</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @once
        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toast = document.getElementById('flash-toast-inner');
                const close = document.getElementById('flash-toast-close');
                if (!toast) return;
                // auto remove after 4s
                setTimeout(() => {
                    toast.style.transition = 'opacity 250ms ease, transform 250ms ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    setTimeout(() => { const el = document.getElementById('flash-toast'); if (el) el.remove(); }, 300);
                }, 4000);

                if (close) {
                    close.addEventListener('click', function () {
                        const el = document.getElementById('flash-toast'); if (el) el.remove();
                    });
                }
            });
        </script>
        @endpush
    @endonce
@endif

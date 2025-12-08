<div id="notification-toasts" class="fixed bottom-6 right-6 space-y-3 z-50"></div>

@once
    @push('scripts')
    <script>
        (function(){
            const pollInterval = 5000; // 5 seconds
            let seen = new Set();

            function showToast(notification) {
                const id = notification.id;
                if (seen.has(id)) return;
                seen.add(id);

                const container = document.getElementById('notification-toasts');
                const toast = document.createElement('div');
                toast.className = 'max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden';
                toast.innerHTML = `
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${escapeHtml(notification.data.message || notification.data.order_number || notification.data.customer_id || 'Notification')}</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">${escapeHtml(notification.data.created_by_name || '')} • ${escapeHtml(notification.diff)}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button type="button" class="close-notification text-gray-400 hover:text-gray-600" data-id="${id}">×</button>
                            </div>
                        </div>
                    </div>
                `;

                container.prepend(toast);

                // Auto remove after 7s
                setTimeout(() => { tryRemove(toast); }, 7000);

                // Close button
                toast.querySelector('.close-notification').addEventListener('click', function(){
                    const nid = this.dataset.id;
                    markAsRead(nid);
                    tryRemove(toast);
                });
            }

            function tryRemove(node) {
                if (!node) return;
                node.style.transition = 'opacity 250ms ease';
                node.style.opacity = '0';
                setTimeout(() => node.remove(), 300);
            }

            function escapeHtml(unsafe) {
                if (!unsafe) return '';
                return String(unsafe).replace(/[&<>\"]+/g, function(match) {
                    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' };
                    return map[match];
                });
            }

            async function poll() {
                try {
                    const res = await fetch('{{ route('notifications.unread.json') }}', { credentials: 'same-origin' });
                    if (!res.ok) return;
                    const payload = await res.json();
                    if (!payload.success) return;
                    const notifications = payload.data || [];
                    notifications.reverse().forEach(n => showToast(n));
                } catch (e) {
                    // ignore
                }
            }

            async function markAsRead(id) {
                try {
                    const url = '{{ url('notifications') }}' + '/' + id + '/mark-read';
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                        credentials: 'same-origin'
                    });
                    // silently ignore non-OK (404/401) to avoid showing unwanted pages
                    return res.ok;
                } catch (e) {
                    return false;
                }
            }

            // start polling after DOM ready
            document.addEventListener('DOMContentLoaded', function(){
                poll();
                setInterval(poll, pollInterval);
            });
        })();
    </script>
    @endpush
@endonce

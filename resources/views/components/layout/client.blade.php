<!DOCTYPE html>
<html lang="en" x-data :data-theme="$store.theme.current">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ 'Pathfinder' . ' | ' . $title ?? 'Pathfinder' }}</title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicons/android-chrome-512x512.png') }}">
    
    {{-- Inline CSS for immediate loading spinner --}}
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s ease;
        }
        
        #page-loader.hide {
            opacity: 0;
            pointer-events: none;
        }
        
        [data-theme="dark"] #page-loader {
            background: rgba(0, 0, 0, 1);
        }

        [data-theme="light"] #page-loader {
            background: rgba(255, 255, 255, 255);
        }
        
        [data-theme="dark"] .spinner {
            border-color: rgba(255, 255, 255, 0.1);
            border-left-color: currentColor;
        }

        [data-theme="light"] .spinner {
            border-color: rgba(255, 255, 255, 0.1);
            border-left-color: currentColor;
        }
    </style>
    </style>
    
    {{-- Apply theme early to prevent flicker --}}
    <script>
        (function() {
            // Priority: localStorage > server preference > default
            const serverTheme = '{{ Auth::check() ? Auth::user()->theme_preference : "light" }}';
            const savedTheme = localStorage.getItem('theme') || serverTheme;
            
            // Apply immediately to prevent flicker
            document.documentElement.setAttribute('data-theme', savedTheme);
            
            // Store for Alpine to read later
            window.__INITIAL_THEME__ = savedTheme;
        })();
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <!-- Loading spinner (shows IMMEDIATELY on page load) -->
    <div id="page-loader">
        <span class="loading loading-ring loading-xs text-success"></span>
        <span class="loading loading-ring loading-sm text-success"></span>
        <span class="loading loading-ring loading-md text-success"></span>
        <span class="loading loading-ring loading-lg text-success"></span>
        <span class="loading loading-ring loading-xl text-success"></span>
    </div>

    {{ $slot }}
    
    @stack('scripts')
    
    <script>
         // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.add('hide');
            }
        });
                
        // Show loader on any navigation (for SPA-like behavior)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.target && !link.hasAttribute('download')) {
                // Only show loader for internal links
                if (link.href.startsWith(window.location.origin)) {
                    const loader = document.getElementById('page-loader');
                    if (loader) {
                        loader.classList.remove('hide');
                        
                        // Close all modals when loader is shown
                        for (let i = 1; i <= 6; i++) {
                            const modal = document.getElementById(`my_modal_${i}`);
                            if (modal && modal.open) {
                                modal.close();
                            }
                        }
                        
                        // Close submit_modal and cancel_modal
                        const submitModal = document.getElementById('submit_modal');
                        if (submitModal && submitModal.open) {
                            submitModal.close();
                        }
                        
                        const cancelModal = document.getElementById('cancel_modal');
                        if (cancelModal && cancelModal.open) {
                            cancelModal.close();
                        }
                    }
                }
            }
        });

        // Also handle browser back/forward buttons
        window.addEventListener('beforeunload', function() {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.remove('hide');
                
                // Close all modals when loader is shown
                for (let i = 1; i <= 6; i++) {
                    const modal = document.getElementById(`my_modal_${i}`);
                    if (modal && modal.open) {
                        modal.close();
                    }
                }
                
                // Close submit_modal and cancel_modal
                const submitModal = document.getElementById('submit_modal');
                if (submitModal && submitModal.open) {
                    submitModal.close();
                }
                
                const cancelModal = document.getElementById('cancel_modal');
                if (cancelModal && cancelModal.open) {
                    cancelModal.close();
                }
            }
        });
        
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                // Use the theme we already applied
                current: window.__INITIAL_THEME__ || 'light',
                
                init() {
                    // Sync checkbox state (don't reapply theme - already done)
                    const toggle = document.querySelector('.theme-controller');
                    if (toggle) {
                        toggle.checked = this.current === 'dark';
                    }
                },
                
                async toggle() {
                    this.current = this.current === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', this.current);
                    localStorage.setItem('theme', this.current);
                    
                    try {
                        await fetch('{{ route("dashboard.settings.appearance.update") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ theme: this.current })
                        });
                    } catch (error) {
                        console.error('Failed to save theme preference:', error);
                    }
                },
                
                isDark() {
                    return this.current === 'dark';
                }
            });
            
            Alpine.store('theme').init();
        });
    </script>
</body>
</html>
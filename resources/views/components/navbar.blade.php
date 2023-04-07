<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="page navigation bar">
    <div class="container-fluid">
        <div class="d-flex justify-content-start">
            <!-- Key button -->
            <div class="">
                <a href="{{ route('api-key') }}"
                   class="{{ $mailerLiteService->ready() ? 'text-success' : 'text-secondary' }}"
                   title="{{$mailerLiteService->ready() ? 'Ok!' : 'Waiting for api key'}}"
                   data-bs-toggle="tooltip"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                         fill="currentColor" class="bi bi-key-fill"
                         viewBox="0 0 16 16">
                        <path
                            d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                    </svg>
                </a>
            </div>

            <!-- Alert Switch -->
            <div class="">
                <a href="#" id="alert-switch" class="ms-4 text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                         class="bi bi-bell-fill d-none" viewBox="0 0 16 16" id="alerts-on-icon" data-bs-toggle="tooltip"
                         title="Alerts enabled">
                        <path
                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                         class="bi bi-bell-slash-fill d-none" viewBox="0 0 16 16" id="alerts-off-icon"
                         data-bs-toggle="tooltip" title="Alerts disabled">
                        <path
                            d="M5.164 14H15c-1.5-1-2-5.902-2-7 0-.264-.02-.523-.06-.776L5.164 14zm6.288-10.617A4.988 4.988 0 0 0 8.995 2.1a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 7c0 .898-.335 4.342-1.278 6.113l9.73-9.73zM10 15a2 2 0 1 1-4 0h4zm-9.375.625a.53.53 0 0 0 .75.75l14.75-14.75a.53.53 0 0 0-.75-.75L.625 15.625z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navbar">
            <ul class="navbar-nav">
                <li class="nav-item d-flex align-items-center" data-bs-toggle="tooltip"
                    title="Requests made in last minute">
                    <span id="request-counter" class="text-white me-2">...</span>
                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white"
                         class="bi bi-clipboard-data-fill" viewBox="0 0 16 16">
                        <path
                            d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z"/>
                        <path
                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1ZM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V8Zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1Zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1Z"/>
                    </svg>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>

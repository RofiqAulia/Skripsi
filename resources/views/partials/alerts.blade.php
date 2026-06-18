@if (session('success') || session('error') || session('warning') || session('info') || $errors->any())
    <div class="custom-alerts-container">
        
        {{-- SUCCESS --}}
        @if (session('success'))
            <div class="custom-alert alert-success alert-dismissible fade show" role="alert">
                <div class="alert-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="alert-content">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ERROR / DANGER --}}
        @if (session('error'))
            <div class="custom-alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-icon"><i class="bi bi-x-circle-fill"></i></div>
                <div class="alert-content">
                    <strong>Error!</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- WARNING --}}
        @if (session('warning'))
            <div class="custom-alert alert-warning alert-dismissible fade show" role="alert">
                <div class="alert-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                <div class="alert-content">
                    <strong>Warning!</strong> {{ session('warning') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- INFO --}}
        @if (session('info'))
            <div class="custom-alert alert-info alert-dismissible fade show" role="alert">
                <div class="alert-icon"><i class="bi bi-info-circle-fill"></i></div>
                <div class="alert-content">
                    <strong>Info:</strong> {{ session('info') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div class="custom-alert alert-danger alert-dismissible fade show" role="alert">
                <div class="alert-icon"><i class="bi bi-shield-fill-x"></i></div>
                <div class="alert-content">
                    <strong>Whoops! Something went wrong.</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    </div>

    <style>
        /* 🔥 FLOATING ALERT CONTAINER */
        .custom-alerts-container {
            position: fixed;
            top: 100px; /* Below the navbar */
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
            width: 100%;
        }

        /* 🔥 BASE ALERT STYLE (RED, WHITE, BLACK THEME) */
        .custom-alert {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            background: #ffffff;
            color: #111111;
            padding: 16px 20px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left: 6px solid #111111; /* Default black border */
            animation: slideInRight 0.4s ease-out forwards;
            position: relative;
            overflow: hidden;
        }

        /* THEME: ERROR / DANGER (Red & White) */
        .custom-alert.alert-danger {
            border-left-color: #8b0000;
        }
        .custom-alert.alert-danger .alert-icon {
            color: #8b0000;
        }

        /* THEME: SUCCESS (Black & White) */
        .custom-alert.alert-success {
            border-left-color: #111111;
        }
        .custom-alert.alert-success .alert-icon {
            color: #111111;
        }

        /* THEME: WARNING (Redish/Black) */
        .custom-alert.alert-warning {
            border-left-color: #c40000;
        }
        .custom-alert.alert-warning .alert-icon {
            color: #c40000;
        }

        /* THEME: INFO (Grey/Black) */
        .custom-alert.alert-info {
            border-left-color: #333333;
        }
        .custom-alert.alert-info .alert-icon {
            color: #333333;
        }

        .alert-icon {
            font-size: 24px;
            margin-top: -2px;
        }

        .alert-content {
            flex: 1;
            font-size: 14px;
            line-height: 1.5;
        }

        .alert-content strong {
            display: block;
            font-size: 16px;
            color: #111111;
            margin-bottom: 4px;
        }

        .custom-alert .btn-close {
            position: absolute;
            top: 16px;
            right: 16px;
            font-size: 12px;
            padding: 0;
            opacity: 0.5;
        }

        .custom-alert .btn-close:hover {
            opacity: 1;
            color: #8b0000;
        }

        /* ANIMATION */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 576px) {
            .custom-alerts-container {
                top: 80px;
                right: 10px;
                left: 10px;
                width: auto;
            }
        }
    </style>

    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                let alerts = document.querySelectorAll('.custom-alert');
                alerts.forEach(function(alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endif

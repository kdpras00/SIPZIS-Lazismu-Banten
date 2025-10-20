@extends('layouts.main')

@section('title', 'Page Not Found')

@section('content')
<div class="position-relative d-flex justify-content-center align-items-center"
    style="min-height: 100vh; flex-direction: column; background: linear-gradient(135deg, #ecfdf5, #f0fdfa, #e0f2fe); overflow: hidden;">

    <!-- Background blob animasi -->
    <div class="position-absolute top-0 start-0 w-50 h-50 bg-success rounded-circle opacity-0 blur-5 animate-pulse blob"></div>
    <div class="position-absolute bottom-0 end-0 w-50 h-50 bg-info rounded-circle opacity-0 blur-5 animate-pulse animation-delay-2000 blob"></div>

    <!-- Container animasi Lottie -->
    <div id="lottie-container" style="width: 500px; height: 500px; margin-bottom: 20px; z-index: 1;"></div>

    <!-- Pesan 404 -->
    <h1 class="display-1 fw-bold"
        style="font-family: 'Arial Rounded MT Bold', 'Helvetica Rounded', Arial, sans-serif; color: gray; text-shadow: 2px 2px 6px rgba(0,0,0,0.2); z-index: 1;">
        Whoops!</h1>
    <p class="lead" style="z-index: 1;">Not Found.</p>

</div>

<!-- Lottie JS -->
<script src="https://unpkg.com/lottie-web@5.10.0/build/player/lottie.min.js"></script>
<script>
    const animation = lottie.loadAnimation({
        container: document.getElementById('lottie-container'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: "{{ asset('json/Sleeping404.json') }}"
    });
</script>

<!-- Animasi lembut untuk background -->
<style>
    @keyframes pulse-slow {

        0%,
        100% {
            opacity: 0.25;
            transform: scale(1);
        }

        50% {
            opacity: 0.4;
            transform: scale(1.1);
        }
    }

    .animate-pulse {
        animation: pulse-slow 8s ease-in-out infinite;
        filter: blur(30px);
        /* lebih ringan dari 60px */
        will-change: transform, opacity;
        /* kasih tahu browser untuk optimasi GPU */
    }


    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".blob").forEach(b => {
            b.style.transition = "opacity 1s ease-in";
            requestAnimationFrame(() => {
                b.style.opacity = "0.25";
            }); // scripty sedikit biar halus
        });
    });
</script>
@endsection
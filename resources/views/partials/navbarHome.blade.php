<nav class="fixed w-full z-50 transition-all duration-300 font-poppins bold" id="navbar">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- SIPZ Title - Left Side -->
            <div class="flex items-center">
                <a href="/" class="flex-shrink-0 flex items-center">
                    <div class="flex items-center">
                        <h1 style="font-family: 'Poppins', sans-serif; font-size: 1.5rem; background: linear-gradient(45deg, #fff, #e0e7ff, #c7d2fe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; text-shadow: 0 0 20px rgba(255,255,255,0.5); letter-spacing: 0.1em; font-weight: 800;" id="navbar-title" class="text-white">
                            SIPZIS
                        </h1>
                    </div>
                </a>
            </div>

            <!-- Navigation Links - Center -->
            <div class="hidden md:flex items-center justify-center flex-1">
                <div class="flex items-center space-x-8" id="href-navbar">
                    <!-- <a href="{{ route('home') }}"
                        class="px-3 py-2 text-white hover:border-b-2 hover:border-white transition duration-300 navbar-link">Home</a> -->
                    <a href="{{ route('tentang') }}"
                        class="px-3 py-2 text-white hover:border-b-2 hover:border-white transition duration-300 navbar-link">Tentang</a>    
                    <a href="{{ route('program') }}"
                        class="px-3 py-2 text-white hover:border-b-2 hover:border-white transition duration-300 navbar-link">Program</a>
                    <a href="{{ route('berita') }}"
                        class="px-3 py-2 text-white hover:border-b-2 hover:border-white transition duration-300 navbar-link">Berita</a>
                    <a href="{{ route('artikel.all') }}"
                        class="px-3 py-2 text-white hover:border-b-2 hover:border-white transition duration-300 navbar-link">Artikel</a>
                </div>
            </div>

            <!-- Empty div for balance - Right Side -->
            <div class="hidden md:block w-20"></div>
        </div>
    </div>
</nav>

<script>
    const navbar = document.getElementById('navbar');
    const navbarTitle = document.getElementById('navbar-title');
    const navbarLinks = document.querySelectorAll('.navbar-link');
    const beranda = document.getElementById('beranda');

    // Smooth scrolling for navbar links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Periksa apakah elemen 'beranda' ada di halaman
    if (beranda) {
        let isTransparent = true;

        // Fungsi untuk membuat navbar transparan
        function setNavbarTransparent() {
            if (!isTransparent) {
                navbar.classList.remove('bg-green-800', 'shadow-md');
                navbar.classList.add('bg-transparent');
                navbarTitle.classList.remove('text-white');
                navbarTitle.classList.add('text-white');
                navbarLinks.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-white');
                });
                isTransparent = true;
            }
        }

        // Fungsi untuk membuat navbar solid (hijau tua dengan teks putih)
        function setNavbarSolid() {
            if (isTransparent) {
                navbar.classList.remove('bg-transparent');
                navbar.classList.add('bg-green-800', 'shadow-md');
                navbarTitle.classList.remove('text-white');
                navbarTitle.classList.add('text-white');
                navbarLinks.forEach(link => {
                    link.classList.remove('text-white');
                    link.classList.add('text-white');
                });
                isTransparent = false;
            }
        }

        // Periksa lokasi hash saat ini
        function checkCurrentHash() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const berandaHeight = beranda.offsetHeight;

            if (window.location.hash !== '#beranda' && window.location.hash !== '') {
                setNavbarSolid();
            } else if (scrollTop < berandaHeight) {
                setNavbarTransparent();
            } else {
                setNavbarSolid();
            }
        }

        // Jalankan saat halaman di-scroll
        window.addEventListener('scroll', checkCurrentHash);

        // Jalankan saat hash berubah
        window.addEventListener('hashchange', checkCurrentHash);

        // Jalankan saat halaman dimuat
        window.addEventListener('load', checkCurrentHash);

    } else {
        // Jika tidak ada elemen beranda, buat navbar selalu solid
        navbar.classList.remove('bg-transparent');
        navbar.classList.add('bg-green-800', 'shadow-md');
        navbarTitle.classList.remove('text-white');
        navbarTitle.classList.add('text-white');
        navbarLinks.forEach(link => {
            link.classList.remove('text-white');
            link.classList.add('text-white');
        });
    }
</script>

<style>
    /* Mengubah warna hover tautan menjadi putih */
    .navbar-link:hover {
        color: white;
        border-bottom: 2px solid white;
    }

    /* Warna teks default untuk navbar solid */
    .bg-green-800 .navbar-link {
        color: white;
    }

    /* Warna teks default untuk navbar transparan */
    .bg-transparent .navbar-link {
        color: white;
    }

    /* Special styling for payment link */
    .navbar-payment-link {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-payment-link:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>
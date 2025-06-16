@extends('layout.Pelanggan.app')

@section('content')

<!-- Hero Section with Subtle Parallax Effect -->
<section class="relative h-[33rem] overflow-hidden">
    <!-- Parallax background -->
    <div class="absolute inset-0 bg-[url('/img/background_komposin.png')] bg-repeat-x bg-[length:500px_auto] bg-center transform transition-transform duration-1000" style="transform: translateY(0px);" id="parallax-bg"></div>
    <div class="absolute inset-0 bg-black/40"></div>
    <!-- Konten Teks dan Tombol dengan Fade-in Effect -->
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 opacity-0 translate-y-4 transition-all duration-1000 ease-out" id="hero-content">
      <h1 class="text-5xl font-extrabold text-white drop-shadow-md">REPONIK</h1>
      <p class="mt-4 max-w-2xl text-white text-lg">
        Otomatisasi monitoring, penjadwalan, dan optimalisasi rute pengambilan sampah organik berbasis teknologi untuk lingkungan yang lebih bersih dan berkelanjutan
      </p>
      <div class="mt-6 flex justify-between items-center space-x-4">
        <button id="pay-button"class="bg-green-500 text-white px-6 py-3 rounded hover:bg-green-600 font-semibold transition-all duration-300 transform hover:scale-105" >Berlangganan</button>
    </div>
    </div>
</section>


<!-- Features Section with Fade-in on Scroll -->
<section class="py-16 bg-white overflow-hidden">
    <div class="container mx-auto text-center">
      <div class="opacity-0 transition-all duration-700 ease-out transform translate-y-8" id="features-heading">
        <h2 class="text-2xl font-bold text-green-800">Fitur Unggulan RePonik</h2>
        <div class="w-32 h-1 bg-yellow-400 mx-auto mt-2 mb-12"></div>
      </div>

      <div class="mt-10 flex flex-col sm:flex-row justify-center gap-8">
        <!-- Feature cards with subtle hover effects -->
        <div class="max-w-xs bg-white rounded-lg shadow-md transition-all duration-500 ease-out opacity-0 translate-y-8 feature-card hover:shadow-lg transform hover:-translate-y-1">
          <div class="bg-lime-50 p-12 flex justify-center items-center rounded-t-lg">
            <i class="fas fa-microchip text-green-900 text-3xl transition-transform duration-500 hover:scale-110"></i>
          </div>
          <div class="p-6 text-gray-700 text-left">
            <h3 class="font-bold text-green-900 mb-2 text-left">
              Monitoring IoT Real-time
            </h3>
            <p>
              Pantau kondisi tempat sampah organik Anda secara real-time melalui sensor ultrasonik yang terintegrasi dengan sistem kami.
            </p>
          </div>
        </div>

        <div class="max-w-xs bg-white rounded-lg shadow-md transition-all duration-500 ease-out opacity-0 translate-y-8 feature-card hover:shadow-lg transform hover:-translate-y-1 delay-100">
          <div class="bg-lime-50 p-12 flex justify-center items-center rounded-t-lg">
            <i class="fas fa-route text-green-900 text-3xl transition-transform duration-500 hover:scale-110"></i>
          </div>
          <div class="p-6 text-gray-700 text-left">
            <h3 class="font-bold text-green-900 mb-2 leading-tight">
              Optimalisasi Rute
            </h3>
            <p>
              Sistem kami menghasilkan rute pengambilan sampah yang optimal berdasarkan titik koordinat konsumen untuk efisiensi waktu dan biaya.
            </p>
          </div>
        </div>

        <div class="max-w-xs bg-white rounded-lg shadow-md transition-all duration-500 ease-out opacity-0 translate-y-8 feature-card hover:shadow-lg transform hover:-translate-y-1 delay-200">
          <div class="bg-lime-50 p-12 flex justify-center items-center rounded-t-lg">
            <i class="fas fa-chart-line text-green-900 text-3xl transition-transform duration-500 hover:scale-110"></i>
          </div>
          <div class="p-6 text-gray-700 text-left">
            <h3 class="font-bold text-green-900 mb-2 leading-tight">
              Dashboard Pelaporan
            </h3>
            <p>
              Akses riwayat pengambilan sampah, volume, dan konversi ke pupuk kompos melalui dashboard interaktif.
            </p>
          </div>
        </div>
      </div>
    </div>
</section>

<!-- Pupuk Kami Section with Reveal Animation -->
<section id="katalog" class="relative bg-white py-10 overflow-hidden">
    <div aria-hidden="true" class="absolute top-0 bottom-0 left-0 w-20 bg-green-900 hidden lg:block transform -translate-x-full transition-transform duration-1000 ease-out" id="left-green-bar">
    </div>
    <div aria-hidden="true" class="absolute top-0 bottom-0 right-0 w-20 bg-green-900 hidden lg:block transform translate-x-full transition-transform duration-1000 ease-out" id="right-green-bar">
    </div>
    <div class="flex flex-col lg:flex-row items-start gap-8 max-w-6xl mx-auto">
        <div class="lg:w-1/3 text-xs md:text-sm opacity-0 transition-all duration-700 ease-out transform translate-x-8" id="pupuk-content">
         <h3 class="font-semibold mb-3 mt-6 text-[#1B4D1B] text-center">
          Pupuk Kami
         </h3>
         <div class="w-14 h-1 bg-yellow-400 mx-auto mb-4 rounded">
         </div>
         <p class="mb-6 leading-tight text-justify text-[10px] md:text-sm">
          Kami menghadirkan solusi alami untuk pertanian yang lebih sehat dan
              berkelanjutan melalui pupuk organik berkualitas tinggi. Terbuat dari
              bahan-bahan alami pilihan, pupuk kami diproses tanpa bahan kimia berbahaya,
              menjaga kesuburan tanah serta meningkatkan hasil panen secara alami. Pupuk
              organik ini cocok digunakan untuk berbagai jenis tanaman mulai dari sayuran,
              buah-buahan, hingga tanaman hias. Dengan kandungan unsur hara yang lengkap,
              produk kami membantu memperbaiki struktur tanah, merangsang pertumbuhan akar,
              dan menjaga keseimbangan ekosistem mikroba tanah.
         </p>
         <a href="https://shopee.co.id/anismahmudah912#product_list" target="_blank" rel="noopener noreferrer"
            class="bg-yellow-400 text-[#1B4D1B] font-semibold rounded px-4 py-2 text-xs hover:bg-yellow-300 transition-all duration-300 transform hover:scale-105 inline-block text-center">
            Beli Sekarang
        </a>

        </div>
     <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6 flex flex-col md:flex-row md:items-center md:space-x-6 opacity-0 transition-all duration-700 ease-out transform translate-x-8" id="pupuk-image">
      <img alt="poster reponik" class="w-full md:w-2/3 rounded shadow-md transition-all duration-500 hover:shadow-xl" height="100" src="{{ asset('img/poster-produk.jpg') }}" width="100"/>
      <ul class="space-y-3 text-green-900 font-semibold text-sm md:text-base leading-relaxed">
        <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-1">
            <span class="mt-1.5 w-2 h-2 bg-green-900 rounded-full"></span>
            <span>100% Alami & Ramah Lingkungan</span>
        </li>
        <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-1">
            <span class="mt-1.5 w-2 h-2 bg-green-900 rounded-full"></span>
            <span>Aman untuk Tanaman & Manusia</span>
        </li>
        <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-1">
            <span class="mt-1.5 w-2 h-2 bg-green-900 rounded-full"></span>
            <span>Meningkatkan Kualitas dan Kuantitas Hasil Panen</span>
        </li>
        <li class="flex items-start gap-2 transition-all duration-300 hover:translate-x-1">
            <span class="mt-1.5 w-2 h-2 bg-green-900 rounded-full"></span>
            <span>Teruji oleh Petani Lokal & Profesional</span>
        </li>
    </ul>
     </div>
    </div>
</section>

<!-- Artikel Terbaru Section with Carousel Effect -->
<section id="Artikel" class="relative max-w-7xl mx-auto px-4 py-10 bg-[url('{{ asset('img/bg-artikel.png') }}')] bg-no-repeat bg-center bg-contain rounded-lg overflow-hidden">
  <div class="opacity-0 transition-all duration-700 ease-out transform translate-y-8" id="artikel-heading">
    <h2 class="text-[#1B4D1B] font-semibold text-center text-sm md:text-base">
      Artikel Terbaru
    </h2>
    <div class="w-14 h-1 bg-yellow-400 mx-auto mt-1 mb-4 rounded"></div>
    <p class="text-[8px] md:text-xs text-center text-[#1B4D1B]/70 mb-6">
      Update terbaru seputar pengelolaan sampah organik by Reponik
    </p>
  </div>

  <div class="relative px-14">
    <button aria-label="Previous article" class="absolute top-1/2 left-0 -translate-y-1/2 bg-[#1B4D1B]/50 hover:bg-[#1B4D1B]/70 text-white rounded-full w-12 h-12 md:w-14 md:h-14 flex items-center justify-center transition-all duration-300 transform hover:scale-110 z-20" type="button" id="prev-article">
      <i class="fas fa-chevron-left text-lg md:text-xl"></i>
    </button>

    <!-- Carousel container with overflow and flex layout -->
    <div class="overflow-hidden" id="carousel-container">
      <div class="flex transition-transform duration-500 ease-out" id="artikel-carousel">
        @foreach ($data_artikel as $artikel)
        <article class="w-full md:w-1/3 flex-shrink-0 px-3 md:px-6 transition-all duration-500">
          <div class="bg-white rounded-lg shadow-lg p-4 md:p-6 text-[#1B4D1B] text-xs md:text-sm flex flex-col justify-between transition-all duration-500 transform hover:-translate-y-1 hover:shadow-xl h-full">
            <img src="{{ asset('img/' . $artikel->gambar) }}"
                 alt="Gambar Artikel"
                 class="mb-4 rounded shadow-sm transition-all duration-500 hover:shadow-md w-full h-40 object-cover" />

            <h3 class="font-semibold mb-3 text-xs md:text-sm">
              {{ Str::limit($artikel->judul, 60) }}
            </h3>
            <p class="mb-6 text-[8px] md:text-xs leading-relaxed text-[#1B4D1B]/80 flex-grow">
              {{ Str::limit(strip_tags($artikel->konten), 150) }}
            </p>
            <a class="text-[#1B4D1B] text-[8px] md:text-xs font-semibold hover:underline transition-colors duration-300"
               href="{{ route('artikel.read', ['artikel_id' => $artikel->artikel_id]) }}">
              Baca Selengkapnya
            </a>
          </div>
        </article>
        @endforeach
      </div>
    </div>

    <button aria-label="Next article" class="absolute top-1/2 right-0 -translate-y-1/2 bg-[#1B4D1B]/50 hover:bg-[#1B4D1B]/70 text-white rounded-full w-12 h-12 md:w-14 md:h-14 flex items-center justify-center transition-all duration-300 transform hover:scale-110 z-20" type="button" id="next-article">
      <i class="fas fa-chevron-right text-lg md:text-xl"></i>
    </button>

    <!-- Carousel Indicators -->
    <div class="flex justify-center mt-8 space-x-2" id="carousel-indicators">
      <!-- Indicators will be added dynamically by JavaScript -->
    </div>
  </div>
</section>


<!-- Add JavaScript for animations and carousel with auto-slide -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Hero section animation
    const heroContent = document.getElementById('hero-content');
    if (heroContent) {
      setTimeout(() => {
        heroContent.classList.remove('opacity-0', 'translate-y-4');
      }, 300);
    }

    // Parallax effect on scroll
    const parallaxBg = document.getElementById('parallax-bg');
    window.addEventListener('scroll', function() {
      const scrollPosition = window.scrollY;
      if (parallaxBg) {
        parallaxBg.style.transform = `translateY(${scrollPosition * 0.2}px)`;
      }
    });

    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('opacity-0', 'translate-y-8', 'translate-x-8');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    // Observe elements for animation
    const animateElements = [
      document.getElementById('features-heading'),
      document.getElementById('pupuk-content'),
      document.getElementById('pupuk-image'),
      document.getElementById('artikel-heading'),
      ...Array.from(document.querySelectorAll('.feature-card'))
    ];

    animateElements.forEach(el => {
      if (el) observer.observe(el);
    });

    // Observer for green bars animation
    const greenBarsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const leftBar = document.getElementById('left-green-bar');
          const rightBar = document.getElementById('right-green-bar');

          if (leftBar) leftBar.classList.remove('-translate-x-full');
          if (rightBar) rightBar.classList.remove('translate-x-full');

          greenBarsObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });

    // Observe the katalog section for green bar animations
    const katalogSection = document.getElementById('katalog');
    if (katalogSection) greenBarsObserver.observe(katalogSection);

    // Enhanced article carousel functionality with auto-slide
    const container = document.getElementById('carousel-container');
    const carousel = document.getElementById('artikel-carousel');
    const prevBtn = document.getElementById('prev-article');
    const nextBtn = document.getElementById('next-article');
    const indicatorsContainer = document.getElementById('carousel-indicators');

    if (!carousel || !prevBtn || !nextBtn) return;

    const articles = carousel.querySelectorAll('article');
    const articleCount = articles.length;
    let currentPosition = 0;
    let autoSlideInterval;
    let isTransitioning = false;

    // Create indicators
    if (indicatorsContainer) {
      const numPages = Math.ceil(articleCount / (window.innerWidth < 768 ? 1 : 3));
      for (let i = 0; i < numPages; i++) {
        const indicator = document.createElement('button');
        indicator.classList.add('w-2', 'h-2', 'rounded-full', 'bg-[#1B4D1B]/30', 'transition-all', 'duration-300');
        indicator.setAttribute('aria-label', `Go to slide ${i + 1}`);
        indicator.dataset.index = i;
        indicator.addEventListener('click', () => {
          goToSlide(i);
          resetAutoSlide();
        });
        indicatorsContainer.appendChild(indicator);
      }
    }

    // Init first indicator as active
    updateIndicators();

    // Navigation logic
    prevBtn.addEventListener('click', () => {
      if (isTransitioning) return;
      moveToPrev();
      resetAutoSlide();
    });

    nextBtn.addEventListener('click', () => {
      if (isTransitioning) return;
      moveToNext();
      resetAutoSlide();
    });

    // Handle swipe gestures for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      resetAutoSlide();
    }, { passive: true });

    function handleSwipe() {
      const swipeDiff = touchStartX - touchEndX;
      if (swipeDiff > 50) { // Swipe left
        moveToNext();
      } else if (swipeDiff < -50) { // Swipe right
        moveToPrev();
      }
    }

    function updateCarouselPosition() {
      isTransitioning = true;
      const articlesPerView = window.innerWidth < 768 ? 1 : 3;
      const slideWidth = container.offsetWidth / articlesPerView;
      carousel.style.transform = `translateX(-${currentPosition * slideWidth}px)`;
      updateIndicators();

      // Reset the transitioning flag after animation completes
      setTimeout(() => {
        isTransitioning = false;
      }, 500);
    }

    function updateIndicators() {
      if (!indicatorsContainer) return;

      const indicators = indicatorsContainer.querySelectorAll('button');
      const articlesPerView = window.innerWidth < 768 ? 1 : 3;
      const currentPage = Math.floor(currentPosition / articlesPerView);

      indicators.forEach((indicator, idx) => {
        if (idx === currentPage) {
          indicator.classList.remove('bg-[#1B4D1B]/30');
          indicator.classList.add('bg-[#1B4D1B]', 'w-4');
        } else {
          indicator.classList.add('bg-[#1B4D1B]/30');
          indicator.classList.remove('bg-[#1B4D1B]', 'w-4');
        }
      });
    }

    function moveToNext() {
      const articlesPerView = window.innerWidth < 768 ? 1 : 3;
      const maxPosition = Math.max(0, articleCount - articlesPerView);

      if (currentPosition < maxPosition) {
        currentPosition++;
        updateCarouselPosition();
      } else {
        // Loop back to beginning with animation
        currentPosition = 0;
        updateCarouselPosition();
      }
    }

    function moveToPrev() {
      if (currentPosition > 0) {
        currentPosition--;
        updateCarouselPosition();
      } else {
        // Loop to end with animation
        const articlesPerView = window.innerWidth < 768 ? 1 : 3;
        const maxPosition = Math.max(0, articleCount - articlesPerView);
        currentPosition = maxPosition;
        updateCarouselPosition();
      }
    }

    function goToSlide(index) {
      const articlesPerView = window.innerWidth < 768 ? 1 : 3;
      currentPosition = index * articlesPerView;
      if (currentPosition > articleCount - articlesPerView) {
        currentPosition = articleCount - articlesPerView;
      }
      updateCarouselPosition();
    }

    // Start auto-slide
    function startAutoSlide() {
      autoSlideInterval = setInterval(() => {
        moveToNext();
      }, 5000); // Change slides every 5 seconds
    }

    function resetAutoSlide() {
      clearInterval(autoSlideInterval);
      startAutoSlide();
    }

    // Initial position
    updateCarouselPosition();

    // Start auto-slide
    startAutoSlide();

    // Reset on window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        // Keep at current slide but adjust for new viewport size
        updateCarouselPosition();
      }, 250);
    });
  });
</script>

{{-- Midtrans --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        fetch('{{ route("berlangganan.create") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            console.log("Snap Token dari server:", data.snap_token);

            // Pastikan snap terdefinisi
            if (typeof snap === 'undefined') {
                alert("Midtrans Snap tidak tersedia. Pastikan script snap.js dimuat.");
                return;
            }

            // Tampilkan popup pembayaran
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Setelah pembayaran berhasil, kirim data ke server
                    fetch('{{ route("berlangganan.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            biaya: 80000
                        })
                    }).then(() => {
                        alert('Berlangganan berhasil!');
                        window.location.reload();
                    });
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran selesai");
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert('Kamu menutup popup tanpa menyelesaikan pembayaran.');
                }
            });
        })
        .catch(error => {
            console.error("Terjadi error:", error);
            alert("Gagal memulai pembayaran. Silakan coba lagi.");
        });
    });
</script>

@endsection

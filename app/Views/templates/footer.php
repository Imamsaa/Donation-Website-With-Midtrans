    <?php
    use App\Models\InstansiModel;
    $instansiModel = new InstansiModel();
    $its = $instansiModel->first();
    ?>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center md:items-start">
                    <div class="flex items-center mb-6">
                        <img src="<?= base_url('public/assets/img/'.$its['logo']); ?>" alt="Logo" class="h-12 w-12 mr-3">
                        <span class="text-2xl font-bold"><?= $its['name'] ?></span></span>
                    </div>
                    <p class="text-gray-400 mb-4 text-center md:text-left">
                        Inovasi untuk Kemanusiaan yang Lebih Cepat.
                    </p>
                    <div class="flex space-x-4">
                        <a href="<?= $its['facebook'] ?>" target="_blank" class="text-gray-400 hover:text-primary-500 transition">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="<?= $its['facebook'] ?>" target="_blank" class="text-gray-400 hover:text-primary-500 transition">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="<?= $its['facebook'] ?>" target="_blank" class="text-gray-400 hover:text-primary-500 transition">
                            <i class="fab fa-internet-explorer text-lg"></i>
                        </a>        
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="<?= base_url('') ?>" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Home
                        </a></li>
                        <li><a href="<?= base_url('program') ?>" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Programs
                        </a></li>
                        <li><a href="<?= base_url('contact') ?>" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Contact
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- <div>
                    <h3 class="text-lg font-semibold mb-4">Programs</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Education
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Healthcare
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Food Aid
                        </a></li>
                        <li><a href="#" class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-chevron-right text-xs mr-2 text-primary-500"></i> Emergency
                        </a></li>
                    </ul>
                </div>
                 -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-3">
                        <li class="text-gray-400 hover:text-primary-500 transition flex items-start">
                            <i class="fas fa-map-marker-alt mr-3 mt-1 text-primary-500"></i>
                            <span><?= $its['address'] ?></span>
                        </li>
                        <li class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-envelope mr-3 text-primary-500"></i>
                            <span><?= $its['email'] ?></span>
                        </li>
                        <li class="text-gray-400 hover:text-primary-500 transition flex items-center">
                            <i class="fas fa-phone mr-3 text-primary-500"></i>
                            <span><?= $its['phone'] ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8 text-center">
                <p class="text-gray-400">© 2025 <?= $its['name'] ?>. All Rights Reserved</p>
            </div>
        </div>
    </footer>

    <!-- Rest of your content -->
    <!-- ... -->

    <script src="<?= base_url('public/plugins/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
 <script>
        // Notification handling
        <?php if (session()->has('kotakok')) : ?>
            const notif = <?= json_encode(session('kotakok')) ?>;
            Swal.fire({
                icon: notif.status,
                title: notif.title,
                text: notif.message
            });
        <?php endif; ?>

        <?php if (session()->has('pojokatas')) : ?>
            const toast = <?= json_encode(session('pojokatas')) ?>;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: toast.status,
                title: toast.message
            });
        <?php endif; ?>
    </script>
    <?php if (session()->getFlashdata('snap_url')): ?>
        <script>
            let snapUrl = "<?= session()->getFlashdata('snap_url'); ?>";
            window.open(snapUrl, "_blank"); // buka di tab baru
        </script>
    <?php endif; ?>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-button');
            
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // Hero Slider Functionality
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.slide-indicator');
        let currentSlide = 0;
        let slideInterval;

        function showSlide(index) {
            // Hide all slides
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('bg-white'));
            
            // Show selected slide
            slides[index].classList.add('active');
            indicators[index].classList.add('bg-white');
            currentSlide = index;
        }

        function nextSlide() {
            const nextIndex = (currentSlide + 1) % slides.length;
            showSlide(nextIndex);
        }

        function prevSlide() {
            const prevIndex = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(prevIndex);
        }

        function startSlideShow() {
            slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        // Initialize slider
        showSlide(0);
        startSlideShow();

        // Event listeners for navigation
        document.getElementById('next-slide').addEventListener('click', () => {
            clearInterval(slideInterval);
            nextSlide();
            startSlideShow();
        });

        document.getElementById('prev-slide').addEventListener('click', () => {
            clearInterval(slideInterval);
            prevSlide();
            startSlideShow();
        });

        // Event listeners for indicators
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                clearInterval(slideInterval);
                showSlide(index);
                startSlideShow();
            });
        });

        // Pause on hover
        const slider = document.querySelector('.relative.h-96');
        slider.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        slider.addEventListener('mouseleave', () => {
            startSlideShow();
        });
    </script>


</body>
</html>
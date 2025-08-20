<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
    <!-- Hero Section -->
    <section class="relative h-96 flex items-center justify-center bg-gray-900 overflow-hidden">
        <div class="absolute inset-0">
            <img src="<?= base_url('public/assets/img/background1.png') ?>" 
                 alt="People helping each other" 
                 class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                Contact<span class="text-primary-500">Us</span>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto mb-8">
                Berbagi kebaikan semakin mudah. Pilih program, ikuti alur, dan saksikan dampaknya!
            </p>
        </div>
    </section>

    <!-- Main Content - Contact Information -->
<main class="container mx-auto px-4 py-12">
    <div class="flex justify-center">
        <div class="w-full max-w-7xl">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Contact Us</h2>
            
            <!-- Contact Cards - 3 cards horizontal -->
            <div class="flex flex-col md:flex-row justify-center gap-6 mb-12">
                <!-- Email Card -->
                <div class="w-full md:w-1/3 bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-primary-100 p-4 rounded-full mb-4">
                            <i class="fas fa-envelope text-primary-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Email Us</h3>
                        <p class="text-gray-600 mb-4">Kirim pertanyaan atau permintaan informasi melalui email kami</p>
                        <a href="mailto:<?= $its['email'] ?>" class="text-primary-500 hover:text-primary-600 font-medium"><?= $its['email'] ?></a>
                    </div>
                </div>

                <!-- Phone Card -->
                <div class="w-full md:w-1/3 bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-primary-100 p-4 rounded-full mb-4">
                            <i class="fas fa-phone-alt text-primary-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Call Us</h3>
                        <p class="text-gray-600 mb-4">Hubungi kami untuk informasi lebih lanjut atau bantuan darurat</p>
                        <div class="space-y-1">
                            <p class="text-gray-800 font-medium"><?= $its['phone'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Address Card -->
                <div class="w-full md:w-1/3 bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-transform hover:-translate-y-1">
                    <div class="flex flex-col items-center text-center">
                        <div class="bg-primary-100 p-4 rounded-full mb-4">
                            <i class="fas fa-map-marker-alt text-primary-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Visit Us</h3>
                        <p class="text-gray-600 mb-4">Kunjungi kantor kami untuk pertemuan langsung</p>
                        <p class="text-gray-800 font-medium"><?= $its['address'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Google Maps Embed with Marker -->
            <div class="w-full rounded-lg shadow-lg overflow-hidden mb-4">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.216367191464!2d110.9108294!3d-7.0908627!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDUnMjcuMSJTIDExMMKwNTQnMzkuMCJF!5e0!3m2!1sen!2sid!4v1623394253176!5m2!1sen!2sid&markers=color:red%7C-7.0908627,110.9108294" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"
                    class="w-full h-96"
                    title="Lokasi SDIT Al Firdaus Purwodadi">
                </iframe>
            </div>

        </div>
    </div>
</main>

<?= $this->endSection(); ?>
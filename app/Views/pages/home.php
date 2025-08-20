<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
    <!-- Hero Slider Section -->
    <section class="relative h-96 md:h-[32rem] overflow-hidden">
        <!-- Slides -->
        <div class="relative h-full w-full">
            
            <?php foreach ($programs as $p): ?>
            <div class="hero-slide">
                <div class="absolute inset-0 bg-gray-900">
                    <img src="<?= base_url('public/assets/img/'.$p['photo']) ?>" 
                         alt="People helping each other" 
                         class="w-full h-full object-cover opacity-50">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 to-transparent"></div>
                </div>
                <div class="container mx-auto px-4 h-full flex items-center justify-center text-center relative z-10">
                    <div>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 animate-fadeIn">
                            <?= $p['title'] ?></span>
                        </h1>
                        <p class="text-xl text-gray-200 max-w-2xl mx-auto mb-8">
                            <?= $p['description'] ?>
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="<?= base_url('program/'.$p['slug']) ?>" class="bg-primary-500 hover:bg-primary-600 text-white py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-lg">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <!-- Navigation Arrows -->
        <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition z-20">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full w-10 h-10 flex items-center justify-center transition z-20">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slide Indicators -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-20">
            <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-index="0"></button>
            <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-index="1"></button>
            <button class="slide-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" data-index="2"></button>
        </div>
    </section>
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-16">
        <!-- Featured Programs -->
        <section class="mb-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
                    Our Programs
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-primary-500 transform scale-x-75"></span>
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Berbagi kebaikan semakin mudah. Pilih program, ikuti alur, dan saksikan dampaknya!</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($catalog as $c): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-2">
                    <div class="relative">
                        <img src="<?= base_url('public/assets/img/'.$c['photo']) ?>" 
                             alt="Education program" 
                             class="w-full h-48 object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= $c['title'] ?></h3>
                        <p class="text-gray-600 mb-4"><?= word_limiter(strip_tags($p['description']), 12) ?>...</p>
                        <div class="flex justify-between text-gray-600 mb-4 text-sm">
                            <span><i class="fas fa-bullseye mr-1"></i> Target: Rp. <?= number_format($c['target_donate'],0,'.','.') ?></span>
                            <span><i class="fas fa-hand-holding-usd mr-1"></i> Terkumpul: Rp. <?= number_format($c['total_donate'],0,'.','.') ?></span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4">
                            <div class="bg-primary-500 h-2.5 rounded-full" style="width: <?= ($c['total_donate']/$c['target_donate']*100) ?>%"></div>
                        </div>
                        <a href="<?= base_url('program/'.$c['slug']) ?>" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg transition flex items-center justify-center">
                            <i class="fas fa-donate mr-2"></i> Donate Now
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- About Section -->
        <section class="mb-20 bg-white p-8 md:p-12 rounded-xl shadow-md">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
                        About Our Program
                        <span class="absolute bottom-0 left-0 w-full h-1 bg-primary-500 transform scale-x-75"></span>
                    </h2>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <img src="<?= base_url('public/assets/img/'.$its['logo']) ?>" 
                             alt="Our team helping people" 
                             class="rounded-lg shadow-lg w-full h-auto">
                    </div>
                    <div>
                        <p class="text-gray-700 mb-6 text-lg">
                            <?= $its['description'] ?>
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="<?= base_url('program') ?>" class="bg-primary-500 hover:bg-primary-600 text-white py-3 px-8 rounded-lg transition transform hover:scale-105 shadow-lg flex items-center">
                                <i class="fas fa-donate mr-2"></i> Donate Now
                            </a>
                            <a href="<?= base_url('contact') ?>" class="border border-primary-500 text-primary-500 hover:bg-primary-50 py-3 px-8 rounded-lg transition transform hover:scale-105 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i> Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?= $this->endSection(); ?>


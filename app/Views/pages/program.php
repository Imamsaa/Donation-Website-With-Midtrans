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
                Program<span class="text-primary-500">Donasi</span>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto mb-8">
                Berbagi kebaikan semakin mudah. Pilih program, ikuti alur, dan saksikan dampaknya!
            </p>
        </div>
    </section>

    <!-- Main Content - Program List -->
    <main class="container mx-auto px-4 py-12">
        <div class="flex justify-center">
            <div class="w-full max-w-7xl">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Our Donation Programs</h2>
                
                <!-- Program Cards Grid - Centered with wrapping -->
                <div class="flex flex-wrap justify-center gap-6">
                    <?php foreach($program as $p) : ?>
                    <!-- Program Card 1 -->
                    <div class="w-full sm:w-80 bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-transform hover:-translate-y-1">
                        <div class="h-48 overflow-hidden">
                            <img src="<?= base_url('public/assets/img/'.$p['photo']) ?>" 
                                 alt="Education program" 
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2"><?= $p['title'] ?></h3>
                            <div class="flex justify-between text-gray-600 mb-4">
                                <span >Target: Rp. <?= number_format($p['target_donate'],0,'.','.') ?></span>
                                <span>Terkumpul: Rp. <?= number_format($p['total_donate'],0,'.','.') ?></span>
                            </div>
                            <a href="<?= base_url('program/'.$p['slug']) ?>" 
                            class="block w-full bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded transition text-center">
                                Donate Now
                            </a>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>

                <!-- Pagination -->
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        </div>
    </main>

<?= $this->endSection(); ?>


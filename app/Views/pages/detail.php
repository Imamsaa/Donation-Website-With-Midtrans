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
                Detail<span class="text-primary-500">Program</span>
            </h1>
            <p class="text-xl text-gray-200 max-w-2xl mx-auto mb-8">
                Berbagi kebaikan semakin mudah. Pilih program, ikuti alur, dan saksikan dampaknya!
            </p>
        </div>
    </section>

    <!-- Program Details Section -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Large Image Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <img src="<?= base_url('public/assets/img/'.$program['photo']) ?>" 
                     alt="Education program" 
                     class="w-full h-64 md:h-96 object-cover">
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-col justify-between gap-6 mb-6">
                        <!-- Funding Status - Vertical Layout -->
                        <div class="bg-gray-100 p-6 rounded-lg">
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Target</h3>
                                <p class="text-2xl font-bold text-gray-800">Rp. <?= number_format($program['target_donate'],0,'.','.') ?></p>
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">Terpenuhi</h3>
                                <p class="text-2xl font-bold text-primary-500">Rp. <?= number_format($program['total_donate'],0,'.','.') ?></p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary-500 h-2.5 rounded-full" style="width: <?= ($program['total_donate']/$program['target_donate']*100) ?>%"></div>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4"><?= $program['title'] ?></h2>
                            <p class="text-gray-700">
                                <?= $program['description'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Donation Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Form Donation</h2>
                <form action="<?= base_url('midtrans') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <input type="hidden" name="program_id" value="<?= $program['program_id'] ?>">
                        <input type="hidden" name="referral" value="<?= $referral ?>">
                        <div>
                            <label for="first_name" class="block text-gray-700 mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?= old('first_name') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="last_name" class="block text-gray-700 mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?= old('last_name') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="<?= old('email') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label for="amount" class="block text-gray-700 mb-2">Donation Amount (Rp)</label>
                            <input type="number" id="amount" name="amount" value="<?= old('amount') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                    <div class="flex items-center mb-6">
                        <input type="checkbox" name="anonim" value="iya" id="anonim" class="w-4 h-4 text-primary-500 rounded border-gray-300 focus:ring-primary-500">
                        <label for="anonim" class="ml-2 block text-gray-700 font-medium">Donate Anonymously</label>
                    </div>
                    <button type="submit" class="w-full bg-primary-500 hover:bg-primary-600 text-white py-3 px-6 rounded-md font-medium transition">
                        Donate Now
                    </button>
                </form>
            </div>
        </div>
    </main>

<?= $this->endSection(); ?>
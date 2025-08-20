
    <?php
    use App\Models\InstansiModel;
    $instansiModel = new InstansiModel();
    $its = $instansiModel->first();
    ?>
    <!-- Top Contact Bar with Social Media -->
    <div class="bg-gray-100 py-2 border-b border-gray-200 hidden md:block">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-6">
                    <span class="text-gray-700 hover:text-primary-500 transition text-sm flex items-center">
                        <i class="fas fa-envelope mr-2 text-primary-500"></i> <?= $its['email'] ?>
                    </span>
                    <span class="text-gray-700 hover:text-primary-500 transition text-sm flex items-center">
                        <i class="fas fa-phone mr-2 text-primary-500"></i> <?= $its['phone'] ?>
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?= $its['facebook'] ?>" target="_blank" class="text-gray-500 hover:text-blue-600 transition" aria-label="Facebook">
                        <i class="fab fa-facebook-f text-lg"></i>
                    </a>
                    <a href="<?= $its['instagram'] ?>" target="_blank" class="text-gray-500 hover:text-pink-600 transition" aria-label="Instagram">
                        <i class="fab fa-instagram text-lg"></i>
                    </a>
                    <a href="<?= $its['website'] ?>" target="_blank" class="text-gray-500 hover:text-red-600 transition" aria-label="YouTube">
                        <i class="fab fa-internet-explorer text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <img src="<?= base_url('public/uploads/profiles/'.session()->get('photo')); ?>" alt="Logo" class="h-10 w-10 mr-3 rounded-full">
                    <span class="text-xl font-bold text-gray-800"><?= $its['name'] ?></span></span>
                </div>
                <nav class="hidden md:block">
                    <ul class="flex space-x-8">
                        <li>
                            <a href="<?= base_url('') ?>" class="px-3 py-2 text-gray-700 hover:text-primary-500 transition relative group">
                                Home
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('program') ?>" class="px-3 py-2 text-gray-700 hover:text-primary-500 transition relative group">
                                Program
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('contact') ?>" class="px-3 py-2 text-gray-700 hover:text-primary-500 transition relative group">
                                Contact
                                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 group-hover:w-full"></span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url('login') ?>" class="ml-4 px-4 py-2 bg-primary-500 text-white rounded-md hover:bg-primary-600 transition flex items-center">
                                <i class="fas fa-user-circle mr-2"></i> Login
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary-500 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-3">
                <ul class="space-y-3">
                    <li>
                        <a href="<?= base_url('') ?>" class="block px-3 py-2 text-gray-700 hover:text-primary-500 transition border-l-4 border-primary-500 pl-4">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('program') ?>" class="block px-3 py-2 text-gray-700 hover:text-primary-500 transition border-l-4 border-transparent pl-4 hover:border-primary-500">
                            <i class="fas fa-project-diagram mr-2"></i> Program
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('contact') ?>" class="block px-3 py-2 text-gray-700 hover:text-primary-500 transition border-l-4 border-transparent pl-4 hover:border-primary-500">
                            <i class="fas fa-envelope mr-2"></i> Contact
                        </a>
                    </li>
                    <li>
                        <a href="<?= base_url('login') ?>" class="block px-3 py-2 text-gray-700 hover:text-primary-500 transition border-l-4 border-transparent pl-4 hover:border-primary-500">
                            <i class="fas fa-user-circle mr-2"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
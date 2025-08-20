<?php
// Ambil total halaman & current page
$pager->setSurroundCount(1);
?>
<div class="flex justify-center mt-12">
    <nav class="inline-flex rounded-md shadow">
        <!-- Tombol Previous -->
        <?php if ($pager->hasPrevious()) : ?>
            <a href="<?= $pager->getPreviousPage() ?>"
               class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left"></i>
            </a>
        <?php else: ?>
            <span class="px-3 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-gray-400">
                <i class="fas fa-chevron-left"></i>
            </span>
        <?php endif; ?>

        <!-- Nomor Halaman -->
        <?php foreach ($pager->links() as $link) : ?>
            <a href="<?= $link['uri'] ?>"
               class="px-4 py-2 border-t border-b border-gray-300 
               <?= $link['active'] ? 'bg-white text-primary-500 font-medium' : 'bg-white text-gray-500 hover:bg-gray-50' ?>">
                <?= $link['title'] ?>
            </a>
        <?php endforeach ?>

        <!-- Tombol Next -->
        <?php if ($pager->hasNext()) : ?>
            <a href="<?= $pager->getNextPage() ?>"
               class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right"></i>
            </a>
        <?php else: ?>
            <span class="px-3 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-gray-400">
                <i class="fas fa-chevron-right"></i>
            </span>
        <?php endif; ?>
    </nav>
</div>

{{-- PAGINATION --}}
<div class="flex justify-end items-center w-full">
    <!-- Previous Button (Hidden on First Page) -->
    <template x-if="currentPage > 1">
        <button @click="prevPage()"
            class="py-0.5 px-1.5 text-xs rounded-l-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition">
            ❮
        </button>
    </template>

    <!-- Page Numbers -->
    <template x-for="page in visiblePages()" :key="page">
        <button @click="currentPage = page"
            class="py-0.5 px-1.5 text-xs font-semibold transition"
            :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200' "
            x-text="page">
        </button>
    </template>

    <!-- Next Button (Hidden on Last Page) -->
    <template x-if="currentPage < totalPages()">
        <button @click="nextPage()"
            class="py-0.5 px-1.5 text-xs rounded-r-md border border-gray-300 text-gray-500 bg-white hover:bg-gray-200 transition">
            ❯
        </button>
    </template>
</div>

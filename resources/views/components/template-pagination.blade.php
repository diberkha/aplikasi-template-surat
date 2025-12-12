<div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-between border-t border-gray-200 dark:border-gray-700"
     x-data="templatePagination()">
    <div class="flex items-center space-x-2">
        <span class="text-sm text-gray-600 dark:text-gray-300">Items per page:</span>
        <select x-model.number="itemsPerPage"
            class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white">
            <option>5</option>
            <option>10</option>
            <option>15</option>
            <option>20</option>
        </select>
    </div>
    <div class="flex items-center space-x-2">
        <button @click="prevPage()" :disabled="currentPage === 1"
            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
            <i class="fas fa-chevron-left"></i>
        </button>

        <template x-for="page in pages()" :key="page">
            <button @click="goToPage(page)"
                class="min-w-[38px] px-3 py-1 rounded-lg border text-sm font-semibold transition-colors"
                :class="page === currentPage
                    ? 'bg-green-600 text-white border-green-600 shadow-sm'
                    : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600'">
                <span x-text="page"></span>
            </button>
        </template>

        <button @click="nextPage()" :disabled="currentPage === totalPages"
            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    <div class="text-sm text-gray-600 dark:text-gray-300">
        <span x-text="startItem"></span> -
        <span x-text="endItem"></span>
        dari
        <span x-text="filteredTemplates().length"></span>
    </div>
</div>
<script>
function templatePagination() {
    return {
        itemsPerPage: 10,
        currentPage: 1,
        templates: @json($templates),
        get totalPages() {
            return Math.max(1, Math.ceil(this.filteredTemplates().length / this.itemsPerPage));
        },
        pages() {
            const total = this.totalPages;
            if (total <= 10) return Array.from({ length: total }, (_, i) => i + 1);

            let start = Math.max(1, this.currentPage - 4);
            let end = start + 9;
            if (end > total) {
                end = total;
                start = Math.max(1, end - 9);
            }
            return Array.from({ length: end - start + 1 }, (_, i) => start + i);
        },
        goToPage(page) {
            this.currentPage = page;
        },
        get startItem() {
            return this.filteredTemplates().length === 0 ? 0 : (this.currentPage - 1) * this.itemsPerPage + 1;
        },
        get endItem() {
            return Math.min(this.currentPage * this.itemsPerPage, this.filteredTemplates().length);
        },
        paginatedTemplates() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = this.currentPage * this.itemsPerPage;
            return this.filteredTemplates().slice(start, end);
        },
        nextPage() {
            if (this.currentPage < this.totalPages) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        filteredTemplates() {
            return this.templates;
        }
    }
}
</script>

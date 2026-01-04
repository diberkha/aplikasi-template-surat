<div class="px-4 sm:px-6 py-4 bg-gray-50 dark:bg-gray-800 flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 dark:border-gray-700"
     x-data="templatePagination()">
    <div class="flex items-center space-x-2">
        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden sm:inline">Items per page:</span>
        <select x-model.number="itemsPerPage"
            class="border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1 dark:bg-gray-700 dark:text-white text-xs sm:text-sm">
            <option>5</option>
            <option>10</option>
            <option>15</option>
            <option>20</option>
        </select>
    </div>
    <div class="flex items-center space-x-1 sm:space-x-2">
        <button @click="prevPage()" :disabled="currentPage === 1"
            class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <i class="fas fa-chevron-left"></i>
        </button>

        <template x-for="(page, index) in pages()" :key="index">
            <button @click="page !== '...' && goToPage(page)"
                class="h-8 min-w-[32px] sm:h-10 sm:min-w-[40px] px-2 sm:px-3 flex items-center justify-center rounded-lg border text-xs sm:text-sm font-semibold transition-colors"
                :class="page === currentPage
                    ? 'bg-green-600 text-white border-green-600 shadow-sm'
                    : (page === '...' 
                        ? 'border-transparent text-gray-500 dark:text-gray-400 cursor-default' 
                        : 'bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600')"
                :disabled="page === '...'">
                <span x-text="page"></span>
            </button>
        </template>

        <button @click="nextPage()" :disabled="currentPage === totalPages"
            class="h-8 w-8 sm:h-10 sm:w-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 disabled:opacity-40 text-xs sm:text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 w-full sm:w-auto text-center sm:text-left">
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
             if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);

             const current = this.currentPage;
             const range = [1];

             if (current > 3) range.push('...');

             let start = Math.max(2, current - 1);
             let end = Math.min(total - 1, current + 1);

             if (current <= 3) {
                 end = 4;
             }

             if (current >= total - 2) {
                 start = total - 3;
             }

             for (let i = start; i <= end; i++) {
                 range.push(i);
             }

             if (current < total - 2) range.push('...');

             range.push(total);
             
             return range;
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

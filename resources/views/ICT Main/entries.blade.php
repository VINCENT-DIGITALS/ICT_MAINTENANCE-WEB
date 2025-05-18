<div class="flex items-center justify-between mt-2 p-2  text-xs text-gray-500">
    <!-- ✅ Entries Count -->
    <span class="w-64"
        x-text="'Showing ' + ((currentPage - 1) * perPage + 1) + ' to ' + Math.min(currentPage * perPage, data.length) + ' of ' + data.length + ' entries'"></span>

    <!-- ✅ Pagination -->
    @include('ICT MAIN.pagnation')
</div>

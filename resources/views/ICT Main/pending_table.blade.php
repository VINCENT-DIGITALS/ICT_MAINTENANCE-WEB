<x-layout>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("tableDatapend", () => ({
                selectedStatus: "pending",
                currentPage: 1,
                perPage: 9,

                data: [
                    @foreach ($pendingRequests as $pendingRequest)
                        {
                            id: '{{ $pendingRequest->id }}',
                            subject: '{{ $pendingRequest->request_title }}',
                            description: '{{ $pendingRequest->request_description }}',
                            category: '{{ $pendingRequest->category->category_name }}',
                            office: '{{ $pendingRequest->location }}',
                            status: '{{ $pendingRequest->is_paused ? 'Paused' : 'Pending' }}',
                            date_requested: '{{ \Carbon\Carbon::parse($pendingRequest->created_at)->format('M-d-Y h:i A') }}',
                            date_updated: '{{ \Carbon\Carbon::parse($pendingRequest->updated_at)->format('M-d-Y') }}',
                            date_completion: 'N/A', // Add logic if you have a completion date
                            contact: '{{ $pendingRequest->local_no }}',
                            requester: 'Requester ID: {{ $pendingRequest->requester_id }}',
                            actual_client: 'N/A' // Add logic if you have actual client data
                        },
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ],


                // Computed: Get filtered & paginated data
                get paginatedData() {
                    let filteredData = this.data.filter(item =>
                        this.selectedStatus === "pending" ? item.status === "Pending" : item.status === "Paused"
                    );

                    let start = (this.currentPage - 1) * this.perPage;
                    let end = start + this.perPage;

                    return filteredData.slice(start, end);
                },

                // Computed: Total pages based on filtered data
                totalPages() {
                    return Math.ceil(this.data.filter(item =>
                        this.selectedStatus === 'pending' ? item.status === 'Pending' : item.status === 'Paused'
                    ).length / this.perPage);
                },

                // Computed: Visible page numbers (max 5 at a time)
                visiblePages() {
                    let total = this.totalPages();
                    let start = Math.max(1, this.currentPage - 2);
                    let end = Math.min(total, start + 3);

                    if (end - start < 4) {
                        start = Math.max(1, end - 3);
                    }

                    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
                },

                // Actions: Change status filter
                changeStatus(status) {
                    this.selectedStatus = status;
                    this.currentPage = 1; // Reset to page 1 when changing status
                },

                // Actions: Next & Previous Page
                nextPage() {
                    if (this.currentPage < this.totalPages()) {
                        this.currentPage++;
                    }
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                }
            }));
        });

    </script>
</x-layout>

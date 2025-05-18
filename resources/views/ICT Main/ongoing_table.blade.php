<x-layout>
    <script>
    document.addEventListener("alpine:init", () => {
        // Table Data with Pagination
        Alpine.data("tableDataongo", () => ({
            selectedStatus: "ongoing",
            currentPage: 1,
            perPage: 9,

            data: [
                    @foreach ($ongoingRequests as $ongoingRequest)
                        {
                            id: '{{ $ongoingRequest->id }}',
                            subject: '{{ $ongoingRequest->request_title }}',
                            description: '{{ $ongoingRequest->request_description }}',
                            category: '{{ $ongoingRequest->category->category_name }}',
                            office: '{{ $ongoingRequest->location }}',
                            status: '{{ $ongoingRequest->is_paused ? 'Paused' : 'Ongoing' }}',
                            date_requested: '{{ \Carbon\Carbon::parse($ongoingRequest->created_at)->format('M-d-Y h:i A') }}',
                            date_updated: '{{ \Carbon\Carbon::parse($ongoingRequest->updated_at)->format('M-d-Y') }}',
                            date_completion: 'N/A', // Add logic if you have a completion date
                            contact: '{{ $ongoingRequest->local_no }}',
                            requester: 'Requester ID: {{ $ongoingRequest->requester_id }}',
                            actual_client: 'N/A' // Add logic if you have actual client data
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                ],

            // Computed: Get filtered & paginated data
            get paginatedData() {
                let filteredData = this.data.filter(item =>
                    this.selectedStatus === "ongoing" ? item.status === "Ongoing" : item.status === "Paused"
                );

                let start = (this.currentPage - 1) * this.perPage;
                let end = start + this.perPage;

                return filteredData.slice(start, end);
            },

            // Computed: Total pages based on filtered data
            totalPages() {
                return Math.ceil(this.data.filter(item =>
                    this.selectedStatus === 'ongoing' ? item.status === 'Ongoing' : item.status === 'Paused'
                ).length / this.perPage);
            },

            // Computed: Visible page numbers (max 5 at a time)
            visiblePages() {
                let total = this.totalPages();
                let start = Math.max(1, this.currentPage - 2);
                let end = Math.min(total, start + 3 );

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

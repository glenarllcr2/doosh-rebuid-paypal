@if ($pendingRequests->isEmpty())
    <p class="text-muted">No pending friend requests.</p>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($pendingRequests as $requester)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                {{-- {{ $requester->display_name }} --}}
                <x-UserCard :user="$requester" mode="receive-suggestion" />

            </div>
        @endforeach
    </div>
@endif
</div>

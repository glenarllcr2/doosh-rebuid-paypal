@if ($blockedUsers->isEmpty())
    <p class="text-muted">You have not blocked any users.</p>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($blockedUsers as $blockedUser)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <x-UserCard :user="$blockedUser" mode="blocks" />
            </div>
        @endforeach
    </div>
@endif

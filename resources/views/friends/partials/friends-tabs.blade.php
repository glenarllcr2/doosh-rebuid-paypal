@if ($friends->isEmpty())
    <p class="text-muted">You have no friends yet.</p>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($friends as $friend)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <x-UserCard :user="$friend" mode="friends" />
            </div>
        @endforeach
    </div>

@endif

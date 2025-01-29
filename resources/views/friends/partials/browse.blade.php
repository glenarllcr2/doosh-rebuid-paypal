@if ($suggestions->isEmpty())
    <p class="text-muted">You have not suggestion any users.</p>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($suggestions as $suggestion)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                <x-UserCard :user="$suggestion" mode="suggestions" />
            </div>
        @endforeach
    </div>
@endif

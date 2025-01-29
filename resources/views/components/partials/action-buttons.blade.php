{{-- حالت دسکتاپ: نمایش دکمه‌ها --}}
<div class="d-none d-md-inline">
    @foreach ($buttons as $button)
        <form action="{{ route($button['route'], $user->id) }}" method="{{ $button['method'] }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-dark btn-sm">{{ $button['text'] }}</button>
        </form>
    @endforeach
    <!-- Report User -->
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#reportUserModal">
        Report User
    </button>
</div>

{{-- حالت موبایل: نمایش Dropdown --}}
<div class="d-md-none text-end">
    <div class="dropdown">
        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-cog"></i> {{-- آیکون چرخ‌دنده --}}
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            @foreach ($buttons as $button)
                <li>
                    <form action="{{ route($button['route'], $user->id) }}" method="{{ $button['method'] }}">
                        @csrf
                        <button type="submit" class="dropdown-item">{{ $button['text'] }}</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</div>

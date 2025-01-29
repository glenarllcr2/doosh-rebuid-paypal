@if ($recommended)
    <div class="card mb-3 shadow-none p-2 text-white"
        style="max-width: 340px; height: 150px; background: linear-gradient(to right, #053b79, #bff8ff);">
@else
    <div class="card mb-3 shadow-none p-2" style="max-width: 340px; height: 150px;">
@endif

<div class="row g-0 h-100">

    <div class="col-md-4 d-flex align-items-center justify-content-center">
        
        <p class="fs2 fw-bold text-center">{{ $duration }} Month<br /> <span class="fw-normal">{{ $price }}/M</span>
        </p>
    </div>


    <div class="col-md-8 h-100">
        <div class="d-flex flex-column justify-content-between align-items-end h-100">

            <div class="text-end fs-7">{{ $recommended ? 'Our Recommended' : '' }}</div>
            <strong>{{ $name }} </strong>
            <div class="text-end">Pick your plan</div>
        </div>
    </div>
</div>
    </div>


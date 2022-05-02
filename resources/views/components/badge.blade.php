@if (!isset($show) || $show)
    <span class="badge badge-{{ $type ?? 'success' }} bg-success">
        {{ $slot }}
    </span>   
@endif
<div class="card shadow-sm {{ $class ?? '' }}">
    @if(isset($header))
        <div class="card-header bg-white">
            {{ $header }}
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="card-footer bg-white">
            {{ $footer }}
        </div>
    @endif
</div>
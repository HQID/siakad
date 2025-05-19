<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                {{ $header }}
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
        @if(isset($footer))
            <tfoot>
                <tr>
                    {{ $footer }}
                </tr>
            </tfoot>
        @endif
    </table>
</div>
<!-- Sistem Informasi Akademik Universitas Tadulako -->
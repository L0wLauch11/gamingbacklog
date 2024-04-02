<div {{ $attributes->merge(['class' => "modal"]) }}>
    <div class="modal-content">
        <span class="modal-close" onclick="modalClose()">&times;</span>
        {{ $slot }}
    </div>
</div>

<div class="modal-background"></div>
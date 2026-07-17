<div class="vault-atmosphere">
    <div class="fog-layer-1"></div>
    <div class="fog-layer-2"></div>
    <div class="fog-layer-3"></div>
    <div class="light-ray"></div>
    <div class="light-ray-2"></div>

    @for ($i = 0; $i < 22; $i++)
        <div class="dust-particle"
             style="left: {{ rand(2, 98) }}%;
                    animation-duration: {{ rand(16, 30) }}s;
                    animation-delay: {{ rand(0, 18) }}s;">
        </div>
    @endfor
</div>
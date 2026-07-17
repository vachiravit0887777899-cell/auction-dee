<div x-data="{
        show: false,
        init() {
            if (!sessionStorage.getItem('vault_entered')) {
                this.show = true;
                sessionStorage.setItem('vault_entered', '1');
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    this.show = false;
                    document.body.style.overflow = '';
                }, 2600);
            }
        }
     }"
     x-show="show"
     x-transition:leave="transition ease-in duration-700"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[999] bg-vault-black flex items-center justify-center"
     style="display: none;">

    <div class="absolute inset-0 flex">
        <div class="w-1/2 h-full bg-vault-obsidian border-r border-gold/20 origin-left"
             x-data
             x-init="setTimeout(() => $el.style.transform = 'translateX(-100%)', 400)"
             style="transition: transform 1.6s cubic-bezier(0.76, 0, 0.24, 1);"></div>
        <div class="w-1/2 h-full bg-vault-obsidian border-l border-gold/20 origin-right"
             x-data
             x-init="setTimeout(() => $el.style.transform = 'translateX(100%)', 400)"
             style="transition: transform 1.6s cubic-bezier(0.76, 0, 0.24, 1);"></div>
    </div>

    <div class="relative text-center" x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
        <div class="w-16 h-16 mx-auto border-2 border-gold-soft rounded-full flex items-center justify-center animate-pulse"
             style="box-shadow: 0 0 40px 10px rgba(207,174,69,0.35);">
            <i data-lucide="gem" class="w-7 h-7 text-gold-soft"></i>
        </div>
        <p class="mt-5 text-[11px] uppercase tracking-[4px] text-gold-soft">Unlocking The Vault</p>
    </div>
</div>
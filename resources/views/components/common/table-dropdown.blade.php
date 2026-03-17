<div x-data="{
    isOpen: false,
    popperInstance: null,
    init() {
        this.$nextTick(() => {
            this.popperInstance = createPopper(this.$refs.button, this.$refs.content, {
                placement: 'top-start',
                strategy: 'absolute',
                modifiers: [
                    {
                        name: 'offset',
                        options: {
                            offset: [0, 4],
                        },
                    },
                ],
            });
        });
    },
    toggle() {
        this.isOpen = !this.isOpen;
        if (this.popperInstance) {
            this.popperInstance.update();
        }
    }
}"
@click.away="isOpen = false" class="relative">
    <div @click="toggle()" x-ref="button" class="cursor-pointer">
        {{ $button }}
    </div>

    <div class="z-50 absolute" x-ref="content" style="left: auto; right: 100%; top: 0;">
        <div x-show="isOpen" x-cloak class="p-2 bg-white border border-gray-200 rounded-2xl shadow-lg dark:border-gray-800 dark:bg-gray-dark w-40">
            <div class="space-y-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                {{ $content }}
            </div>
        </div>
    </div>
</div>

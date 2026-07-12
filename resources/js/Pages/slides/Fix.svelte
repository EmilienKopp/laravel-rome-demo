<script>
    import { Slide, Transition } from "@animotion/core";

    const repo = "github.com/EmilienKopp/laravel-rome";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-7xl font-black tracking-tight">
            DB views aren’t <span class="text-red-500">dangerous</span>.
        </p>
    </Transition>
    <Transition visible class="mt-6">
        <p class="text-4xl font-light text-white/60">
            They solve <span class="text-white">real problems</span>. They just
            needed <span class="text-white">better tooling</span>.
        </p>
    </Transition>

    <!-- package CTA + QR -->
    <Transition class="mt-16">
        <div class="flex items-center gap-12">
            <img
                src="/rome-qr.svg"
                alt="GitHub repo QR code"
                class="size-48 rounded-2xl bg-white p-3"
            />

            <div class="text-left">
                <p class="text-6xl font-black">
                    laravel-<span class="text-red-500">rome</span>
                </p>
                <p class="mt-3 text-2xl font-light text-white/50">{repo}</p>

                <ul
                    class="mt-6 space-y-2 text-xl font-light text-white/55 list-none"
                >
                    <li>
                        <span class="text-red-500">›</span>
                        View-aware Eloquent models — read-only, write-back proxy
                    </li>
                    <li>
                        <span class="text-red-500">›</span>
                        <span class="font-mono text-white/70">make:dbview</span>
                        /
                        <span class="font-mono text-white/70">dbview:regen</span
                        >
                        — scaffold &amp; regenerate views
                    </li>
                    <li>
                        <span class="text-red-500">›</span>
                        PHPStan rules — catch misuse at build time
                    </li>
                </ul>
            </div>
        </div>
    </Transition>
</Slide>

<script>
    import { Slide, Transition } from "@animotion/core";
    import QrCode from "../../components/QrCode.svelte";
    import { page } from "@inertiajs/svelte";

    const repo = "github.com/EmilienKopp/laravel-rome";
    const surveyUrl = $derived(page.props.surveyUrl);
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible class="mt-8">
        <p class="text-9xl">🙏</p>

        <p class="text-7xl font-black tracking-tight">
            Thank <span class="text-red-500">you</span>.
        </p>

        <p class="text-2xl font-light text-white/50">
            Built with
            <span class="text-white/80">Laravel</span> ·
            <span class="text-white/80">Inertia</span> ·
            <span class="text-white/80">Svelte</span>
            — slides powered by
            <span class="text-white/80">Animotion</span>.
        </p>

        <div class="flex items-center gap-12 mt-24">
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

                <ul class="mt-6 space-y-2 text-xl font-light text-white/55">
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

    <Transition visible class="mt-8">
        <p class="text-2xl font-light text-white/50">
            <span class="text-white">Try it out</span> and let me know what you think!
        </p>
        <div>
            <QrCode {surveyUrl} size={160} />
            <a
                href={surveyUrl}
                target="_blank"
                class="mt-3 block text-xl font-light text-white/50 hover:text-white/80"
            >
                Take the survey
            </a>
        </div>
    </Transition>
</Slide>

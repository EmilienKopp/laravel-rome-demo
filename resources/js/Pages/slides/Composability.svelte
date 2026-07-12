<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-9xl font-black tracking-tight">
            One <span class="text-red-500">definition</span>.
        </p>
    </Transition>
    <Transition class="mt-6">
        <p class="text-6xl font-black text-white/90">Consumed everywhere.</p>
    </Transition>
    <Transition class="mt-12">
        <p class="text-2xl font-light tracking-wide text-white/50">
            Inside your app...
        </p>
    </Transition>
    <Transition class="mt-8">
        <div class="flex flex-col items-center gap-5">
            <p class="text-2xl font-light tracking-wide text-white/50">
                ... and in ...
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                {#each ["PostgREST", "Metabase", "Grafana", "dbt"] as tool}
                    <span
                        class="rounded-xl border border-red-500/30 bg-red-500/10 px-6 py-3 text-4xl font-black tracking-tight text-white"
                    >
                        {tool}
                    </span>
                {/each}
            </div>
        </div>
    </Transition>
    <Transition class="mt-12">
        <p class="text-4xl font-black tracking-tight text-white/90">
            Your app and your BI tools
            <span class="text-red-500">read the same aggregation</span>.
        </p>
    </Transition>
    <Transition class="mt-6">
        <p class="text-3xl font-light text-white/60">
            Define it once. <span class="text-white">Never</span> re-implement
            the same joins and sums in a second place.
        </p>
    </Transition>
</Slide>

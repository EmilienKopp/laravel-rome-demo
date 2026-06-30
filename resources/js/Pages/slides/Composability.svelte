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
    <Transition class="mt-12">
        <p class="text-2xl font-light tracking-wide text-white/50">
            ... and in PostgREST · Metabase · Grafana · dbt ...
        </p>
    </Transition>
    <Transition class="mt-12">
        <p class="text-3xl font-light tracking-wide text-white/50">
            Your app and your BI tools <span class="text-red-500"
                >read the same thing</span
            >.
        </p>
    </Transition>
</Slide>

<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-8xl font-black tracking-tight">
            So views are <span class="text-red-500">great</span>.
        </p>
    </Transition>
    <Transition class="mt-10">
        <p class="text-5xl font-light text-white/70">
            But somehow... we don't use them.
        </p>
    </Transition>
</Slide>

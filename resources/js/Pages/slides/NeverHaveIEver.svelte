<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-2xl font-light uppercase tracking-[0.3em] text-white/40">
            A little game
        </p>
    </Transition>

    <Transition class="mt-8">
        <h1 class="text-[9rem] font-black leading-none tracking-tighter">
            Never have I <span class="text-red-500">ever</span>...
        </h1>
    </Transition>
</Slide>

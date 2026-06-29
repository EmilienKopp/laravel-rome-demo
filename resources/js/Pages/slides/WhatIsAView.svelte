<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center text-center">
    <Transition visible>
        <p class="text-8xl font-black tracking-tight">
            A view is a <span class="text-red-500">read repository</span>.
        </p>
    </Transition>
    <Transition class="mt-10">
        <p class="text-4xl font-light text-white/70">Written in SQL.</p>
    </Transition>
</Slide>

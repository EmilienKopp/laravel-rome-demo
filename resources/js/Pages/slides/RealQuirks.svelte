<script>
    import { Slide, Transition } from "@animotion/core";
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-7xl font-black tracking-tight">
            The <span class="text-red-500">other</span> problem
        </p>
    </Transition>

    <Transition class="mt-6">
        <p class="text-center text-4xl font-light text-white/60">
            ORMs are not view-friendly.
        </p>
    </Transition>

    <ul
        class="mt-14 list-none space-y-8 text-left text-4xl font-light text-white/70"
    >
        <Transition>
            <li>
                <span class="mr-3 text-red-500">›</span>
                Simple views are <span class="text-white">updatable</span> — the
                DB won’t always stop you
            </li>
        </Transition>
        <Transition>
            <li>
                <span class="mr-3 text-red-500">›</span>
                <span class="text-white">No scaffolding</span> — no
                <span class="font-mono text-white/70">make:dbview</span>, no
                migration story
            </li>
        </Transition>
        <Transition>
            <li>
                <span class="mr-3 text-red-500">›</span>
                <span class="text-white">Invisible</span> — no ORM model, no IDE
                support, nothing
            </li>
        </Transition>
    </ul>

    <Transition class="mt-14">
        <p class="text-2xl font-light italic text-white/50">
            These are all very valid reasons to hesitate.
        </p>
    </Transition>
</Slide>

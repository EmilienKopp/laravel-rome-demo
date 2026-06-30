<script>
    import { Slide, Transition } from "@animotion/core";

    // "the general opinion" -> "the reality"
    let phase = $state("opinion");
</script>

<Slide class="h-full place-content-center place-items-center">
    <div class="text-left">
        <Transition visible>
            <p class="mb-16 text-6xl font-black tracking-tight">
                {phase === "opinion" ? "The general opinion" : "The reality"}
            </p>
        </Transition>

        <div
            class="grid grid-cols-[auto_auto_1fr] items-baseline gap-x-10 gap-y-9 text-5xl"
        >
            <span class="font-semibold text-white">Triggers</span>
            <span class="text-white/25">→</span>
            <span>
                💥
                {#if phase === "reality"}
                    <span class="ml-3 text-2xl font-light text-white/40">
                        side effects, invisible mutations
                    </span>
                {/if}
            </span>

            <span class="font-semibold text-white">Stored procedures</span>
            <span class="text-white/25">→</span>
            <span>
                💥
                {#if phase === "reality"}
                    <span class="ml-3 text-2xl font-light text-white/40">
                        hidden behavior, split logic
                    </span>
                {/if}
            </span>

            <span class="font-semibold text-white">DB views</span>
            <span class="text-white/25">→</span>
            <span>
                {#if phase === "opinion"}
                    💥
                {:else}
                    ✅
                    <span class="ml-3 font-bold text-white">
                        just a query with a name
                    </span>
                {/if}
            </span>
        </div>
    </div>

    <!-- step: flip "opinion" -> "reality" -->
    <Transition
        do={() => (phase = "reality")}
        undo={() => (phase = "opinion")}
    />
</Slide>

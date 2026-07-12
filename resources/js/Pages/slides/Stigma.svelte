<script>
    import { Slide, Transition, Action } from "@animotion/core";

    // The DB-views row flips from 💥 to ✅ on the final step.
    let phase = $state("opinion");
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <div class="text-center">
            <h1 class="text-8xl mb-4">
                The <span class="text-red-500">Stigma</span>
            </h1>
            <p class="text-6xl font-subtle italic tracking-tight">
                “No logic in the DB”
            </p>
            <p class="mt-6 text-3xl font-light text-white/60">
                A legitimate rule — aimed at the wrong target.
            </p>
        </div>
    </Transition>

    <!-- Same offenders, revealed one at a time. -->
    <div
        class="mt-16 grid grid-cols-[auto_auto_1fr] items-baseline gap-x-10 gap-y-8 text-5xl"
    >
        <Transition class="contents">
            <span class="font-semibold text-white">Triggers</span>
            <span class="text-white/25">→</span>
            <span>
                💥
                <span class="ml-3 text-2xl font-light text-white/40">
                    side effects, invisible mutations
                </span>
            </span>
        </Transition>

        <Transition class="contents">
            <span class="font-semibold text-white">Stored procedures</span>
            <span class="text-white/25">→</span>
            <span>
                💥
                <span class="ml-3 text-2xl font-light text-white/40">
                    hidden behavior, split logic
                </span>
            </span>
        </Transition>

        <Transition class="contents">
            <span class="font-semibold text-white">DB views</span>
            <span class="text-white/25">→</span>
            <span>
                {#if phase === "opinion"}
                    💥
                {:else}
                    ✅
                    <span class="ml-3 text-3xl font-bold text-white">
                        just a query with a name
                    </span>
                {/if}
            </span>
        </Transition>
    </div>

    <!-- Final step: flip the verdict on views. -->
    <Action do={() => (phase = "reality")} undo={() => (phase = "opinion")} />
</Slide>

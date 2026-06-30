<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            Flat. <span class="text-red-500">Sortable</span>. Paginated.
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                ActiveSubscriptionUsage::query()
                    ->orderByDesc('total_usage') // ✅ just a column
                    ->paginate(20);
            `;
        }}
        class="mt-12 w-full max-w-4xl rounded-xl border border-white/10 bg-white/3 px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={``}
            options={codeOptions}
        />
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/60">
            The sort we couldn’t write — now trivial.
        </p>
    </Transition>
</Slide>

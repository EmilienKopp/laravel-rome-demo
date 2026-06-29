<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-9xl font-black tracking-tight">
            JOIN <span class="text-red-500">hell</span>
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                public function getActiveSubscriptionsWithUsage()
                {
                    return Subscription::query()
                        ->join('tenants', /* ... */)
                        ->join('plans', /* ... */)
                        ->join('billing_periods', /* ... */)
                        ->leftJoin('usage_records', /* ... */)
                        ->select([/* 12 columns */])
                        ->selectRaw('SUM(usage_records.quantity) as total')
                        ->groupBy([/* same 12 columns */])
                        ->get();
                }
            `;
        }}
        class="mt-12 w-full max-w-5xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
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
            This is SQL wearing a PHP costume.
        </p>
    </Transition>
</Slide>

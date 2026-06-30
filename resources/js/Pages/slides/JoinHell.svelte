<script>
    import { Slide, Transition, Code, Action } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
    const initialCode = `
        public function getActiveSubscriptionsWithUsage()
        {
            return Subscription::query()
                // TODO: join tenants, plans, billing_periods, usage_records
                ->get();
        }
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-9xl font-black tracking-tight">
            JOIN <span class="text-red-500">hell</span>
        </p>
    </Transition>

    <Transition
        class="mt-12 w-full max-w-5xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={initialCode}
            options={codeOptions}
        />

        <Action
            undo={() => {
                code.update`
                    public function getActiveSubscriptionsWithUsage()
                    {
                        return Subscription::query()
                            // TODO: join tenants, plans, billing_periods, usage_records
                            ->get();
                    }
                `;
            }}
            do={() => {
                code.update`   
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
        ></Action>

        <Action
            do={() => {
                code.selectLines`4-10`;
            }}
        ></Action>
    </Transition>
</Slide>

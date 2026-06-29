<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            SQL <span class="text-red-500">sprawl</span>
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                Subscription::query()
                    ->join('tenants', /* tenant_id */)
                    ->leftJoin('usage_records', /* ... */)
                    ->selectRaw('SUM(usage_records.quantity) as usage')
                    ->whereRaw('subscriptions.cancelled_at IS NULL')
                    ->groupByRaw('subscriptions.id, tenants.name')
                    ->get();
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
            You’re already writing SQL. Just
            <span class="text-red-500">badly</span>.
        </p>
    </Transition>
</Slide>

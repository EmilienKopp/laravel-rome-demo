<script>
    import { Slide, Transition, Code, Action } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
    let phase = $state("wish"); // wish | php | join

    const initialCode = `
        // "Just sort active subscriptions by how much they've used."
        Subscription::with(['tenant', 'plan'])
            ->orderByDesc('total_usage') // ❌ no such column
            ->paginate(20);
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            Just one little <span class="text-red-500">sort</span>
        </p>
    </Transition>

    <Transition
        class="mt-10 w-full max-w-5xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={initialCode}
            options={codeOptions}
        />
    </Transition>

    <!-- Escape hatch A: pull everything and sort in memory -->
    <Action
        undo={() => {
            code.update`${initialCode}`;
            phase = "wish";
        }}
        do={async () => {
            await code.update`
                // Load every row, then sort in PHP…
                Subscription::with(['tenant', 'plan', 'billingPeriods.usageRecords'])
                    ->get()
                    ->sortByDesc(fn ($s) => $s->billingPeriods
                        ->flatMap->usageRecords->sum('quantity'));
                // …goodbye database-level pagination.
            `;
            phase = "php";
        }}
    ></Action>

    <!-- Escape hatch B: join + groupBy just to enable ORDER BY -->
    <Action
        undo={() => (phase = "php")}
        do={async () => {
            await code.update`
                // …or reach for joins, just to ORDER BY.
                Subscription::query()
                    ->leftJoin('billing_periods', /* ... */)
                    ->leftJoin('usage_records', /* ... */)
                    ->groupBy(/* every selected column */)
                    ->orderByRaw('SUM(usage_records.quantity) DESC');
            `;
            phase = "join";
        }}
    ></Action>
</Slide>

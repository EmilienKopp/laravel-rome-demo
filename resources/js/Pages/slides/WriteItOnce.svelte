<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            Write it <span class="text-red-500">once</span>
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                CREATE VIEW active_subscriptions_with_usage AS
                SELECT s.*, t.name AS tenant_name,
                       COALESCE(SUM(ur.quantity), 0) AS total_usage
                FROM subscriptions s
                JOIN tenants t            ON t.id = s.tenant_id
                LEFT JOIN usage_records ur ON ur.subscription_id = s.id
                WHERE s.cancelled_at IS NULL
                GROUP BY s.id, t.name;
            `;
        }}
        class="mt-12 w-full max-w-5xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="sql"
            theme={codeTheme}
            code={``}
            options={codeOptions}
        />
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/60">
            The exact same logic. Named. Reusable.
        </p>
    </Transition>
</Slide>

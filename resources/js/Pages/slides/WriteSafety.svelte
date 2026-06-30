<script>
    import { Slide, Transition, Code, Action } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;

    const initialCode = `
        class ActiveSubscriptionUsage extends Model
        {
            protected $table = 'active_subscription_usage';
        }

        ActiveSubscriptionUsage::all();
    `;

    const dangerCode = `
        class ActiveSubscriptionUsage extends Model
        {
            protected $table = 'active_subscription_usage';
        }

        $row = ActiveSubscriptionUsage::first();
        $row->update(['price' => 42]); // 💥 can't UPDATE a view
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-7xl font-black tracking-tight">
            But it’s still a <span class="text-red-500">Model</span>
        </p>
    </Transition>

    <Transition
        class="mt-10 w-full max-w-4xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={initialCode}
            options={codeOptions}
        />
    </Transition>

    <!-- The danger: a plain model over a view still accepts writes -->
    <Action
        undo={() => code.update`${initialCode}`}
        do={async () => {
            await code.update`${dangerCode}`;
            code.selectLines`7`;
        }}
    ></Action>
</Slide>

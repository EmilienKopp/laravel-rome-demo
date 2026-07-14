<script>
    import { Slide, Transition, Action, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            What we <span class="text-red-500">need</span>
        </p>
    </Transition>

    <Transition class="mt-4">
        <p class="text-center text-4xl font-light text-white/70">
            First-class <span class="text-white">citizenship</span>.
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                use Splitstack\\Rome\\Models\\ReadOnlyModel;

                class ActiveSubscriptionUsage extends ReadOnlyModel
                {
                    protected $table = 'active_subscription_usage';
                }

                $row = ActiveSubscriptionUsage::first();
                $row->update(['price' => 42]);            // ❌ ReadOnlyModelException
                ActiveSubscriptionUsage::orderBy('total_usage')->paginate(); // ✅ works
            `;
        }}
        class="mt-12 w-full max-w-4xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={``}
            options={codeOptions}
        />
    </Transition>

    <!-- Proxy lines appear on next step and get highlighted -->
    <Action
        do={async () => {
            await code.update`
                use Splitstack\\Rome\\Models\\ReadOnlyModel;

                class ActiveSubscriptionUsage extends ReadOnlyModel
                {
                    protected $table = 'active_subscription_usage';
                    protected $proxyTo = 'App\\Models\\Subscription';
                }

                $row = ActiveSubscriptionUsage::first();
                $row->update(['price' => 42]);            // ❌ ReadOnlyModelException
                ActiveSubscriptionUsage::orderBy('total_usage')->paginate(); // ✅ works
                $row->proxied()->update(['price' => 42]); // ✅ explicit, intentional
            `;
            code.selectLines`6,12`;
        }}
        undo={async () => {
            await code.update`
                use Splitstack\\Rome\\Models\\ReadOnlyModel;

                class ActiveSubscriptionUsage extends ReadOnlyModel
                {
                    protected $table = 'active_subscription_usage';
                }

                $row = ActiveSubscriptionUsage::first();
                $row->update(['price' => 42]);            // ❌ ReadOnlyModelException
                ActiveSubscriptionUsage::orderBy('total_usage')->paginate(); // ✅ works
            `;
            code.selectLines`*`;
        }}
    />
</Slide>

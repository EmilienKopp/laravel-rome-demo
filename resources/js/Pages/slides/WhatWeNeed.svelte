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
                    protected $proxyTo = 'App\\Models\\Subscription';
                }

                $row = ActiveSubscriptionUsage::first();
                $row->update(['price' => 42]);            // ❌ ReadOnlyModelException
                $row->proxied()->update(['price' => 42]); // ✅ explicit, intentional
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

    <!-- Highlight the two lines that make the point: blocked by default,
         explicit when you mean it. -->
    <Action undo={() => code.selectLines`*`} do={() => code.selectLines`10-11`} />
</Slide>

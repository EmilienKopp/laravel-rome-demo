<script>
    import { Slide, Transition, Action, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;
    // A fragment can reveal itself but never un-reveal itself on a later step,
    // so the only thing that needs a flag is the bullets fading out when the
    // code arrives. Everything else is a plain <Transition>.
    let codeShown = $state(false);
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-8xl font-black tracking-tight">
            What we <span class="text-red-500">need</span>
        </p>
    </Transition>

    <Transition class="mt-6">
        <p class="text-center text-4xl font-light text-white/70">
            First-class <span class="text-white">citizenship</span>.
        </p>
    </Transition>

    <!-- Bullets and code overlap in one cell; the code step cross-fades them. -->
    <Transition class="mt-14 grid w-full max-w-4xl place-items-center">
        <ul
            class="col-start-1 row-start-1 list-none space-y-6 text-left text-3xl font-light text-white/65 transition-opacity duration-500 {codeShown
                ? 'opacity-0'
                : 'opacity-100'}"
        >
            <li>
                <span class="mr-3 text-red-500">›</span>
                Preconfigured <span class="text-white">read-only</span> model
            </li>
            <li>
                <span class="mr-3 text-red-500">›</span>
                <span class="text-white">Proxy</span> ergonomics
                <span class="block pl-8 text-2xl text-white/40">
                    read &amp; write as one object with two targets
                </span>
            </li>
            <li>
                <span class="mr-3 text-red-500">›</span>
                Easy, timestamped <span class="text-white">scaffolding</span> of
                views &amp; migrations
                <div
                    class="mt-6 flex w-full max-w-4xl items-center gap-3 rounded-xl border border-white/10 bg-black/40 px-8 py-5 font-mono text-2xl"
                >
                    <span class="text-emerald-400">❯</span>
                    <span class="text-white">make:dbview</span>
                    <span
                        class="ml-0.5 inline-block h-6 w-2.5 animate-pulse bg-white/70"
                    ></span>
                </div>
            </li>
            <li>
                <span class="mr-3 text-red-500">›</span>
                Easy view regeneration,
                <span class="text-white">multitenancy-proof</span>
                <div
                    class="mt-6 flex w-full max-w-4xl items-center gap-3 rounded-xl border border-white/10 bg-black/40 px-8 py-5 font-mono text-2xl"
                >
                    <span class="text-emerald-400">❯</span>
                    <span class="text-white"
                        >dbview:regen --tenants acme,laravel,fireship</span
                    >
                    <span
                        class="ml-0.5 inline-block h-6 w-2.5 animate-pulse bg-white/70"
                    ></span>
                </div>
            </li>
        </ul>

        <div
            class="col-start-1 row-start-1 w-full rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6 transition-opacity duration-500 {codeShown
                ? 'opacity-100'
                : 'opacity-0'}"
        >
            <Code
                bind:this={code}
                lang="php"
                theme={codeTheme}
                code={``}
                options={codeOptions}
            />
        </div>
    </Transition>

    <!-- The fix made real: bullets fade out as the ReadOnlyModel fades in. -->
    <Action
        undo={() => (codeShown = false)}
        do={async () => {
            codeShown = true;
            await code.update`
                use Splitstack\\Rome\\Models\\ReadOnlyModel;

                class ActiveSubscriptionUsage extends ReadOnlyModel
                {
                    protected $table = 'active_subscription_usage';
                    protected $proxyTo = 'App\\Models\\Subscription';
                }

                $row = ActiveSubscriptionUsage::first();
                $row->update(['price' => 42]); // ❌ ReadOnlyModelException
                $row->proxied()->update(['price' => 42]); // EXPLICIT proxied update works
                ActiveSubscriptionUsage::orderBy('computed_column')
                    ->paginate(); // Still easy, flat, sortable, and paginatable
            `;
            code.selectLines`3,6,10-13`;
        }}
    ></Action>
</Slide>

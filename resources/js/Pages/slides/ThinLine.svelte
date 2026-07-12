<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let phpCode;
    let sqlCode;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-7xl font-black tracking-tight">
            The <span class="text-red-500">thin line</span>
        </p>
    </Transition>

    <div class="mt-12 grid w-full max-w-6xl grid-cols-2 gap-8">
        <!-- Left: the query you already wrote, wrapped in PHP -->
        <Transition
            do={async () => {
                await phpCode.update`
                    Subscription::query()
                        ->selectRaw('...')
                        ->whereRaw('...')
                        ->groupByRaw('...');
                `;
            }}
            class="rounded-xl border border-white/10 bg-white/[0.03] px-6 py-5"
        >
            <p class="mb-4 text-2xl font-light text-white/50">
                SQL sprawl in PHP
            </p>
            <Code
                bind:this={phpCode}
                lang="php"
                theme={codeTheme}
                code={``}
                options={codeOptions}
            />
        </Transition>

        <!-- Right: the exact same query, named and stored -->
        <Transition
            do={async () => {
                await sqlCode.update`
                    CREATE VIEW ... AS
                    SELECT ...
                    FROM ...
                    WHERE ...
                    GROUP BY ...;
                `;
            }}
            class="rounded-xl border border-red-500/20 bg-red-500/[0.04] px-6 py-5"
        >
            <p class="mb-4 text-2xl font-light text-red-400/70">
                Database view
            </p>
            <Code
                bind:this={sqlCode}
                lang="sql"
                theme={codeTheme}
                code={``}
                options={codeOptions}
            />
        </Transition>
    </div>

    <Transition class="mt-12">
        <p class="text-center text-3xl font-light text-white/60">
            The only difference: did you give it a
            <span class="text-white">name</span> and put it in the
            <span class="text-red-500">database</span>?
        </p>
    </Transition>
</Slide>

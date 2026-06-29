<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let { rows = [] } = $props();
    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-7xl font-black tracking-tight">
            What is a <span class="text-red-500">view</span>?
        </p>
    </Transition>

    <Transition
        do={async () => {
            await code.update`
                CREATE VIEW product_report_view AS
                SELECT p.name AS product_name,
                       c.name AS category_name,
                       p.price,
                       ROUND(p.price * 1.2, 2) AS price_with_tax
                FROM products p
                JOIN categories c ON c.id = p.category_id;
            `;
        }}
        class="mt-10 w-full max-w-3xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
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
        <table class="text-2xl tabular-nums">
            <thead
                class="text-base font-medium uppercase tracking-widest text-white/35"
            >
                <tr>
                    <th class="px-5 py-2 text-left">Product</th>
                    <th class="px-5 py-2 text-left">Category</th>
                    <th class="px-5 py-2 text-right">Price</th>
                    <th class="px-5 py-2 text-right">+ Tax</th>
                </tr>
            </thead>
            <tbody>
                {#each rows as row}
                    <tr class="border-t border-white/5">
                        <td class="px-5 py-2 text-left text-white">
                            {row.product_name}
                        </td>
                        <td class="px-5 py-2 text-left text-white/55">
                            {row.category_name}
                        </td>
                        <td class="px-5 py-2 text-right text-white">
                            ${row.price}
                        </td>
                        <td class="px-5 py-2 text-right font-semibold text-red-400">
                            ${row.price_with_tax}
                        </td>
                    </tr>
                {/each}
            </tbody>
        </table>
    </Transition>
</Slide>

<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    // A model whose table is a view — that's the whole setup.
    const viewSqlDefinition = `
        CREATE VIEW "view_name" AS
            SELECT "user_id", 
                SUM("usage") AS "total_usage"
            FROM "reservations"
            JOIN /* ... */
            GROUP BY "user_id";
    `;

    const models = `
        class MyView extends Model
        {
            protected $table = 'view_name';
        }
    `;

    // Each pain point collapses to a single, boring Eloquent call.
    const sortFix = `
        // the sort we couldn’t write
        MyView::orderByDesc('total_usage')
            ->paginate();
    `;

    const joinFix = `
        // the join chain, gone
        MyView::where('user_id', $id)
            ->paginate();
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-7xl font-black tracking-tight">
            Database <span class="text-red-500">views</span> fix both of these.
        </p>
    </Transition>

    <div class="mt-6 grid w-full max-w-5xl grid-cols-2 gap-6">
        <Transition
            class="rounded-xl border border-white/10 bg-white/[0.03] px-6 py-4"
        >
            <p class="mb-3 text-xl font-light text-white/50">
                Write beautiful SQL
            </p>
            <Code
                lang="php"
                theme={codeTheme}
                code={viewSqlDefinition}
                options={codeOptions}
            />
        </Transition>

        <Transition
            class="rounded-xl border border-white/10 bg-white/[0.03] px-6 py-4"
        >
            <p class="mb-3 text-xl font-light text-white/50">
                Write a super lean model
            </p>
            <Code
                lang="php"
                theme={codeTheme}
                code={models}
                options={codeOptions}
            />
        </Transition>
    </div>

    <!-- Two fixes, revealed side by side to save height. -->
    <div class="mt-6 grid w-full max-w-5xl grid-cols-2 gap-6">
        <Transition
            class="rounded-xl border border-white/10 bg-white/[0.03] px-6 py-4"
        >
            <p class="mb-3 text-xl font-light text-white/50">Sorting</p>
            <Code
                lang="php"
                theme={codeTheme}
                code={sortFix}
                options={codeOptions}
            />
        </Transition>

        <Transition
            class="rounded-xl border border-white/10 bg-white/[0.03] px-6 py-4"
        >
            <p class="mb-3 text-xl font-light text-white/50">No JOIN hell</p>
            <Code
                lang="php"
                theme={codeTheme}
                code={joinFix}
                options={codeOptions}
            />
        </Transition>
    </div>

    <Transition class="mt-8">
        <p class="text-4xl font-black tracking-tight">
            ...and <span class="text-red-500">more</span>.
        </p>
    </Transition>
</Slide>

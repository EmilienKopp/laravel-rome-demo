<script>
    import { Slide, Transition, Code, Action } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let code;

    const base = `
        Reservation::query()
            ->get();
    `;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-9xl font-black tracking-tight">
            The <span class="text-red-500">join chain</span>
        </p>
    </Transition>

    <Transition
        class="mt-12 w-full max-w-5xl rounded-xl border border-white/10 bg-white/[0.03] px-8 py-6"
    >
        <Code
            bind:this={code}
            lang="php"
            theme={codeTheme}
            code={base}
            options={codeOptions}
        />

        <!-- Each hop up the ownership chain appears one join at a time. -->
        <Action
            undo={() => code.update`${base}`}
            do={() => {
                code.update`
                    Reservation::query()
                        ->join('rooms', /* ... */)
                        ->get();
                `;
            }}
        ></Action>

        <Action
            do={() => {
                code.update`
                    Reservation::query()
                        ->join('rooms', /* ... */)
                        ->join('properties', /* ... */)
                        ->get();
                `;
            }}
        ></Action>

        <Action
            do={() => {
                code.update`
                    Reservation::query()
                        ->join('rooms', /* ... */)
                        ->join('properties', /* ... */)
                        ->join('companies', /* ... */)
                        ->get();
                `;
            }}
        ></Action>

        <Action
            do={() => {
                code.update`
                    Reservation::query()
                        ->join('rooms', /* ... */)
                        ->join('properties', /* ... */)
                        ->join('companies', /* ... */)
                        ->join('company_user', /* ... */)
                        ->where('company_user.user_id', $user->id)
                        ->get();
                `;
            }}
        ></Action>

        <Action
            do={() => code.selectLines`6`}
        ></Action>
    </Transition>

    <Transition class="mt-10">
        <p class="text-3xl font-light text-white/60">
            Just to answer:
            <span class="italic text-white/80">
                “show me the reservations this user can see.”
            </span>
        </p>
    </Transition>
</Slide>

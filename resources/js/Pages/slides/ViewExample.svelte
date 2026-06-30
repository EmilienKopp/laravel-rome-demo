<script>
    import { Slide, Transition, Code } from "@animotion/core";
    import { codeTheme, codeOptions } from "./code.js";

    let { rows = [] } = $props();
    let code;
</script>

<Slide class="h-full place-content-center place-items-center">
    <Transition visible>
        <p class="text-center text-9xl font-black tracking-tight">
            What is a <span class="text-red-500">view</span>?
        </p>
    </Transition>
</Slide>

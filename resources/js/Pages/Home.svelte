<script>
    import { fade, fly } from "svelte/transition";
    import { Link } from "@inertiajs/svelte";
    import Logo from "../components/Logo.svelte";
    import { quadInOut } from "svelte/easing";

    const presentations = [
        {
            slug: "views-are-great",
            label: "Stop being scared of your database",
        },
    ];

    function sleep(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }
</script>

<div class="home">
    {#await sleep(100) then}
        <div transition:fade={{ duration: 2000, easing: quadInOut }}>
            <Logo style="width: 300px; height: 150px;" />
        </div>

        <ul>
            {#each presentations as { slug, label }, i}
                <li in:fly={{ duration: 600, delay: 1500 + i * 300, x: -1500 }}>
                    <Link href="/{slug}">/{label}</Link>
                </li>
            {/each}
        </ul>
    {/await}
</div>

<style>
    .home {
        background: #0a0a0a;
        --foreground: #ffffff;
        --background: #0a0a0a;
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 3rem 0 0;
        text-align: left;
    }

    :global(li a) {
        display: block;
        width: fit-content;
        margin-top: 1.5rem;
        font-family: ui-monospace, "Cascadia Code", "Source Code Pro", Menlo,
            Consolas, monospace;
        font-size: clamp(0.875rem, 2vw, 1.5rem);
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
    }

    :global(li a::after) {
        display: block;
        content: "";
        width: 0;
        border-bottom: 1px solid #ffffff;
        transition: width 0.4s ease-in-out;
    }

    :global(li a:hover) {
        transform: scale(1.05);
    }

    :global(li a:hover::after) {
        width: 100%;
    }
</style>

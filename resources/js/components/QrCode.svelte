<script lang="ts">
    import { onMount } from "svelte";
    import QRCode from "qrcode";

    interface Props {
        surveyUrl: string;
        svg?: string | null;
        size?: number;
    }

    let { surveyUrl: url, svg = null, size = 200 }: Props = $props();

    let generatedDataUrl = $state("");

    onMount(async () => {
        if (!svg) {
            generatedDataUrl = await QRCode.toDataURL(url, {
                width: size,
                margin: 2,
            });
        }
    });
</script>

<div class="flex flex-col items-center gap-3">
    {#if svg}
        <div
            style="width: {size}px; height: {size}px;"
            class="rounded overflow-hidden"
        >
            {@html svg}
        </div>
    {:else if generatedDataUrl}
        <img
            src={generatedDataUrl}
            alt="QR Code"
            width={size}
            height={size}
            class="rounded"
        />
    {:else}
        <div
            class="rounded border border-border bg-muted animate-pulse"
            style="width: {size}px; height: {size}px;"
        ></div>
    {/if}
</div>

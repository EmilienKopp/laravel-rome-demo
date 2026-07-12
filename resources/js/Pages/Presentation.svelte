<script>
    import { Presentation } from "@animotion/core";

    import Title from "./slides/Title.svelte";
    import FlattenToSort from "./slides/FlattenToSort.svelte";
    import DeepJoin from "./slides/DeepJoin.svelte";
    import ViewsFixThis from "./slides/ViewsFixThis.svelte";
    import OrDoWe from "./slides/OrDoWe.svelte";
    import ThinLine from "./slides/ThinLine.svelte";
    import Stigma from "./slides/Stigma.svelte";
    import OrmPurity from "./slides/OrmPurity.svelte";
    import RealQuirks from "./slides/RealQuirks.svelte";
    import WriteItOnce from "./slides/WriteItOnce.svelte";
    import WhatWeNeed from "./slides/WhatWeNeed.svelte";
    import Fix from "./slides/Fix.svelte";
    import ThankYou from "./slides/ThankYou.svelte";

    // real rows from the database view, passed from the route
    let { viewRows = [] } = $props();
</script>

<Presentation
    options={{
        history: true,
        transition: "fade",
        controls: true,
        progress: true,
    }}
>
    <Title />
    <FlattenToSort />
    <DeepJoin />
    <ViewsFixThis />
    <OrDoWe />
    <ThinLine />
    <Stigma />
    <OrmPurity />
    <RealQuirks />
    <WriteItOnce />
    <WhatWeNeed />
    <Fix />
    <ThankYou />
</Presentation>

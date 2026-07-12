<script>
    import { Presentation } from "@animotion/core";

    import Title from "./slides/Title.svelte";
    import FlattenToSort from "./slides/FlattenToSort.svelte";
    import DeepJoin from "./slides/DeepJoin.svelte";
    import ViewsFixThis from "./slides/ViewsFixThis.svelte";
    import WhatIsAView from "./slides/WhatIsAView.svelte";
    import NeverHaveIEver from "./slides/NeverHaveIEver.svelte";
    import WriteItOnce from "./slides/WriteItOnce.svelte";
    import Composability from "./slides/Composability.svelte";
    import ViewsAreGreat from "./slides/ViewsAreGreat.svelte";
    import OrDoWe from "./slides/OrDoWe.svelte";
    import ThinLine from "./slides/ThinLine.svelte";
    import Stigma from "./slides/Stigma.svelte";
    import OrmPurity from "./slides/OrmPurity.svelte";
    import RealQuirks from "./slides/RealQuirks.svelte";
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
    <!-- Poll the room here: "who knows what a view is?" — skip if most do. -->
    <WhatIsAView />
    <NeverHaveIEver />
    <FlattenToSort />
    <DeepJoin />
    <ViewsFixThis />
    <WriteItOnce />
    <Composability />
    <ViewsAreGreat />
    <OrDoWe />
    <ThinLine />
    <Stigma />
    <!-- <OrmPurity /> -->
    <RealQuirks />
    <WhatWeNeed />
    <Fix />
    <ThankYou />
</Presentation>

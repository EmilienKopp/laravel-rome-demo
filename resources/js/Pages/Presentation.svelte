<script>
    import { Presentation } from "@animotion/core";

    import Title from "./slides/Title.svelte";
    import Stigma from "./slides/Stigma.svelte";
    import OpinionVsReality from "./slides/OpinionVsReality.svelte";
    import Symptoms from "./slides/Symptoms.svelte";
    import JoinHell from "./slides/JoinHell.svelte";
    import SqlSprawl from "./slides/SqlSprawl.svelte";
    import FlattenToSort from "./slides/FlattenToSort.svelte";
    import ViewsFixThis from "./slides/ViewsFixThis.svelte";
    import ViewExample from "./slides/ViewExample.svelte";
    import WhatIsAView from "./slides/WhatIsAView.svelte";
    import WriteItOnce from "./slides/WriteItOnce.svelte";
    import RepositoryShrinks from "./slides/RepositoryShrinks.svelte";
    import FlatAndSortable from "./slides/FlatAndSortable.svelte";
    import Composability from "./slides/Composability.svelte";
    import WhyNotViews from "./slides/WhyNotViews.svelte";
    import WriteSafety from "./slides/WriteSafety.svelte";
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
    <Symptoms />
    <JoinHell />
    <SqlSprawl />
    <ViewsFixThis />
    <ViewExample rows={viewRows} />
    <WhatIsAView />
    <Composability />
    <WhyNotViews />
    <Stigma />
    <OpinionVsReality />
    <WriteItOnce />
    <RepositoryShrinks />
    <FlatAndSortable />
    <WriteSafety />
    <WhatWeNeed />
    <Fix />
    <ThankYou />
</Presentation>

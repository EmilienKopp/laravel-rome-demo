<script>
    import { Presentation } from "@animotion/core";

    import Title from "./slides/Title.svelte";
    import Stigma from "./slides/Stigma.svelte";
    import OpinionVsReality from "./slides/OpinionVsReality.svelte";
    import Symptoms from "./slides/Symptoms.svelte";
    import JoinHell from "./slides/JoinHell.svelte";
    import SqlSprawl from "./slides/SqlSprawl.svelte";
    import ViewExample from "./slides/ViewExample.svelte";
    import WhatIsAView from "./slides/WhatIsAView.svelte";
    import WriteItOnce from "./slides/WriteItOnce.svelte";
    import RepositoryShrinks from "./slides/RepositoryShrinks.svelte";
    import Composability from "./slides/Composability.svelte";
    import Fix from "./slides/Fix.svelte";

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
    <Symptoms />
    <JoinHell />
    <SqlSprawl />
    <Stigma />
    <OpinionVsReality />
    <ViewExample rows={viewRows} />
    <WhatIsAView />
    <WriteItOnce />
    <RepositoryShrinks />
    <Composability />
    <Fix />
</Presentation>

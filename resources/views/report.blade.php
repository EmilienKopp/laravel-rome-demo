<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laravel-rome demo — Product Report</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            background: #f8fafc;
            color: #1e293b;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 0 .25rem;
        }

        .subtitle {
            color: #64748b;
            font-size: .9rem;
            margin: 0;
        }

        .subtitle code {
            background: #e2e8f0;
            padding: 1px 5px;
            border-radius: 4px;
            font-size: .85rem;
        }

        .refresh-btn {
            display: flex;
            align-items: center;
            gap: .35rem;
            padding: .4rem .75rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            font-size: .8rem;
            cursor: pointer;
            transition: background .15s, border-color .15s, color .15s;
            flex-shrink: 0;
            margin-top: .2rem;
        }

        .refresh-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #334155;
        }

        .refresh-btn svg {
            transition: transform .5s ease;
        }

        .refresh-btn.spinning svg {
            transform: rotate(360deg);
        }

        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header {
            padding: .75rem 1.25rem;
            background: #f1f5f9;
            border-bottom: 1px solid #e2e8f0;
            font-size: .8rem;
            font-weight: 600;
            color: #475569;
            letter-spacing: .05em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: .7rem;
            letter-spacing: 0;
            text-transform: none;
            font-weight: 500;
        }

        .badge-view {
            background: #ede9fe;
            color: #6d28d9;
        }

        .badge-table {
            background: #dcfce7;
            color: #166534;
        }

        .badge-cat {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-off {
            background: #fee2e2;
            color: #b91c1c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .875rem;
        }

        /* column-group header row */
        thead tr.group-row th {
            padding: .4rem 1.25rem .3rem;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            border-bottom: none;
        }

        thead tr.group-row th.g-shared {
            background: #f8fafc;
            color: #94a3b8;
        }

        thead tr.group-row th.g-view {
            background: #f5f3ff;
            color: #7c3aed;
            border-radius: 6px 6px 0 0;
        }

        thead tr.group-row th.g-table {
            background: #f0fdf4;
            color: #166534;
            border-radius: 6px 6px 0 0;
        }

        thead tr.col-row th {
            padding: .55rem 1.25rem;
            font-size: .72rem;
            font-weight: 600;
            color: #64748b;
            letter-spacing: .04em;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
        }

        thead tr.col-row th.c-view {
            background: #faf8ff;
            color: #6d28d9;
        }

        thead tr.col-row th.c-table {
            background: #f8fffe;
            color: #15803d;
        }

        td {
            padding: .7rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        td.c-view {
            background: #fdfcff;
        }

        td.c-table {
            background: #fafffe;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            filter: brightness(.97);
        }

        .price {
            font-variant-numeric: tabular-nums;
        }

        .muted {
            color: #94a3b8;
            font-size: .8rem;
        }

        .na {
            color: #cbd5e1;
            font-style: italic;
            font-size: .8rem;
        }

        /* proxy panel */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 680px) {
            .two-col {
                grid-template-columns: 1fr;
            }
        }

        .proxy-box {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .proxy-box pre {
            margin: 0;
            padding: 1.25rem;
            font-size: .8rem;
            line-height: 1.7;
            background: #0f172a;
            color: #e2e8f0;
            overflow-x: auto;
        }

        .proxy-box pre .comment {
            color: #94a3b8;
        }

        .proxy-box pre .kw {
            color: #818cf8;
        }

        .proxy-box pre .cls {
            color: #34d399;
        }

        .proxy-box pre .str {
            color: #fbbf24;
        }

        .proxy-box pre .prop {
            color: #7dd3fc;
        }

        .attr-list {
            padding: 1rem 1.25rem;
            font-size: .8rem;
        }

        .attr-list dt {
            color: #64748b;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-top: .6rem;
        }

        .attr-list dd {
            margin: 0;
            font-weight: 500;
            color: #1e293b;
            font-family: monospace;
        }

        .attr-list .model-tag {
            display: inline-block;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            padding: 1px 6px;
            font-size: .7rem;
            margin-bottom: .4rem;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <div class="page">

        <div class="page-header">
            <div>
                <h1>Product Report</h1>
                <p class="subtitle">
                    <code>ProductReport</code> (<code>ReadOnlyModel</code>) backed by <code>product_report_view</code>
                    · proxied to <code>Product</code>
                </p>
            </div>
            <button class="refresh-btn" id="refreshBtn" onclick="doRefresh()">
                <svg id="refreshIcon" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                    <path d="M21 3v5h-5" />
                    <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                    <path d="M3 21v-5h5" />
                </svg>
                Refresh
            </button>
        </div>

        {{-- ── Report table ── --}}
        <div class="card">
            <div class="card-header">
                product_report_view
                <span class="badge badge-view">DB view · ProductReport</span>
                <span style="margin-left:auto; font-weight:400; text-transform:none; letter-spacing:0; color:#94a3b8">
                    + <span class="badge badge-table">products table · Product</span>
                </span>
            </div>
            <table>
                <thead>
                    <tr class="group-row">
                        <th class="g-shared" colspan="2"></th>
                        <th class="g-view" colspan="3">from view</th>
                        <th class="g-table" colspan="3">from products table</th>
                    </tr>
                    <tr class="col-row">
                        <th>ID</th>
                        <th>Active</th>
                        <th class="c-view">product_name</th>
                        <th class="c-view">category_name</th>
                        <th class="c-view">price_with_tax</th>
                        <th class="c-table">name</th>
                        <th class="c-table">price</th>
                        <th class="c-table">updated_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $row)
                        @php $raw = $rawProducts[$row->id] ?? null; @endphp
                        <tr>
                            <td class="price muted">{{ $row->id }}</td>
                            <td>
                                @if (!$row->active)
                                    <span class="badge badge-off">inactive</span>
                                @endif
                            </td>
                            <td class="c-view"><strong>{{ $row->product_name }}</strong></td>
                            <td class="c-view"><span class="badge badge-cat">{{ $row->category_name }}</span></td>
                            <td class="c-view price">${{ number_format($row->price_with_tax, 2) }}</td>
                            <td class="c-table">{{ $raw?->name ?? '—' }}</td>
                            <td class="c-table price">${{ $raw ? number_format($raw->price, 2) : '—' }}</td>
                            <td class="c-table muted">{{ $raw?->updated_at?->format('Y-m-d H:i') ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── HasReadOnlyMode panel ── --}}
        @if ($readonlyDemo)
        <div class="two-col" style="margin-bottom:2rem">
            <div>
                <div class="card-header" style="border-radius:10px 10px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
                    HasReadOnlyMode
                    <span class="badge" style="background:#fef3c7;color:#92400e">trait</span>
                </div>
                <div class="proxy-box">
                    <pre><span class="comment">// Add the trait to any writable model</span>
<span class="kw">use</span> <span class="cls">HasReadOnlyMode</span>;

<span class="comment">// readonly() — wraps $this, blocks writes</span>
<span class="prop">$ro</span> = <span class="cls">Product</span>::<span class="kw">find</span>(<span class="str">1</span>)-><span class="kw">readonly</span>()
<span class="prop">$ro</span>->name        <span class="comment">// ✓ reads pass through</span>
<span class="prop">$ro</span>-><span class="kw">update</span>([…]) <span class="comment">// ✗ ReadOnlyModelException</span>

<span class="comment">// proxy() — optionally switches to $readOnlyView,</span>
<span class="comment">// then wraps in ReadOnlyProxy</span>
<span class="kw">protected static</span> ?<span class="cls">string</span> <span class="prop">$readOnlyView</span> = <span class="str">'product_report_view'</span>;
<span class="cls">Product</span>::<span class="kw">find</span>(<span class="str">1</span>)-><span class="kw">proxy</span>() <span class="comment">// reads from view</span></pre>
                </div>
            </div>
            <div>
                <div class="card-header" style="border-radius:10px 10px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
                    readonly() result — first raw product
                    <span class="badge" style="background:#fef3c7;color:#92400e;margin-left:auto">ReadOnlyProxy</span>
                </div>
                <div class="proxy-box" style="border-radius:0 0 10px 10px">
                    <dl class="attr-list">
                        <div style="margin-bottom:.5rem">
                            <span class="model-tag" style="background:#fffbeb;color:#92400e;border-color:#fde68a">Splitstack\Rome\Models\ReadOnlyProxy</span>
                        </div>
                        @foreach ($readonlyDemo->getAttributes() as $key => $value)
                            <dt>{{ $key }}</dt>
                            <dd>{{ is_bool($value) ? ($value ? 'true' : 'false') : ($value ?? 'null') }}</dd>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
        @endif

        {{-- ── Proxy panel ── --}}
        <div class="two-col">
            <div>
                <div class="card-header"
                    style="border-radius:10px 10px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
                    ReadOnlyModel → proxied()
                    <span class="badge badge-view">$row->proxied()</span>
                </div>
                <div class="proxy-box">
                    <pre><span class="comment">// Read from the view — no writes allowed</span>
<span class="prop">$row</span> = <span class="cls">ProductReport</span>::<span class="kw">find</span>(<span class="str">1</span>)

<span class="comment">// proxied() → in-memory Product, no extra query</span>
<span class="comment">// $exclude strips category_name, price_with_tax…</span>
<span class="prop">$row</span>-><span class="kw">proxied</span>()     <span class="comment">// → Product {…}</span>

<span class="comment">// update() routes the write through Product</span>
<span class="prop">$row</span>-><span class="kw">update</span>([<span class="str">'price'</span> => <span class="str">99.99</span>])

<span class="comment">// underlying() → fresh DB query on products</span>
<span class="prop">$row</span>-><span class="kw">underlying</span>()  <span class="comment">// → Product (real fetch)</span></pre>
                </div>
            </div>

            @if ($proxyDemo)
                <div>
                    <div class="card-header"
                        style="border-radius:10px 10px 0 0; border:1px solid #e2e8f0; border-bottom:none;">
                        proxy() result — first row
                        <span class="badge badge-table" style="margin-left:auto">App\Models\Product</span>
                    </div>
                    <div class="proxy-box" style="border-radius:0 0 10px 10px">
                        <dl class="attr-list">
                            <div style="margin-bottom:.5rem">
                                <span class="model-tag">App\Models\Product</span>
                            </div>
                            @foreach ($proxyDemo->getAttributes() as $key => $value)
                                <dt>{{ $key }}</dt>
                                @if ($key === 'price')
                                    <dd>
                                        <form method="POST" action="{{ route('report.updatePrice', $proxyDemo->id) }}"
                                            style="display:flex;align-items:center;gap:.5rem;margin-top:.2rem">
                                            @csrf
                                            <input type="number" name="price" value="{{ $value }}"
                                                step="0.01" min="0"
                                                style="width:100px;padding:3px 7px;border:1px solid #cbd5e1;border-radius:6px;font-size:.85rem;font-family:monospace;color:#1e293b">
                                            <button type="submit"
                                                style="padding:3px 10px;background:#6366f1;color:#fff;border:none;border-radius:6px;font-size:.78rem;cursor:pointer">
                                                update
                                            </button>
                                        </form>
                                    </dd>
                                @else
                                    <dd>{{ is_bool($value) ? ($value ? 'true' : 'false') : $value ?? 'null' }}</dd>
                                @endif
                            @endforeach
                        </dl>
                    </div>
                </div>
            @endif
        </div>

    </div>

    <script>
        function doRefresh() {
            const btn = document.getElementById('refreshBtn');
            btn.classList.add('spinning');
            setTimeout(() => location.reload(), 300);
        }
    </script>
</body>

</html>

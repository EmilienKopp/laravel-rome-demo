# DB Views — Slide Outline

---

## Slide 1 — Title / Thesis
>
> "DB views aren't dangerous. They were dangerous because they were invisible."

Set up the talk: not here to sell views, here to debunk a category error that's been repeated long enough to become conventional wisdom.

---

## Slide 2 — What the stigma is actually about

The "no logic in the DB" rule was a legitimate reaction — to triggers, stored procedures, invisible mutations firing in the background. Valid concern. But views got caught in the same purge.

Behavior vs. Projection. Triggers mutate. Views don't. Treating them the same is a category error.

---

## Slide 3 — What a view actually is

A view is a Read Repository written in SQL.

Same thing as a complex repository method or QueryService — named, reusable, read-only. Just expressed in the language the DB speaks natively. Nobody calls a 50-line Eloquent query with 6 joins "domain logic". A view of the same query isn't either.

---

## Slide 4 — Debunking the objections

Three common ones, all collapse under scrutiny:

- *"Views put domain logic in the DB"* — the SQL is identical to what's in your repository. Only the location of the string changes.
- *"Views aren't testable"* — tests mock contracts (DTOs, interfaces), not mechanisms. The persistence layer behind the interface is invisible to the test by design.
- *"Views are hard to manage"* — they were, because they had no place to live. That's a tooling problem, not a views problem.

---

## Slide 5 — The schema is already domain modeling

Schema design at analysis time *is* domain modeling in a different syntax.

- A FK with cascade delete encodes "OrderLine cannot exist without Order" — that's a domain invariant in DDL
- Cardinality decisions are business rules about what the domain allows
- `UNIQUE(email)` is the domain saying "email is an identity"

The DB enforces domain invariants from the moment you make those decisions. Views are just the read surface of the same idea.

---

## Slide 6 — Composability: the underappreciated argument

A view is a first-class SQL object. Filter it, join it, layer it. Anything that speaks SQL can consume it — your app, a BI tool, a data pipeline — without going through your application layer.

Concrete: Metabase or Grafana pointed at your DB. Your customer success team builds their own dashboards on a view your app already uses. No API endpoint. No developer in the loop. One definition, consumed everywhere.

A complex repository method is locked inside your runtime. A view isn't.

---

## Slide 7 — Two shapes of view, both valid

- **Reporting views** — aggregations and projections for dashboards, analytics, non-technical consumers
- **Relational shortcut views** — collapsing a normalized join chain into a named, direct lookup that reflects a real domain relationship

Neither is domain logic. Both are just named projections the domain already understands.

Bonus: a well-named view is **documentation that executes**. Everyone who touches the DB — developers, analysts, Metabase users — shares the same definition instead of re-implementing the same joins independently.

---

## Slide 8 — What was actually missing / the fix

Views had no place to live in the application lifecycle. No version control, no migration order, no clear ownership. So they became invisible, and invisible things become scary.

The fix isn't avoiding views. It's giving them the same lifecycle as everything else — migrations, models, discoverability. Once they have that, they're just part of the app.

*[laravel-rome does this for Laravel.]*

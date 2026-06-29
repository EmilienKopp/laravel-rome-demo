// Shim for SvelteKit's `$app/environment`, used by @animotion/core
// so it can run inside a plain Vite + Inertia setup.
export const browser = typeof window !== 'undefined';
export const dev = import.meta.env.DEV;
export const building = false;
export const version = '';

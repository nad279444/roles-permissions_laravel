import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.tsx"],
            ssr: "resources/js/ssr.ts",
            refresh: true,
        }),
        react(),
    ],
    ssr: {
        noExternal: ["@inertiajs/server"],
    },
});

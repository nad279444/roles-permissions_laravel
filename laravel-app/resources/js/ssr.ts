import { createInertiaApp } from "@inertiajs/react";
import createServer from "@inertiajs/server";
import ReactDOMServer from "react-dom/server";
import React from "react";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const resolvePage = (name: string) => {
    try {
        return require(`./Pages/${name}.tsx`).default;
    } catch (e) {
        console.error(`Page not found: ${name}`);
        return require("./Pages/Welcome").default;
    }
};

createServer((page: any) =>
    createInertiaApp({
        page,
        render: ReactDOMServer.renderToString,
        title: (title: string) => `${title} - ${appName}`,
        resolve: (name: string) => resolvePage(name),
        setup: ({ App, props }: any) => {
            return React.createElement(App, props);
        },
    })
);

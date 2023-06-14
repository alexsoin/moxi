import { resolve } from "path";
import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import { viteSingleFile } from "vite-plugin-singlefile";
import { ViteMinifyPlugin } from "vite-plugin-minify";

export default defineConfig({
	resolve: {
		alias: {
			"@": resolve(__dirname, "src")
		}
	},
	plugins: [
		vue(),
		viteSingleFile(),
		ViteMinifyPlugin(),
	],
	build: {
		outDir: "../"
	}
});

import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./src/pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/components/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      colors: {
        "ei-bg": "#070D1A",
        "ei-card": "#0C1525",
        "ei-elevated": "#111E36",
        "ei-border": "#162038",
        "ei-border-light": "#1E2F4A",
        "ei-gold": "#C8962A",
        "ei-gold-light": "#E5B545",
        "ei-text": "#EEF2FF",
        "ei-muted": "#7B96C4",
        "ei-faint": "#3D5578",
      },
      fontFamily: {
        sans: ["var(--font-inter)", "system-ui", "sans-serif"],
      },
      animation: {
        "pulse-slow": "pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite",
      },
    },
  },
  plugins: [],
};

export default config;

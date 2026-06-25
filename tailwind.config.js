/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './pages/**/*.{js,ts,jsx,tsx,mdx}',
    './components/**/*.{js,ts,jsx,tsx,mdx}',
    './app/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        bg: '#080E1A',
        card: '#0D1829',
        'card-hover': '#111F35',
        border: '#1A2840',
        'border-light': '#243550',
        accent: '#C8A84B',
        'accent-light': '#D4B56A',
        'text-primary': '#EEE8D8',
        'text-muted': '#8090A8',
        'text-dim': '#4A5568',
      },
      fontFamily: {
        sans: ['var(--font-inter)', 'system-ui', 'sans-serif'],
      },
    },
  },
  plugins: [],
}

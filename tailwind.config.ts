import type { Config } from 'tailwindcss'

const config: Config = {
  content: [
    './app/**/*.{js,ts,jsx,tsx,mdx}',
    './components/**/*.{js,ts,jsx,tsx,mdx}',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          50: '#EEF3F8',
          100: '#D5E2EF',
          200: '#AAC5DF',
          300: '#7FA8CF',
          400: '#548BBF',
          500: '#3A6FA8',
          600: '#1B3A5C',
          700: '#142D47',
          800: '#0D1F31',
          900: '#07101A',
        },
        gold: {
          50: '#FBF6E9',
          100: '#F6EDD2',
          200: '#ECDA9F',
          300: '#E2C76C',
          400: '#D8B439',
          500: '#B8952A',
          600: '#9A7C1F',
          700: '#7C6318',
        },
      },
      fontFamily: {
        sans: ['var(--font-inter)', 'system-ui', 'sans-serif'],
      },
      letterSpacing: {
        tighter: '-0.04em',
        tight: '-0.025em',
      },
    },
  },
  plugins: [],
}

export default config

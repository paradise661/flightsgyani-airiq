/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "node_modules/preline/dist/*.js",
  ],
  theme: {
    container: {
      screens: {
        sm: "640px",
        md: "768px",
        lg: "1024px",
        xl: "1280px",
        "2xl": "1280px",
      },
    },
    screens: {
      xs: "480px",
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      "2xl": "1536px",
      "3xl": "1920px",
      "4xl": "2560px",
    },
    extend: {
      colors: {
        gray: {
          0: "rgb(var(--gray-0) / <alpha-value>)",
          50: "rgb(var(--gray-50) / <alpha-value>)",
          100: "rgb(var(--gray-100) / <alpha-value>)",
          200: "rgb(var(--gray-200) / <alpha-value>)",
          300: "rgb(var(--gray-300) / <alpha-value>)",
          400: "rgb(var(--gray-400) / <alpha-value>)",
          500: "rgb(var(--gray-500) / <alpha-value>)",
          600: "rgb(var(--gray-600) / <alpha-value>)",
          700: "rgb(var(--gray-700) / <alpha-value>)",
          800: "rgb(var(--gray-800) / <alpha-value>)",
          900: "rgb(var(--gray-900) / <alpha-value>)",
          1000: "rgb(var(--gray-1000) / <alpha-value>)",
        },
        // background: "rgb(var(--background) / <alpha-value>)",
        // foreground: "rgb(var(--foreground) / <alpha-value>)",
        // muted: "rgb(var(--muted) / <alpha-value>)",
        // "muted-foreground": "rgb(var(--muted-foreground) / <alpha-value>)",
        primary: {
          lighter: "rgb(var(--primary-lighter) / <alpha-value>)",
          DEFAULT: "rgb(var(--primary-default) / <alpha-value>)",
          dark: "rgb(var(--primary-dark) / <alpha-value>)",
          foreground: "rgb(var(--primary-foreground) / <alpha-value>)",
          background: "rgb(var(--primary-background) / <alpha-value>)",
        },
        secondary: {
          lighter: "rgb(var(--secondary-lighter) / <alpha-value>)",
          DEFAULT: "rgb(var(--secondary-default) / <alpha-value>)",
          dark: "rgb(var(--secondary-dark) / <alpha-value>)",
          foreground: "rgb(var(--secondary-foreground) / <alpha-value>)",
          background: "rgb(var(--secondary-background) / <alpha-value>)",
          bglighter: "rgb(var(--secondary-background-lighter) / <alpha-value>)",
        },
      },
      // animation: {
      //   blink: "blink 1.4s infinite both;",
      //   "scale-up": "scaleUp 500ms infinite alternate",
      //   "spin-slow": "spin 4s linear infinite",
      //   popup: "popup 500ms var(--popup-delay, 0ms) linear 1",
      //   skeleton: "skeletonWave 1.6s linear 0.5s infinite",
      //   "spinner-ease-spin": "spinnerSpin 0.8s ease infinite",
      //   "spinner-linear-spin": "spinnerSpin 0.8s linear infinite",
      // },
      // backgroundImage: {
      //   skeleton: `linear-gradient(90deg,transparent,#ecebeb,transparent)`,
      //   "skeleton-dark": `linear-gradient(90deg,transparent,rgba(255,255,255,0.1),transparent)`,
      // },
      // keyframes: {
      //   blink: {
      //     "0%": { opacity: "0.2" },
      //     "20%": { opacity: "1" },
      //     "100%": { opacity: "0.2" },
      //   },
      //   scaleUp: {
      //     "0%": { transform: "scale(0)" },
      //     "100%": { transform: "scale(1)" },
      //   },
      //   popup: {
      //     "0%": { transform: "scale(0)" },
      //     "50%": { transform: "scale(1.3)" },
      //     "100%": { transform: "scale(1)" },
      //   },
      //   skeletonWave: {
      //     "0%": {
      //       transform: "translateX(-100%)",
      //     },
      //     "50%": {
      //       /* +0.5s of delay between each loop */
      //       transform: "translateX(100%)",
      //     },
      //     "100%": {
      //       transform: "translateX(100%)",
      //     },
      //   },
      //   spinnerSpin: {
      //     "0%": {
      //       transform: "rotate(0deg)",
      //     },
      //     "100%": {
      //       transform: "rotate(360deg)",
      //     },
      //   },
      // },
      aspectRatio: {
        "16/9": "16 / 9",
        "4/3": "4 / 3",
        "30/11": "30 / 11",
        "21/9": "21 / 9",
        "18/5": "18 / 5",
        "4/3": "4 / 6",
        "4/3": "4 / 5",
      },
      // customForms: (theme) => ({
      //   default: {
      //     checkbox: {
      //       "&:indeterminate": {
      //         background:
      //           "url(\"data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='8' height='2' x='4' y='7' rx='1'/%3E%3C/svg%3E\");",
      //         borderColor: "transparent",
      //         backgroundColor: "currentColor",
      //         backgroundSize: "100% 100%",
      //         backgroundPosition: "center",
      //         backgroundRepeat: "no-repeat",
      //       },
      //     },
      //   },
      // }),
    },
  },
  plugins: [require("preline/plugin"), require("@tailwindcss/forms")],
}


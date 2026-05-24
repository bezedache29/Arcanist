/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./pages/**/*.php", "./views/**/*.php", "./components/**/*.php"],
  darkMode: "class", // On force l'utilisation du Dark Mode
  theme: {
    extend: {
      colors: {
        // Palette Violet Sombre (Fonds et cartes)
        arcane: {
          900: "#13072E", // Fond principal très sombre
          800: "#1F1147", // Fond des cartes
          700: "#321C6D", // Bordures et hover
          500: "#7C3AED", // Violet magique vif
        },
        // Palette Or (Boutons, accents, prix)
        mystic: {
          900: "#78350F", // Or sombre (ombres)
          500: "#F59E0B", // Or classique
          400: "#FBBF24", // Or brillant (hover)
          100: "#FEF3C7", // Texte sur fond or
        },
      },
      fontFamily: {
        // Police pour les gros titres (Ex: Playfair Display ou Cinzel)
        grimoire: ['"Playfair Display"', "serif"],
        // Police pour l'interface B2B (Ex: Inter ou Lato)
        ui: ['"Inter"', "sans-serif"],
      },
      boxShadow: {
        "glow-mystic": "0 0 15px -3px rgba(245, 158, 11, 0.4)",
        "glow-arcane": "0 0 20px -5px rgba(124, 58, 237, 0.3)",
      },
    },
  },
  plugins: [],
};

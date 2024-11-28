export default {
  // Omitted for brevity
  plugins: [
    svelte({
      // This tells svelte to run some preprocessing
      preprocess: sveltePreprocess({
        postcss: true, // And tells it to specifically run postcss!
      }),

      // Omitted for brevity
    }),

    // Omitted for brevity
  ],
  watch: {
    clearScreen: false,
  },
};

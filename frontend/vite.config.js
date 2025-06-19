import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  server: {
    host: true,
    port: 8080,
    strictPort: true,
  },
  define: {
    'process.env': {
      VITE_API_BASE_URL: 'https://api.laravel.satochi.com.br'
    }
  },
  build: {
    outDir: 'dist',
    assetsDir: 'assets',
    emptyOutDir: true,
    target: 'esnext'
  }
});
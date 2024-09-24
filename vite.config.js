import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: 'resources/js/app.jsx', // 或你的入口文件
      refresh: true,
    }),
  ], 
//   server:{
//     port:1573
// }
});

import imagemin     from 'imagemin-keep-folder'
import imageminWebp from 'imagemin-webp';

(async () => {
  await imagemin(['wp/wp-content/themes/**/images_orignal/**/*.{jpg,png}'], {
    //destination: 'build/images',
    plugins: [
      imageminWebp({ quality: 80 })
    ],
    replaceOutputDir: output => {
      return output.replace(/images_orignal\//, 'images/')
    }
  });
})();
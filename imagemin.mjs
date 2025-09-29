import imagemin         from 'imagemin-keep-folder'
//import imageminMozjpeg  from 'imagemin-mozjpeg'
//import imageminPngquant from 'imagemin-pngquant'
import imageminGifsicle from 'imagemin-gifsicle'
import imageminSvgo     from 'imagemin-svgo'

imagemin(['wp/wp-content/themes/**/images_orignal/**/*.{gif,svg}'], {
  plugins: [
    //imageminMozjpeg({ quality: 80 }),
    //imageminPngquant({ quality:[.65,.8]}),
    imageminGifsicle(),
    imageminSvgo({
      plugins: [{
        name: 'removeViewBox',
        active: false
      }]
    })
  ],
  replaceOutputDir: output => {
    return output.replace(/images_orignal\//, 'images/')
  }
});

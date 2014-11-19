module.exports = function(grunt) {
  grunt.initConfig({
    less: {
      development: {
        options: {
          //concat:true,
          //compress: true,
          //yuicompress: true,
          //optimization: 2

          // sourceMap: true,
          // sourceMapURL: 'styles.css.map',
          // sourceMapFilename: 'develop/assets/css/product/styles.css.map',

        },
        files: {
          "develop/assets/css/product/styles.css": "develop/assets/css/styles.less"
        }
      }
    },
    watch: {
      less: {
        files: ['develop/assets/css/*.less','develop/assets/css/libs/*.less'],
        tasks: ['less']
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.registerTask('default', 'watch');

};
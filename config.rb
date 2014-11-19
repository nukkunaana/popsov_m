# require 'autoprefixer-rails'

http_path = "/"
css_dir = "develop/assets/css/libs/compass/stylesheets"
sass_dir = "develop/assets/css/libs/compass/sass"
images_dir = "develop/assets/images"
# javascripts_dir = "js"

output_style = :expanded
# output_style = :expanded or :nested or :compact or :compressed

line_comments = false


# on_stylesheet_saved do |file|
#   css = File.read(file)
#   File.open(file, 'w') do |io|
#     io << AutoprefixerRails.process(css)
#   end
# end

# io << AutoprefixerRails.process(css)
# io << AutoprefixerRails.process(css, browsers: ["last 1 version", "> 1%"])


# Make a copy of sprites with a name that has no uniqueness of the hash.
on_sprite_saved do |filename|
  if File.exists?(filename)
    FileUtils.cp filename, filename.gsub(%r{-s[a-z0-9]{10}\.png$}, '.png')
    # Note: Compass outputs both with and without random hash images.
    # To not keep the one with hash, add: (Thanks to RaphaelDDL for this)
    FileUtils.rm_rf(filename)
  end
end

# Replace in stylesheets generated references to sprites
# by their counterparts without the hash uniqueness.
on_stylesheet_saved do |filename|
  if File.exists?(filename)
    css = File.read filename
    File.open(filename, 'w+') do |f|
      f << css.gsub(%r{-s[a-z0-9]{10}\.png}, '.png')
    end
  end
end
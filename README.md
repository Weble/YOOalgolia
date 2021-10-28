# Algolia elements for YOOtheme PRO

Plugin to add elements for displaying Algolia search results using VueInstantSearch in a YOOtheme  Pro template.

## Installation

Download [a release here on github](https://github.com/Weble/YOOalgolia/releases) and install it using Joomla Installer.

## Usage

1. Install the plugin
2. Enable it
3. Go the the YOOtheme settings and set the default algolia configurations
4. When you want to use Algolia results, go to a section in the YOOtheme builder and enable that section as an Algolia search area, in the advanced configuration of the section
5. Set any override of the algolia configuration you need there
6. Put any Algolia element inside of that section as you see fit

## Result templates

To display a result, you need to create a template first. You can either create it inside the `plugins/system/yooalgolia/builder/algolia_hits/templates/` folder or, better, inside a child's theme directory, like `templates/yootheme_child/builder/algolia_hits/templates/`.

The file **must** be named `template-{yourname}.php` to be picked up by the element itself.
After that, choose the newly created template from the Algolia Hits element when inserting it into the builder.

The template must use the Vue implementations of the Algolia VueInstantSearch Library.
You can find an example in the `template-example.php` file inside the algolia_hits element.

## Build from source

```./build.sh```

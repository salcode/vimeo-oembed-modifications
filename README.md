# vimeo-oembed-modifications

WordPress plugin to modify the src attribute in a Vimeo oEmbed.

## Usage

After activating this plugin,  you can use the `fe_vimeo_oembed_mods` filter
to add parameters.

### Example

```
add_filter( 'fe_vimeo_oembed_mods', 'my_slug_vimeo_oembed_mods' );

function my_slug_vimeo_oembed_mods( $param_str ) {
	return $param_str . 'title=0&byline=0&portrait=0';
}
```

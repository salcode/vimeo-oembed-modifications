# vimeo-oembed-modifications

WordPress plugin to modify the src attribute in a Vimeo oEmbed.

## Usage

After activating this plugin,  you can use the `fe_vimeo_oembed_mods` filter
to add parameters.

You can view of a list of the parameters at
https://developer.vimeo.com/apis/oembed

### Example

```
add_filter( 'fe_vimeo_oembed_mods', 'my_slug_vimeo_oembed_mods' );

function my_slug_vimeo_oembed_mods( $param_str ) {
	return 'title=0&byline=0&portrait=0';
}
```

## Road Map

Ultimately, I'd like this plugin to pass along a predefined set of parameters.
For this reason, I strongly suggest overwriting the `$param_str` (as in the
example) rather than appending to it.

OhGoogleMapFormTypeBundle
=========================

Set latitude and longitude values on a form using Google Maps. The map includes a search field and a current location link. When a pin is placed or dragged on the map, the latitude and longitude fields are updated.

Installation
------------

This bundle is compatible with Symfony 2.1. Add the following to your `composer.json`:

    "oh/google-map-form-type-bundle": "dev-master"

You might need to change a couple of options if you are trying to use Symfony 2.0

Add OhGoogleMapFormTypeBundle to assetic
```yaml
# app/config/config.yml
# Assetic Configuration
assetic:
    bundles:        [ 'OhGoogleMapFormTypeBundle' ]
```

Usage
------------

This bundle contains a new FormType called GoogleMapType which can be used in your forms like so:

    $builder->add('latlng', new GoogleMapType());

On your model you will have to process the latitude and longitude array

    // Your model eg, src/My/Location/Entity/MyLocation.php
    use Symfony\Component\Validator\Constraints as Assert;
    use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;

    class MyLocation
    {
        // ... include your lat and lng fields here

        public function setLatLng($latlng)
        {
            $this->setLat($latlng['lat']);
            $this->setLng($latlng['lng']);
            return $this;
        }

        /**
         * @Assert\NotBlank()
         * @OhAssert\LatLng()
         */
        public function getLatLng()
        {
            return array('lat'=>$this->getLat(),'lng'=>$this->getLng());
        }

    }

Include the twig template for the layout. It's generally a good idea to overwrite the form template in your own twig template

    # your config.yml
    twig:
        form:
            resources:
                # This uses the default - you can put your own one here
                - 'OhGoogleMapFormTypeBundle:Form:fields.html.twig'

If you are intending to override some of the elements in the template then you can do so by extending the default `google_maps.html.twig`. This example adds a callback to the javascript when a new map position is selected.

    {# your template which is inluded in the config.yml (above) 
       eg src/My/Location/Resources/views/Form/fields.html.twig #}
    {% extends "OhGoogleMapFormTypeBundle:Form:google_maps.html.twig" %}
    {% block oh_google_maps_callback %}
			<script type="text/javascript">
				var oh_google_maps_callback = function(location, gmap){
                    // logs to the console your new latitude
					console.log('Your new latitude is: '+location.lat());
				}
			</script>	
    {% endblock %}


Options
-------

There are a number of options, mostly self-explanatory

    array(
		'type'           => 'text',  // the types to render the lat and lng fields as
		'options'        => array(), // the options for both the fields
		'lat_options'  => array(),   // the options for just the lat field
		'lng_options' => array(),    // the options for just the lng field
		'lat_name'       => 'lat',   // the name of the lat field
		'lng_name'       => 'lng',   // the name of the lng field
		'map_width'      => 300,     // the width of the map
		'map_height'     => 300,     // the height of the map
		'default_lat'    => 51.5,    // the starting position on the map
		'default_lng'    => -0.1245, // the starting position on the map
		'include_jquery' => false,   // jquery needs to be included above the field (ie not at the bottom of the page)
		'include_gmaps_js'=>true     // is this the best place to include the google maps javascript?
	)

Screenshots
-------

[Default form](https://www.dropbox.com/s/pvoihkkq74imnk3/location-form-1.png)
[Current position](https://www.dropbox.com/s/uhf7fk3mx35j137/location-form-current.png)
[Search locations](https://www.dropbox.com/s/qdft149ggyfil0p/location-form-search.png)
[LatLng validation](https://www.dropbox.com/s/k0xqku5q2gv2nlo/location-form-validation.png)

Known problems
-------

Because the form type template includes javascript, there's not yet a way to bunch it all together at the very bottom of the page, so it is included at the bottom of the field. This means that jquery and the javascript plugin in Resources/public/js needs to be included before the field. I'm not sure of a way around this, but I think it's going to be addressed in a later version of the form framework.

Credits
-------

* Ollie Harridge (ollietb) as main author.

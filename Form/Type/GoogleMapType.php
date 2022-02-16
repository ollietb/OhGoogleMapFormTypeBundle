<?php
/**
 * Autosearch from request - ?mapSearchInput=Warszawa ul. nowogrodzka
 */
namespace Oh\GoogleMapFormTypeBundle\Form\Type;

use AppBundle\Model\AppConfig;
use Mea\CoreBundle\Form\Type\StringType;
use Mea\CoreBundle\Service\ErrorService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GoogleMapType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        unset($options['options']['compound']);

        if($options['editable'])
            $builder
                ->add($options['lat_name'], HiddenType::class, array_merge($options['options'], $options['lat_options']))
                ->add($options['lng_name'],HiddenType::class, array_merge($options['options'], $options['lng_options']))
            ;

        else{

            $entity = $builder->getData();

            ErrorService::getInstance()->addDebug($builder);

            $builder
                ->add($options['lat_name'],HiddenType::class, array_merge($options['options'], $options['lat_options']))
                ->add($options['lng_name'], HiddenType::class, array_merge($options['options'], $options['lng_options']))
//               ->add('Coordinates',StringType::class,[
//                   'data'=>'sdfdfs',
//                   'required'=>false,
//                   'mapped'=>false,
//               ])
            ;

        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'editable'           => true,
            'type'           => TextType::class,  // the types to render the lat and lng fields as
            'compound'=>true,
            'options'        => array(
                'compound'=>true
            ), // the options for both the fields
            'lat_options'  => array(),   // the options for just the lat field
            'lng_options' => array(),    // the options for just the lng field
            'lat_name'       => 'lat',   // the name of the lat field
            'lng_name'       => 'lng',   // the name of the lng field
            'error_bubbling' => false,
            'zoom_callback' => false,    //form callback
            'map_width'      => 300,     // the width of the map
            'map_height'     => 300,     // the height of the map
            'default_lat'    => AppConfig::LOCATION_DEFAULT_LAT,    // the starting position on the map
            'default_lng'    => AppConfig::LOCATION_DEFAULT_LNG, // the starting position on the map
            'default_zoom'    => AppConfig::LOCATION_DEFAULT_ZOOM, // the starting position on the map
            'include_jquery' => false,   // jquery needs to be included above the field (ie not at the bottom of the page)
            'include_gmaps_js'=>true     // is this the best place to include the google maps javascript?
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['editable'] = $options['editable'];
        $view->vars['lat_name'] = $options['lat_name'];
        $view->vars['lng_name'] = $options['lng_name'];
        $view->vars['map_width'] = $options['map_width'];
        $view->vars['map_height'] = $options['map_height'];
        $view->vars['default_lat'] = $options['default_lat'];
        $view->vars['default_lng'] = $options['default_lng'];
        $view->vars['default_zoom'] = $options['default_zoom'];
        $view->vars['include_jquery'] = $options['include_jquery'];
        $view->vars['include_gmaps_js'] = $options['include_gmaps_js'];
        $view->vars['zoom_callback'] = $options['zoom_callback'];




    }

    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'oh_google_maps'; 
        
    }
}

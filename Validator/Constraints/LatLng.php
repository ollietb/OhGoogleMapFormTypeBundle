<?php

namespace Oh\GoogleMapFormTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class LatLng extends Constraint
{
    public $message = 'The values for latitude and longitude ("%lat%" and "%lng%") are not valid.';
}
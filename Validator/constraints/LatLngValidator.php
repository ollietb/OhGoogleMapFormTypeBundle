<?php

namespace Oh\GoogleMapFormTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LatLngValidator extends ConstraintValidator
{
    public function isValid($value, Constraint $constraint)
    {
		if (!preg_match('/^[0-9\-\.]+$/', $value['lat'], $matches) || !preg_match('/^[0-9\-\.]+$/', $value['lng'], $matches)) {
			 $this->setMessage($constraint->message, array('%lat%' => (float)$value['lat'], '%lng%' => (float)$value['lng']));
			 return false;
		}
		if($value['lat'] > 90 || $value['lat'] < -90 || $value['lng'] > 180 || $value['lng'] < -180)
		{
			 $this->setMessage($constraint->message, array('%lat%' => (float)$value['lat'], '%lng%' => (float)$value['lng']));
			 return false;
		}

        return true;
    }
}
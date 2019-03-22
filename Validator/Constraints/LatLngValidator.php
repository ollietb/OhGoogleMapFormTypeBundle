<?php

namespace Oh\GoogleMapFormTypeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LatLngValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
		if (!preg_match('/^[0-9\-\.]+$/', $value['latitude'], $matches) || !preg_match('/^[0-9\-\.]+$/', $value['longitude'], $matches)) {
			 $this->context->addViolation($constraint->message, array('%latitude%' => (float)$value['latitude'], '%longitude%' => (float)$value['longitude']));
			 return false;
		}
		if($value['latitude'] > 90 || $value['latitude'] < -90 || $value['longitude'] > 180 || $value['longitude'] < -180)
		{
			 $this->context->addViolation($constraint->message, array('%latitude%' => (float)$value['latitude'], '%longitude%' => (float)$value['longitude']));
			 return false;
		}

        return true;
    }
}
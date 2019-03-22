<?php

namespace Oh\GoogleMapFormTypeBundle\Traits;

use Doctrine\ORM\Mapping as ORM;
use Oh\GoogleMapFormTypeBundle\Validator\Constraints as OhAssert;


trait LocationTrait
{
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return $this
     */
    public function setLatLng($latlng)
    {
        $this->setLatitude($latlng['latitude']);
        $this->setLongitude($latlng['longitude']);
        $this->setAddress($latlng['address']);
        return $this;
    }

    /**
     * @OhAssert\LatLng()
     */
    public function getLatLng()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address
        ];

    }
}
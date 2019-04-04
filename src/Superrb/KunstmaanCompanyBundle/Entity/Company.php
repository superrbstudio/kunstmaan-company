<?php

namespace Superrb\KunstmaanCompanyBundle\Entity;

use ArrayAccess;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Kunstmaan\AdminBundle\Entity\DeepCloneInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Company.
 *
 * @ORM\Table(name="skcb_companies")
 * @ORM\Entity(repositoryClass="Superrb\KunstmaanCompanyBundle\Repository\CompanyRepository")
 */
class Company extends AbstractEntity implements ArrayAccess, DeepCloneInterface
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="company_name", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $companyName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_address", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $streetAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_locality", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $addressLocality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_region", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $addressRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postcode", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_country", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $addressCountry;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lat", type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lng", type="string", length=255, nullable=true)
     */
    private $lng;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string|null
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="instagram", type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="youtube", type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @var string|null
     *
     * @ORM\Column(name="vimeo", type="string", length=255, nullable=true)
     */
    private $vimeo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone_link", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $phoneLink;
    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\Superrb\KunstmaanCompanyBundle\Entity\Day", mappedBy="company",
     *      cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     * @Assert\NotBlank()
     */
    private $days;

    public function deepClone()
    {
        $days       = $this->getDays();
        $this->days = new ArrayCollection();
        foreach ($days as $day) {
            $cloneDay = clone $day;
            $this->addDay($cloneDay);
        }
    }

    private function getterForOffset($offset)
    {
        return 'get'.ucwords($offset);
    }

    private function setterForOffset($offset)
    {
        return 'set'.ucwords($offset);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->getterForOffset($offset)}();
        }
    }

    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->setterForOffset($offset)}($value);
        }
    }

    public function offsetExists($offset)
    {
        return method_exists($this, $this->getterForOffset($offset));
    }

    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->setterForOffset($offset)}(null);
        }
    }

    /**
     * Set streetAddress.
     *
     * @param string|null $streetAddress
     *
     * @return Company
     */
    public function setStreetAddress($streetAddress = null)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress.
     *
     * @return string|null
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set addressLocality.
     *
     * @param string|null $addressLocality
     *
     * @return Company
     */
    public function setAddressLocality($addressLocality = null)
    {
        $this->addressLocality = $addressLocality;

        return $this;
    }

    /**
     * Get addressLocality.
     *
     * @return string|null
     */
    public function getAddressLocality()
    {
        return $this->addressLocality;
    }

    /**
     * Set addressRegion.
     *
     * @param string|null $addressRegion
     *
     * @return Company
     */
    public function setAddressRegion($addressRegion = null)
    {
        $this->addressRegion = $addressRegion;

        return $this;
    }

    /**
     * Get addressRegion.
     *
     * @return string|null
     */
    public function getAddressRegion()
    {
        return $this->addressRegion;
    }

    /**
     * Set postcode.
     *
     * @param string|null $postcode
     *
     * @return Company
     */
    public function setPostcode($postcode = null)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode.
     *
     * @return string|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set addressCountry.
     *
     * @param string|null $addressCountry
     *
     * @return Company
     */
    public function setAddressCountry($addressCountry = null)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Get addressCountry.
     *
     * @return string|null
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Set lat.
     *
     * @param string|null $lat
     *
     * @return Company
     */
    public function setLat($lat = null)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat.
     *
     * @return string|null
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng.
     *
     * @param string|null $lng
     *
     * @return Company
     */
    public function setLng($lng = null)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng.
     *
     * @return string|null
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set facebook.
     *
     * @param string|null $facebook
     *
     * @return Company
     */
    public function setFacebook($facebook = null)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string|null
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter.
     *
     * @param string|null $twitter
     *
     * @return Company
     */
    public function setTwitter($twitter = null)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter.
     *
     * @return string|null
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set instagram.
     *
     * @param string|null $instagram
     *
     * @return Company
     */
    public function setInstagram($instagram = null)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram.
     *
     * @return string|null
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set youtube.
     *
     * @param string|null $youtube
     *
     * @return Company
     */
    public function setYoutube($youtube = null)
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube.
     *
     * @return string|null
     */
    public function getYoutube()
    {
        return $this->youtube;
    }

    /**
     * Set vimeo.
     *
     * @param string|null $vimeo
     *
     * @return Company
     */
    public function setVimeo($vimeo = null)
    {
        $this->vimeo = $vimeo;

        return $this;
    }

    /**
     * Get vimeo.
     *
     * @return string|null
     */
    public function getVimeo()
    {
        return $this->vimeo;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Company
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phoneLink.
     *
     * @param string|null $phoneLink
     *
     * @return Company
     */
    public function setPhoneLink($phoneLink = null)
    {
        $this->phoneLink = $phoneLink;

        return $this;
    }

    /**
     * Get phoneLink.
     *
     * @return string|null
     */
    public function getPhoneLink()
    {
        return $this->phoneLink;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Company
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set companyName.
     *
     * @param string|null $companyName
     *
     * @return Company
     */
    public function setCompanyName($companyName = null)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->days = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add day.
     *
     * @param \Superrb\KunstmaanCompanyBundle\Entity\Day $day
     *
     * @return Company
     */
    public function addDay(\Superrb\KunstmaanCompanyBundle\Entity\Day $day)
    {
        $day->setCompany($this);
        $this->days[] = $day;

        return $this;
    }

    /**
     * Remove day.
     *
     * @param \Superrb\KunstmaanCompanyBundle\Entity\Day $day
     *
     * @return bool TRUE if this collection contained the specified element, FALSE otherwise
     */
    public function removeDay(\Superrb\KunstmaanCompanyBundle\Entity\Day $day)
    {
        return $this->days->removeElement($day);
    }

    /**
     * Get days.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDays()
    {
        return $this->days;
    }
}

<?php

namespace Superrb\KunstmaanCompanyBundle\Entity;

use App\Entity\Service;
use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Kunstmaan\AdminBundle\Entity\DeepCloneInterface;
use Kunstmaan\MediaBundle\Entity\Media;
use Symfony\Component\Intl\Countries;
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_address", type="string", length=255, nullable=true)
     */
    private $streetAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_locality", type="string", length=255, nullable=true)
     */
    private $addressLocality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_region", type="string", length=255, nullable=true)
     */
    private $addressRegion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postcode", type="string", length=255, nullable=true)
     */
    private $postcode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_country", type="string", length=255, nullable=true)
     */
    private $addressCountry;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address_url", type="string", length=255, nullable=true)
     */
    private $addressUrl;

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
     * @ORM\Column(name="pinterest", type="string", length=255, nullable=true)
     */
    private $pinterest;

    /**
     * @var string|null
     *
     * @ORM\Column(name="linkedin", type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dribbble", type="string", length=255, nullable=true)
     */
    private $dribbble;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="phone_number", nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var \Kunstmaan\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="logo_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank()
     */
    private $logo;

    /**
     * @var \Kunstmaan\MediaBundle\Entity\Media
     *
     * @ORM\ManyToOne(targetEntity="Kunstmaan\MediaBundle\Entity\Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="image_id", referencedColumnName="id")
     * })
     * @Assert\NotBlank()
     */
    private $image;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="\Superrb\KunstmaanCompanyBundle\Entity\Day", mappedBy="company",
     *      cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
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

    /**
     * @param $offset
     *
     * @return string
     */
    private function getterForOffset($offset)
    {
        return 'get'.ucwords($offset);
    }

    /**
     * @param $offset
     *
     * @return string
     */
    private function setterForOffset($offset)
    {
        return 'set'.ucwords($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->getterForOffset($offset)}();
        }
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->setterForOffset($offset)}($value);
        }
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return method_exists($this, $this->getterForOffset($offset));
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->{$this->setterForOffset($offset)}(null);
        }
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Company
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param string $delimeter
     * @return string
     */
    public function getAddress($delimeter = " \n"): string {
        $parts = [];

        if($this->getStreetAddress() != '') {
            $parts[] = $this->getStreetAddress();
        }

        if($this->getAddressLocality() != '') {
            $parts[] = $this->getAddressLocality();
        }

        if($this->getAddressRegion() != '') {
            $parts[] = $this->getAddressRegion();
        }

        if($this->getPostcode() != '') {
            $parts[] = $this->getPostcode();
        }

        if($this->getAddressCountry() != '') {
            $parts[] = Countries::getName($this->getAddressCountry());
        }

        return implode($delimeter, $parts);
     }

    /**
     * @return string|null
     */
    public function getAddressUrl(): ?string
    {
        return $this->addressUrl;
    }

    /**
     * @param string|null $addressUrl
     */
    public function setAddressUrl(?string $addressUrl): Company
    {
        $this->addressUrl = $addressUrl;

        return $this;
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
     * @return self
     */
    public function setFacebook(?string $facebook = null): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string|null
     */
    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    /**
     * Set twitter.
     *
     * @param string|null $twitter
     *
     * @return self
     */
    public function setTwitter(?string $twitter = null): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter.
     *
     * @return string|null
     */
    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    /**
     * Set instagram.
     *
     * @param string|null $instagram
     *
     * @return self
     */
    public function setInstagram(?string $instagram = null): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get instagram.
     *
     * @return string|null
     */
    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    /**
     * Set youtube.
     *
     * @param string|null $youtube
     *
     * @return self
     */
    public function setYoutube(?string $youtube = null): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    /**
     * Get youtube.
     *
     * @return string|null
     */
    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    /**
     * Set vimeo.
     *
     * @param string|null $vimeo
     *
     * @return self
     */
    public function setVimeo(?string $vimeo = null): self
    {
        $this->vimeo = $vimeo;

        return $this;
    }

    /**
     * Get vimeo.
     *
     * @return string|null
     */
    public function getVimeo(): ?string
    {
        return $this->vimeo;
    }

    /**
     * Set pinterest.
     *
     * @param string|null $pinterest
     *
     * @return self
     */
    public function setPinterest(?string $pinterest = null): self
    {
        $this->pinterest = $pinterest;

        return $this;
    }

    /**
     * Get pinterest.
     *
     * @return string|null
     */
    public function getPinterest(): ?string
    {
        return $this->pinterest;
    }

    /**
     * Set linkedin.
     *
     * @param string|null $linkedin
     *
     * @return self
     */
    public function setLinkedin(?string $linkedin = null): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin.
     *
     * @return string|null
     */
    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    /**
     * Set dribbble.
     *
     * @param string|null $dribbble
     *
     * @return self
     */
    public function setDribbble(?string $dribbble = null): self
    {
        $this->dribbble = $dribbble;

        return $this;
    }

    /**
     * Get dribbble.
     *
     * @return string|null
     */
    public function getDribbble(): ?string
    {
        return $this->dribbble;
    }

    /**
     * @return array
     */
    public function getSocialMedias(): array
    {
        $networks = [];

        if ('' != $this->getFacebook()) {
            $networks[] = [
                'url' => $this->getFacebook(),
                'key' => 'facebook',
            ];
        }

        if ('' != $this->getTwitter()) {
            $networks[] = [
                'url' => $this->getTwitter(),
                'key' => 'twitter',
            ];
        }

        if ('' != $this->getInstagram()) {
            $networks[] = [
                'url' => $this->getInstagram(),
                'key' => 'instagram',
            ];
        }

        if ('' != $this->getYoutube()) {
            $networks[] = [
                'url' => $this->getYoutube(),
                'key' => 'youtube',
            ];
        }

        if ('' != $this->getVimeo()) {
            $networks[] = [
                'url' => $this->getVimeo(),
                'key' => 'vimeo',
            ];
        }

        if ('' != $this->getPinterest()) {
            $networks[] = [
                'url' => $this->getPinterest(),
                'key' => 'pinterest',
            ];
        }

        if ('' != $this->getLinkedin()) {
            $networks[] = [
                'url' => $this->getLinkedin(),
                'key' => 'linkedin',
            ];
        }

        if ('' != $this->getDribbble()) {
            $networks[] = [
                'url' => $this->getDribbble(),
                'key' => 'dribbble',
            ];
        }

        return $networks;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return self
     */
    public function setPhone($phone = null): ?string
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phoneLink.
     *
     * @param string|null $phoneLink
     *
     * @return self
     */
    public function setPhoneLink(?string $phoneLink = null): self
    {
        $this->phoneLink = $phoneLink;

        return $this;
    }

    /**
     * Get phoneLink.
     *
     * @return string|null
     */
    public function getPhoneLink(): ?string
    {
        return $this->phoneLink;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return self
     */
    public function setEmail(?string $email = null): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set companyName.
     *
     * @param string|null $companyName
     *
     * @return self
     */
    public function setCompanyName(?string $companyName = null): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName.
     *
     * @return string|null
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Set logo.
     *
     * @param Media|null $logo
     *
     * @return self
     */
    public function setLogo(Media $logo = null): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return Media|null
     */
    public function getLogo(): ?Media
    {
        return $this->logo;
    }

    /**
     * Set image.
     *
     * @param Media|null $image
     *
     * @return self
     */
    public function setImage(Media $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return Media|null
     */
    public function getImage(): ?Media
    {
        return $this->image;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->days = new ArrayCollection();
    }

    /**
     * Add day.
     *
     * @param Day $day
     *
     * @return self
     */
    public function addDay(Day $day): self
    {
        $day->setCompany($this);
        $this->days[] = $day;

        return $this;
    }

    /**
     * Remove day.
     *
     * @param Day $day
     *
     * @return self
     */
    public function removeDay(Day $day): self
    {
        $this->days->removeElement($day);

        return $this;
    }

    /**
     * Get days.
     *
     * @return Collection
     */
    public function getDays(): Collection
    {
        return $this->days;
    }
}

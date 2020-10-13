<?php

namespace Superrb\KunstmaanCompanyBundle\Entity;

use ArrayAccess;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Kunstmaan\AdminBundle\Entity\DeepCloneInterface;
use Kunstmaan\MediaBundle\Entity\Media;
use libphonenumber\PhoneNumber;
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
     * @ORM\OneToMany(targetEntity="\Superrb\KunstmaanCompanyBundle\Entity\Address", mappedBy="company",
     *      cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"displayOrder" = "ASC"})
     */
    private $addresses;

    /**
     * @var Address|null
     *
     * @ORM\OneToOne(targetEntity="\Superrb\KunstmaanCompanyBundle\Entity\Address")
     * @ORM\JoinColumn(name="default_address_id", referencedColumnName="id")
     */
    private $defaultAddress;

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

        $addresses       = $this->getAddresses();
        $this->addresses = new ArrayCollection();
        foreach ($addresses as $address) {
            $cloneAddress = clone $address;
            $this->addAddress($cloneAddress);
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
     * @return self
     */
    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * @param Address $address
     *
     * @return self
     */
    public function addAddress(Address $address): self
    {
        $this->addresses->add($address);

        return $this;
    }

    /**
     * @param Address $address
     *
     * @return self
     */
    public function removeAddress(Address $address): self
    {
        $this->addresses->removeElement($address);

        return $this;
    }

    /**
     * @param Collection $addresses
     *
     * @return self
     */
    public function setAddresses(Collection $addresses): self
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getDefaultAddress(): ?Address
    {
        if (null !== $this->defaultAddress) {
            return $this->defaultAddress;
        }

        return $this->getAddresses()->first() ?: null;
    }

    /**
     * @return bool
     */
    public function hasDefaultAddress(): bool
    {
        return null !== $this->getDefaultAddress();
    }

    /**
     * @param Address|null $address
     *
     * @return self
     */
    public function setDefaultAddress(?Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addAddress($address);
        }

        $this->defaultAddress = $address;

        return $this;
    }

    /**
     * Get streetAddress.
     *
     * @return string|null
     */
    public function getStreetAddress(): ?string
    {
        return $this->getFromDefaultAddress('streetAddress');
    }

    /**
     * Get addressLocality.
     *
     * @return string|null
     */
    public function getAddressLocality(): ?string
    {
        return $this->getFromDefaultAddress('locality');
    }

    /**
     * Get addressRegion.
     *
     * @return string|null
     */
    public function getAddressRegion(): ?string
    {
        return $this->getFromDefaultAddress('region');
    }

    /**
     * Get postcode.
     *
     * @return string|null
     */
    public function getPostcode(): ?string
    {
        return $this->getFromDefaultAddress('postcode');
    }

    /**
     * @return string|null
     */
    public function getAddressCountry(): ?string
    {
        return $this->getFromDefaultAddress('country');
    }

    /**
     * @return string|null
     */
    public function getAddressUrl(): ?string
    {
        return $this->getFromDefaultAddress('url');
    }

    /**
     * @return string|null
     */
    public function getLat(): ?string
    {
        return $this->getFromDefaultAddress('lat');
    }

    /**
     * @return string|null
     */
    public function getLng(): ?string
    {
        return $this->getFromDefaultAddress('lng');
    }

    /**
     * @param string $field
     * @param array  $args
     *
     * @return mixed
     */
    public function getFromDefaultAddress(string $field, ...$args): ?string
    {
        if (!$this->hasDefaultAddress()) {
            return null;
        }

        $address = $this->getDefaultAddress();
        $method  = 'get'.ucwords($field);

        return $address->{$method}(...$args);
    }

    /**
     * @param string $delimeter
     *
     * @return string
     */
    public function getAddress(string $delimeter = " \n"): string
    {
        return $this->getFromDefaultAddress('address', $delimeter);
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
     * @param PhoneNumber|null $phone
     *
     * @return self
     */
    public function setPhone(?PhoneNumber $phone = null): ?string
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return PhoneNumber|null
     */
    public function getPhone(): ?PhoneNumber
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
    public function setLogo(?Media $logo = null): self
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
    public function setImage(?Media $image = null): self
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
        $this->addresses = new ArrayCollection();
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

    /**
     * Return JSON string of 'sameAs' for company schema
     *
     * @return string
     */
    public function getSameAsForSchema(): string {
        $items = [];

        if($this->getFacebook()) {
            $items[] = $this->getFacebook();
        }

        if($this->getTwitter()) {
            $items[] = $this->getTwitter();
        }

        if($this->getInstagram()) {
            $items[] = $this->getInstagram();
        }

        if($this->getYoutube()) {
            $items[] = $this->getYoutube();
        }

        if($this->getVimeo()) {
            $items[] = $this->getVimeo();
        }

        if($this->getPinterest()) {
            $items[] = $this->getPinterest();
        }

        if($this->getLinkedin()) {
            $items[] = $this->getLinkedin();
        }

        if($this->getDribbble()) {
            $items[] = $this->getDribbble();
        }

        return '"' . implode('","', $items) . '"';
    }
}

<?php

namespace Superrb\KunstmaanCompanyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kunstmaan\AdminBundle\Entity\AbstractEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Day.
 *
 * @ORM\Table(name="skcb_days")
 * @ORM\Entity(repositoryClass="Superrb\KunstmaanCompanyBundle\Repository\DayRepository")
 */
class Day extends AbstractEntity
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="day", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $day;

    /**
     * @var string|null
     *
     * @ORM\Column(name="open_time", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $openTime;

    /**
     * @var string|null
     *
     * @ORM\Column(name="close_time", type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $closeTime;

    /**
     * @var int
     *
     * @ORM\Column(name="display_order", type="integer", nullable=true)
     */
    private $displayOrder;

    /**
     * @ORM\ManyToOne(targetEntity="\Superrb\KunstmaanCompanyBundle\Entity\Company", inversedBy="days")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * Set day.
     *
     * @param string|null $day
     *
     * @return Day
     */
    public function setDay($day = null)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day.
     *
     * @return string|null
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set displayOrder.
     *
     * @param int|null $displayOrder
     *
     * @return Day
     */
    public function setDisplayOrder($displayOrder = null)
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    /**
     * Get displayOrder.
     *
     * @return int|null
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set company.
     *
     * @param \Superrb\KunstmaanCompanyBundle\Entity\Company|null $company
     *
     * @return Day
     */
    public function setCompany(\Superrb\KunstmaanCompanyBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company.
     *
     * @return \Superrb\KunstmaanCompanyBundle\Entity\Company|null
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set openTime.
     *
     * @param string|null $openTime
     *
     * @return Day
     */
    public function setOpenTime($openTime = null)
    {
        $this->openTime = $openTime;

        return $this;
    }

    /**
     * Get openTime.
     *
     * @return string|null
     */
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     * Set closeTime.
     *
     * @param string|null $closeTime
     *
     * @return Day
     */
    public function setCloseTime($closeTime = null)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * Get closeTime.
     *
     * @return string|null
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }
}

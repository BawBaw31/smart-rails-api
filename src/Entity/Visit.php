<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitRepository::class)
 */
class Visit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=VisitType::class, inversedBy="visits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visit_type;

    /**
     * @ORM\OneToMany(targetEntity=VisitValue::class, mappedBy="visit")
     */
    private $visitValues;

    public function __construct()
    {
        $this->visitValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getVisitType(): ?VisitType
    {
        return $this->visit_type;
    }

    public function setVisitType(?VisitType $visit_type): self
    {
        $this->visit_type = $visit_type;

        return $this;
    }

    /**
     * @return Collection<int, VisitValue>
     */
    public function getVisitValues(): Collection
    {
        return $this->visitValues;
    }

    public function addVisitValue(VisitValue $visitValue): self
    {
        if (!$this->visitValues->contains($visitValue)) {
            $this->visitValues[] = $visitValue;
            $visitValue->setVisit($this);
        }

        return $this;
    }

    public function removeVisitValue(VisitValue $visitValue): self
    {
        if ($this->visitValues->removeElement($visitValue)) {
            // set the owning side to null (unless already changed)
            if ($visitValue->getVisit() === $this) {
                $visitValue->setVisit(null);
            }
        }

        return $this;
    }
}

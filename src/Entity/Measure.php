<?php

namespace App\Entity;

use App\Repository\MeasureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MeasureRepository::class)
 */
class Measure
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $theoretical_value;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $min_value;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $max_value;

    /**
     * @ORM\ManyToMany(targetEntity=VisitType::class, inversedBy="measures")
     */
    private $visit_type;

    /**
     * @ORM\OneToMany(targetEntity=VisitValue::class, mappedBy="measure")
     */
    private $visitValues;

    public function __construct()
    {
        $this->visit_type = new ArrayCollection();
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

    public function getTheoreticalValue(): ?float
    {
        return $this->theoretical_value;
    }

    public function setTheoreticalValue(?float $theoretical_value): self
    {
        $this->theoretical_value = $theoretical_value;

        return $this;
    }

    public function getMinValue(): ?float
    {
        return $this->min_value;
    }

    public function setMinValue(?float $min_value): self
    {
        $this->min_value = $min_value;

        return $this;
    }

    public function getMaxValue(): ?float
    {
        return $this->max_value;
    }

    public function setMaxValue(?float $max_value): self
    {
        $this->max_value = $max_value;

        return $this;
    }

    /**
     * @return Collection<int, VisitType>
     */
    public function getVisitType(): Collection
    {
        return $this->visit_type;
    }

    public function addVisitType(VisitType $visitType): self
    {
        if (!$this->visit_type->contains($visitType)) {
            $this->visit_type[] = $visitType;
        }

        return $this;
    }

    public function removeVisitType(VisitType $visitType): self
    {
        $this->visit_type->removeElement($visitType);

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
            $visitValue->setMeasure($this);
        }

        return $this;
    }

    public function removeVisitValue(VisitValue $visitValue): self
    {
        if ($this->visitValues->removeElement($visitValue)) {
            // set the owning side to null (unless already changed)
            if ($visitValue->getMeasure() === $this) {
                $visitValue->setMeasure(null);
            }
        }

        return $this;
    }

    public function __toString(): string {
        return $this->label;
    }
}

<?php

namespace App\Entity;

use App\Repository\MeasureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MeasureRepository::class)
 */
class Measure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"visit_types"})
     * @Groups({"visit_reports"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"visit_types"})
     * @Groups({"visit_reports"})
     */
    private $label;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"visit_types"})
     * @Groups({"visit_reports"})
     */
    private $theoreticalValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"visit_types"})
     * @Groups({"visit_reports"})
     */
    private $minValue;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"visit_types"})
     * @Groups({"visit_reports"})
     */
    private $maxValue;

    /**
     * @ORM\ManyToMany(targetEntity=VisitType::class, inversedBy="measures")
     */
    private $visitType;

    /**
     * @ORM\OneToMany(targetEntity=VisitValue::class, mappedBy="measure")
     */
    private $visitValues;

    public function __construct()
    {
        $this->visitType = new ArrayCollection();
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
        return $this->theoreticalValue;
    }

    public function setTheoreticalValue(?float $theoreticalValue): self
    {
        $this->theoreticalValue = $theoreticalValue;

        return $this;
    }

    public function getMinValue(): ?float
    {
        return $this->minValue;
    }

    public function setMinValue(?float $minValue): self
    {
        $this->minValue = $minValue;

        return $this;
    }

    public function getMaxValue(): ?float
    {
        return $this->maxValue;
    }

    public function setMaxValue(?float $maxValue): self
    {
        $this->maxValue = $maxValue;

        return $this;
    }

    /**
     * @return Collection<int, VisitType>
     */
    public function getVisitType(): Collection
    {
        return $this->visitType;
    }

    public function addVisitType(VisitType $visitType): self
    {
        if (!$this->visitType->contains($visitType)) {
            $this->visitType[] = $visitType;
        }

        return $this;
    }

    public function removeVisitType(VisitType $visitType): self
    {
        $this->visitType->removeElement($visitType);

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

    public function __toString(): string
    {
        return $this->label;
    }
}

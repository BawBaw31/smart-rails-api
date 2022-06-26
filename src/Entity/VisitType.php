<?php

namespace App\Entity;

use App\Repository\VisitTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitTypeRepository::class)
 */
class VisitType
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
     * @ORM\ManyToMany(targetEntity=Measure::class, mappedBy="visitType")
     */
    private $measures;

    /**
     * @ORM\OneToMany(targetEntity=VisitReport::class, mappedBy="visitType")
     */
    private $visitReports;

    public function __construct()
    {
        $this->measures = new ArrayCollection();
        $this->visitReports = new ArrayCollection();
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

    /**
     * @return Collection<int, Measure>
     */
    public function getMeasures(): Collection
    {
        return $this->measures;
    }

    public function addMeasure(Measure $measure): self
    {
        if (!$this->measures->contains($measure)) {
            $this->measures[] = $measure;
            $measure->addVisitType($this);
        }

        return $this;
    }

    public function removeMeasure(Measure $measure): self
    {
        if ($this->measures->removeElement($measure)) {
            $measure->removeVisitType($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->label;
    }

    /**
     * @return Collection<int, VisitReport>
     */
    public function getVisitReports(): Collection
    {
        return $this->visitReports;
    }

    public function addVisitReport(VisitReport $visitReport): self
    {
        if (!$this->visitReports->contains($visitReport)) {
            $this->visitReports[] = $visitReport;
            $visitReport->setVisitType($this);
        }

        return $this;
    }

    public function removeVisitReport(VisitReport $visitReport): self
    {
        if ($this->visitReports->removeElement($visitReport)) {
            // set the owning side to null (unless already changed)
            if ($visitReport->getVisitType() === $this) {
                $visitReport->setVisitType(null);
            }
        }

        return $this;
    }
}

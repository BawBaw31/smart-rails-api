<?php

namespace App\Entity;

use App\Repository\VisitValueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisitValueRepository::class)
 */
class VisitValue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Measure::class, inversedBy="visitValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $measure;

    /**
     * @ORM\ManyToOne(targetEntity=VisitReport::class, inversedBy="values")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitReport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getMeasure(): ?Measure
    {
        return $this->measure;
    }

    public function setMeasure(?Measure $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    public function getVisitReport(): ?VisitReport
    {
        return $this->visitReport;
    }

    public function setVisitReport(?VisitReport $visitReport): self
    {
        $this->visitReport = $visitReport;

        return $this;
    }
}

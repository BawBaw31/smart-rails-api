<?php

namespace App\Entity;

use App\Repository\VisitReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VisitReportRepository::class)
 */
class VisitReport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"visit_reports"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=VisitType::class, inversedBy="visitReports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"visit_reports"})
     */
    private $visitType;

    /**
     * @ORM\OneToMany(targetEntity=VisitValue::class, mappedBy="visitReport", orphanRemoval=true)
     * @Groups({"visit_reports"})
     */
    private $values;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="visitReports")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"visit_reports"})
     */
    private $writer;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitType(): ?VisitType
    {
        return $this->visitType;
    }

    public function setVisitType(?VisitType $visitType): self
    {
        $this->visitType = $visitType;

        return $this;
    }

    /**
     * @return Collection<int, VisitValue>
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValue(VisitValue $value): self
    {
        if (!$this->values->contains($value)) {
            $this->values[] = $value;
            $value->setVisitReport($this);
        }

        return $this;
    }

    public function removeValue(VisitValue $value): self
    {
        if ($this->values->removeElement($value)) {
            // set the owning side to null (unless already changed)
            if ($value->getVisitReport() === $this) {
                $value->setVisitReport(null);
            }
        }

        return $this;
    }

    public function getWriter(): ?User
    {
        return $this->writer;
    }

    public function setWriter(?User $writer): self
    {
        $this->writer = $writer;

        return $this;
    }
}

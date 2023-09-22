<?php

namespace App\Entity;

use App\Repository\CalculationRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalculationRepository::class)]
class Calculation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $value_1 = null;

    #[ORM\Column(length: 1)]
    #[Assert\Choice(['+', '-', '*', '/'])]
    #[Assert\NotNull]
    private ?string $mathematical_action = null;

    #[ORM\Column]
    private ?float $value_2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $result = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    public function calculate(): void
    {
        switch ($this->mathematical_action) {
            case '+':
                $this->result = $this->value_1 + $this->value_2;
                break;
            case '-':
                $this->result = $this->value_1 - $this->value_2;
                break;
            case '*':
                $this->result = $this->value_1 * $this->value_2;
                break;
            case '/':
                $this->result = $this->value_1 / $this->value_2;
                break;
        }
    }

    public function getAnswer(): string
    {
        return $this->value_1 . " " . $this->mathematical_action . " " . $this->value_2 . " = " . $this->result;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue1(): ?float
    {
        return $this->value_1;
    }

    public function setValue1(float $value_1): static
    {
        $this->value_1 = $value_1;

        return $this;
    }

    public function getMathematicalAction(): ?string
    {
        return $this->mathematical_action;
    }

    public function setMathematicalAction(string $mathematical_action): static
    {
        $this->mathematical_action = $mathematical_action;

        return $this;
    }

    public function getValue2(): ?float
    {
        return $this->value_2;
    }

    public function setValue2(float $value_2): static
    {
        $this->value_2 = $value_2;

        return $this;
    }

    public function getResult(): ?float
    {
        return $this->result;
    }

    public function setResult(?float $result): static
    {
        $this->result = $result;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

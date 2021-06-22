<?php
/**
 * Task entity.
 */

namespace App\Entity;

use App\Repository\TaskRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Task.
 *
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * Primary key.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Content.
     *
     * @ORM\Column(type="string", length=70)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="70",
     * )
     */
    private string $content;

    /**
     * Priority.
     *
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     * @Assert\Regex("/^[1-5]$/")
     */
    private $priority;

    /**
     * Deadline.
     *
     * @var DataTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     */
    private $deadline;

    /**
     * @ORM\ManyToOne(targetEntity=Register::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $register;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDeadline(): ?DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getRegister(): ?Register
    {
        return $this->register;
    }

    public function setRegister(?Register $register): self
    {
        $this->register = $register;

        return $this;
    }
}

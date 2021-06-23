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
     * Register.
     *
     * @ORM\ManyToOne(targetEntity=Register::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $register;

    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Content.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Setter for Content.
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter for Priority.
     *
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * Setter for Priority.
     *
     * @param int $priority
     * @return $this
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * Getter for Deadline.
     *
     * @return DateTimeInterface|null
     */
    public function getDeadline(): ?DateTimeInterface
    {
        return $this->deadline;
    }

    /**
     * Setter for Deadline.
     *
     * @param DateTimeInterface $deadline
     * @return $this
     */
    public function setDeadline(DateTimeInterface $deadline): void
    {
        $this->deadline = $deadline;
    }

    /**
     * Getter for Register.
     *
     * @return Register|null
     */
    public function getRegister(): ?Register
    {
        return $this->register;
    }

    /**
     * Setter for Register.
     *
     * @param Register|null $register
     * @return $this
     */
    public function setRegister(?Register $register): void
    {
        $this->register = $register;
    }
}

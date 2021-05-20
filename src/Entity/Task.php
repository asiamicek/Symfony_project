<?php
/**
 * Tasks entity.
 */

namespace App\Entity;

use App\Repository\TasksRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;


/**
 * Class Tasks.
 *
 * @ORM\Entity(repositoryClass=TasksRepository::class)
 * @ORM\Table(name="tasks")
 */
class Tasks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $priority;

    /**
     * Created at.
     *
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * Deadline.
     *
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    private $deadline;





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
}
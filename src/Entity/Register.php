<?php
/**
 * Register entity.
 */

namespace App\Entity;

use App\Repository\RegisterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Class register.
 *
 * @ORM\Entity(repositoryClass=RegisterRepository::class)
 * @ORM\Table(name="registers")
 *
 * @UniqueEntity(fields={"title"})
 */
class Register
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Title.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="64",
     * )
     */
    private $title;

    /**
     * Category.
     *
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="registers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Tasks.
     *
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="register")
     */
    private $tasks;

    /**
     * Author.
     *
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * Register constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * Getter for Int.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter for Category.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for Category.
     *
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for Task.
     *
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * Add Task.
     *
     * @param Task $task
     */
    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setRegister($this);
        }
    }

    /**
     * Remove Task.
     *
     * @param Task $task
     */
    public function removeTask(Task $task): void
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getRegister() === $this) {
                $task->setRegister(null);
            }
        }
    }

    /**
     * Getter for Author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for Author.
     *
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }


}

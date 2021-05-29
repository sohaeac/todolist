<?php

namespace App\Entity;

use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskRepository;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("tasks")
     */
    
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("tasks")
     */
    
    private $title;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("tasks")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("tasks")
     */
    
    private $priority;

    /**
     * @ORM\Column(type="date")
     * @Groups("tasks")
     */
    private $task_date;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("tasks")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="tasks",cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     * @Groups("cat")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }


    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTaskDate(): ?\DateTimeInterface
    {
        return $this->task_date;
    }

    public function setTaskDate(\DateTimeInterface $task_date): self
    {
        $this->task_date = $task_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}

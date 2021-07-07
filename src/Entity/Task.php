<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Task
{
    /**
     * @Assert\Type("integer")
     */
    protected $id;

    /**
     * @Assert\NotBlank
     */
    protected $content;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     */
    protected $dueDate;

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function setDueDate(\DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

}
<?php

namespace Src\Modules\Auth\Domain\ValueObjetcs;

final class UserName
{
    public function __construct(private readonly ?string $name) {}

    /**
     * Get value of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}

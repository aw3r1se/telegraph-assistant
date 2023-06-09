<?php

namespace Aw3r1se\TelegraphAssistant\DTO;

class TelegraphRouteDTO
{
    protected ?string $command;

    protected ?string $handler;

    protected ?string $method = null;

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return $this
     */
    public function setCommand(string $command): static
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return string
     */
    public function getHandler(): string
    {
        return $this->handler;
    }

    /**
     * @param string $handler
     * @return $this
     */
    public function setHandler(string $handler): static
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string|null $method
     * @return $this
     */
    public function setMethod(?string $method = null): static
    {
        $this->method = $method;

        return $this;
    }
}

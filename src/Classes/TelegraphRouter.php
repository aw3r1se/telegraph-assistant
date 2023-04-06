<?php

namespace Aw3r1se\TelegraphAssistant\Classes;

use Aw3r1se\TelegraphAssistant\DTO\TelegraphRouteDTO;
use Illuminate\Support\Collection;

class TelegraphRouter
{
    protected Collection $route_collection;

    public function __construct()
    {
        $this->route_collection = collect();
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->route_collection->isNotEmpty();
    }

    /**
     * @param string $command
     * @param string $handler_class
     * @param string $handler_method
     * @return void
     */
    public function add(
        string $command,
        string $handler_class,
        string $handler_method
    ): void {
        $dto = new TelegraphRouteDTO();
        $dto->setCommand($command)
            ->setHandler($handler_class)
            ->setMethod($handler_method);

        $this->route_collection->push($dto);
    }

    /**
     * @param string $name
     * @return TelegraphRouteDTO
     */
    public function findByCommand(string $name): TelegraphRouteDTO
    {
        return $this->route_collection
            ->where(['command' => $name])
            ->firstOrFail();
    }
}

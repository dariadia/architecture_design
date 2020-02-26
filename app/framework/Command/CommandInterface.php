<?php

namespace Framework\Command;

/**
 * Интерфейс Команды объявляет метод для выполнения команд.
 */
interface Command
{
    public function execute(): void;
}

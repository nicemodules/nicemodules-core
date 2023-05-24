<?php

namespace NiceModules\Core;

class Hook extends Singleton
{
    protected array $hooks = [];

    /**
     * @param string $hookName
     * @param callable $callback
     * @param int $position
     * @throws Exception
     */
    public function pin(string $hookName, callable $callback, int $position = 0)
    {
        if ($position) {
            if (isset($this->hooks[$position])) {
                throw new Exception(
                    'Hook name ' . $hookName . ' position ' . $position . ' already exist: ' . implode(
                        '::',
                        $this->hooks[$position]
                    )
                );
            }

            $this->hooks[$hookName][$position] = $callback;
        } else {
            $this->hooks[$hookName][] = $callback;
        }
    }

    /**
     * @param string $hookName
     * @param mixed $params
     */
    public function execute(string $hookName, mixed &$params): void
    {
        if (isset($this->hooks[$hookName])) {
            /** @var callable $callback */
            foreach ($this->hooks[$hookName] as $callback) {
                call_user_func($callback, $params);
            }
        }
    }

}
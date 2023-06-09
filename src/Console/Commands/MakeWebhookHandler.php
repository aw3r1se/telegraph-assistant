<?php

namespace Aw3r1se\TelegraphAssistant\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MakeWebhookHandler extends Command
{
    protected $signature = 'make:wh {name}';

    public function handle(): void
    {
        $this->make('WebhookHandler');
    }

    protected function make(string $stub): void
    {
        $contents = File::get(__DIR__ . "/stubs/$stub.stub");

        $name = $this->argument('name');
        $contents = $this->replaceClassNameWith($stub . 'Stub', $name, $contents);

        $path = config('telegraph_assistant.webhook_path');
        $contents = $this->replaceNamespaceWith('NamespaceStub', $path, $contents);
        $contents = $this->replaceParent($contents);

        $this->put($path, $name, $contents);
    }

    /**
     * @param string $old_name
     * @param string $new_name
     * @param string $contents
     * @return string
     */
    protected function replaceClassNameWith(
        string $old_name,
        string $new_name,
        string $contents,
    ): string {
        return preg_replace("#$old_name#ui", ucfirst($new_name), $contents);
    }

    /**
     * @param string $old
     * @param string $path
     * @param string $contents
     * @return string
     */
    protected function replaceNamespaceWith(
        string $old,
        string $path,
        string $contents,
    ): string {
        $new = $this->createNamespaceFromPath($path);

        return preg_replace("#$old#ui", $new, $contents);
    }

    /**
     * @param string $contents
     * @return string
     */
    protected function replaceParent(string $contents): string
    {
        $new = config('telegraph.webhook_handler');
        $contents = preg_replace("#use StubUse;#ui", '', $contents);
        $contents = preg_replace("#StubUse#ui", $new, $contents);

        $basename = class_basename($new);
        $contents = preg_replace("#StubParent#ui", $basename, $contents);

        return preg_replace('#\n{2,}#ui', PHP_EOL . PHP_EOL, $contents);
    }

    /**
     * @param string $path
     * @param string $base
     * @return string
     */
    protected function createNamespaceFromPath(string $path, string $base = 'App'): string
    {
        $namespace = Str::of($path)
            ->after(app_path())
            ->replace('/', '\\')
            ->replace('.php', '');

        return "{$base}\\{$namespace}";
    }

    /**
     * @param string $path
     * @param string $name
     * @param string $contents
     * @return void
     */
    protected function put(
        string $path,
        string $name,
        string $contents
    ): void {
        File::ensureDirectoryExists($path);
        $path = $path . '/' . ucfirst($name) . '.php';
        if (File::exists($path)) {
            $this->error('File already exists');
            return;
        }
        File::put($path, $contents);
        $this->info("File created at $path");
    }
}

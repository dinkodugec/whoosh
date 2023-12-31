<?php

namespace Framework\View\Engine;

use Framework\View\Engine\HasManager;
use Framework\View\View;
use function view;

class PhpEngine implements Engine
{
    use HasManager;

    // protected string $path;
    // protected ?string $layout;
    // protected string $contents;

    protected $layouts = [];

    // public function render(string $path, array $data = []): string
    public function render(View $view): string
    {
        // $this->path = $path;

        // extract($data);
        extract($view->data);  /* The keys in the array will become the 
        variable names and their values will be assigned to these
        new variables. */

        ob_start();
        // include($this->path);
        include($view->path);
        $contents = ob_get_contents();
        ob_end_clean();

        // if ($this->layout) {
        if ($layout = $this->layouts[$view->path] ?? null) {
            // $__layout = $this->layout;

            // $this->layout = null;
            // $view->contents = $contents;

            // $contentsWithLayout = view($__layout, $data);
            $contentsWithLayout = view($layout, array_merge(
                $view->data,
                ['contents' => $contents],
            ));

            return $contentsWithLayout;
        }

        return $contents;
    }

    // protected function escape(string $content): string
    // {
    //     return htmlspecialchars($content, ENT_QUOTES);
    // }

    protected function extends(string $template): static
    {
        // $this->layout = $template;
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $this->layouts[realpath($backtrace[0]['file'])] = $template;
        return $this;
    }

    // protected function includes(string $template, $data = []): void
    // {
    //     print view($template, $data);
    // }

    public function __call(string $name, $values)
    {
        return $this->manager->useMacro($name, ...$values);
    }
}

/* Input = array("a" => "one", "b" => "two", "c" => "three")
Output :$a = "one" , $b = "two" , $c = "three"
Explanation: The keys in the input array will become the 
variable names and th eir values will be assigned to these
new variables. */

/* ob_start() - Think of ob_start() as saying 
"Start remembering everything that would normally be outputted, but don't quite do anything with it yet." */
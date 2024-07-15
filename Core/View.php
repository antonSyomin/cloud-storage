<?php


namespace Core;

class View 
{   
    private $templateDir;

    public function __construct(string $class)
    {
        
        $classNameGroups = explode('\\', $class);
        $this->templateDir = array_pop($classNameGroups);
    }

    public function render(string $template, string $title, array $data = [])
    {
        $page_content = $this->renderTemplate($this->templateDir . "/" . $template, $data);
        $result_page = $this->renderTemplate('layout.php', ['content' => $page_content, 'title' => $title]);
        return $result_page;
    }

    private function renderTemplate(string $template, array $data = [])
    {   
        extract($data);

        ob_start();

        if (file_exists(__DIR__ . "/../Templates/" . $template)) {
            require __DIR__ . "/../Templates/" . $template;
        } else {
            Logger::log("Шаблон " . __DIR__ . "/../Templates/{$template} не найден");
        }

        return ob_get_clean();
    }
}

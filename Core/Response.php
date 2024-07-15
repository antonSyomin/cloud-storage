<?php


namespace Core;

/*
    создаёт http-запрос и опредляет формат контента
*/
class Response 
{
    function __construct(
        public mixed $data = [], 
        public array $headers = [], 
        public int $code = 200
    ) 
    {
        $this->setHeaders($data);
        $this->setData($data);
    }

    protected function setHeaders($data)
    {
        if($data === false) {
            $this->setHeader('HTTP/1.1 500 Internal Server Error');
            $this->setHeader("Status: 500 Internal Server Error");
        } 
    }

    function setData(mixed $data): void
    {
        if (is_array($data) && !empty($data)) {
            $this->setHeader('Content-Type: application/json');
            $data = json_encode($data);
        }
        
        $this->data = $data;
    }

    public function render(): void
    {
        foreach($this->headers as $header) {
            header($header);
        }

        if (!empty($this->data)) {
            echo $this->data;
        }
    }

    function setCode(int $code): void
    {
        $this->code = $code;
    }

    function getCode(): int
    {
        return $this->code;
    }

    function getData(): string
    {
        return $this->data;
    }

    function setHeader(string $header)
    {
        $this->headers[] = $header;
    }

    function getHeaders(): array
    {
        return $this->headers;
    }
}
<?php

class Stack
{
    private $list;

    public function push($element)
    {
        $this->list[] = $element;
    }

    public function pop()
    {
        if (empty($this->list)) {
            return null;
        }

        return array_pop($this->list);
    }

    public function getLast()
    {
        if (empty($this->list)) {
            return null;
        }

        return end($this->list);
    }

    public function clear()
    {
        $this->list = [];
    }
}

class ExpressionParser
{
    private const QUOTES_LIST = ['{', '}', '[', ']', '(', ')'];

    /** @var string[] Сопоставление открывающей и закрывающей скобки */
    private const QUOTES_MAP = ['{' => '}', '[' => ']', '(' => ')'];

    private const RIGHT = 'Верно';
    private const WRONG = 'Не верно';

    private $stack;

    public function __construct()
    {
        $this->stack = new Stack();
    }

    public function validateQuotes(string $string): string
    {
        foreach (str_split($string) as $symbol) {
            if (!in_array($symbol, self::QUOTES_LIST)) {
                continue;
            }

            if ($this->checkIsClosed($this->stack->getLast(), $symbol)) {
                $this->stack->pop();
            } else {
                $this->stack->push($symbol);
            }
        }

        $response = $this->stack->getLast() ? self::WRONG : self::RIGHT;

        $this->stack->clear();

        return $response;
    }

    /**
     * Проверка закрывает закрывается ли символ $left символом $right
     */
    private function checkIsClosed($left, $right): bool
    {
        if (isset(self::QUOTES_MAP[$left]) && self::QUOTES_MAP[$left] === $right) {
            return true;
        }

        return false;
    }
}

$expressionParser = new ExpressionParser();

echo $expressionParser->validateQuotes('[1+2{({})}]') . '<br>';
echo $expressionParser->validateQuotes('[1+2{({})}]}') . '<br>';
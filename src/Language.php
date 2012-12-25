<?php

namespace BrainFuck;

class Language
{

    public function run($code, $input)
    {
        $allowed = array('<', '>', '+', '-', '.', ',', '[', ']');

        $output = array();
        $inputPointer = 0;

        $pointer = 0;
        $data = array(0);
        $ip = -1;

        while (isset($code[$ip + 1])) {
            $ip++;

            if (!in_array($code[$ip], $allowed)) {
                continue;
            }

            switch ($code[$ip]) {
                case '>':
                    $pointer++;
                    if (!isset($data[$pointer])) {
                        $data[$pointer] = 0;
                    }
                    break;
                case '<':
                    $pointer--;
                    break;
                case '+':
                    $data[$pointer]++;
                    break;
                case '-':
                    $data[$pointer]--;
                    break;
                case '.':
                    $output[] = $data[$pointer];
                    break;
                case ',':
                    $data[$pointer] = $input[$inputPointer];
                    $inputPointer++;
                    break;
                case '[';
                    if ($data[$pointer] != 0) {
                        continue;
                    }
                    $ptr = $ip + 1;
                    $nesting = 0;
                    while (isset($code[$ptr])) {
                        if ($code[$ptr] == ']' && $nesting == 0) {
                            $ip = $ptr;
                            continue 2;
                        }
                        if ($code[$ptr] == '[') {
                            $nesting++;
                        } elseif ($code[$ptr] == ']') {
                            $nesting--;
                        }
                        $ptr++;
                    }
                    throw new LogicException("Unable to find matching brace.");
                    break;
                case ']':
                    $ptr = $ip - 1;
                    $nesting = 0;
                    while (isset($code[$ptr])) {
                        if ($code[$ptr] == '[' && $nesting == 0) {
                            $ip = $ptr - 1;
                            continue 2;
                        }
                        if ($code[$ptr] == ']') {
                            $nesting++;
                        } elseif ($code[$ptr] == '[') {
                            $nesting--;
                        }
                        $ptr--;
                    }
                    throw new LogicException("Unable to find matching brace.");
                    break;
            }

        }
        return $output;
    }

}

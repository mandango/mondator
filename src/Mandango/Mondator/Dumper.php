<?php

/*
 * Copyright 2010 Pablo Díez <pablodip@gmail.com>
 *
 * This file is part of Mandango.
 *
 * Mandango is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Mandango is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Mandango. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mandango\Mondator;

use Mandango\Mondator\Definition\Definition as BaseDefinition;

/**
 * The Mondator Dumper.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Dumper
{
    protected $definition;

    /**
     * Constructor.
     *
     * @param Mandango\Mondator\Definition\Definition $definition The definition.
     */
    public function __construct(BaseDefinition $definition)
    {
        $this->setDefinition($definition);
    }

    /**
     * Set the definition.
     *
     * @param Mandango\Mondator\Definition\Definition $definition The definition.
     */
    public function setDefinition(BaseDefinition $definition)
    {
        $this->definition = $definition;
    }

    /**
     * Returns the definition
     *
     * @return Mandango\Mondator\Definition\Definition The definition.
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Dump the definition.
     *
     * @return string The PHP code of the definition.
     */
    public function dump()
    {
        return
            $this->startFile().
            $this->addNamespace().
            $this->startClass().
            $this->addProperties().
            $this->addMethods().
            $this->endClass()
        ;
    }

    /**
     * Export an array.
     *
     * Based on Symfony\Component\DependencyInjection\Dumper\PhpDumper::exportParameters
     * http://github.com/symfony/symfony
     *
     * @param array $array  The array.
     * @param int   $indent The indent.
     *
     * @return string The array exported.
     */
    static public function exportArray(array $array, $indent)
    {
        $code = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::exportArray($value, $indent + 4);
            } else {
                $value = null === $value ? 'null' : var_export($value, true);
            }

            $code[] = sprintf('%s%s => %s,', str_repeat(' ', $indent), var_export($key, true), $value);
        }

        return sprintf("array(\n%s\n%s)", implode("\n", $code), str_repeat(' ', $indent - 4));
    }

    protected function startFile()
    {
        return <<<EOF
<?php

EOF;
    }

    protected function addNamespace()
    {
        if (!$namespace = $this->definition->getNamespace()) {
            return '';
        }

        return <<<EOF

namespace $namespace;

EOF;
    }

    protected function startClass()
    {
        $code = "\n";

        // doc comment
        if ($docComment = $this->definition->getDocComment()) {
            $code .= $docComment."\n";
        }

        /*
         * declaration
         */
        $declaration = '';

        // abstract
        if ($this->definition->getIsAbstract()) {
            $declaration .= 'abstract ';
        }

        // class
        $declaration .= 'class '.$this->definition->getClassName();

        // parent class
        if ($parentClass = $this->definition->getParentClass()) {
            $declaration .= ' extends '.$parentClass;
        }

        // interfaces
        if ($interfaces = $this->definition->getInterfaces()) {
            $declaration .= ' implements '.implode(', ', $interfaces);
        }

        $code .= <<<EOF
$declaration
{
EOF;

        return $code;
    }

    protected function addProperties()
    {
        $code = '';

        $properties = $this->definition->getProperties();
        foreach ($properties as $property) {
            $code .= "\n";

            if ($docComment = $property->getDocComment()) {
                $code .= $docComment."\n";
            }
            $isStatic = $property->getIsStatic() ? 'static ' : '';

            $value = $property->getValue();
            if (null === $value) {
                $code .= <<<EOF
    $isStatic{$property->getVisibility()} \${$property->getName()};
EOF;
            } else {
                $value = is_array($property->getValue()) ? self::exportArray($property->getValue(), 8) : var_export($property->getValue(), true);

                $code .= <<<EOF
    $isStatic{$property->getVisibility()} \${$property->getName()} = $value;
EOF;
            }
        }
        if ($properties) {
            $code .= "\n";
        }

        return $code;
    }

    protected function addMethods()
    {
        $code = '';

        foreach ($this->definition->getMethods() as $method) {
            $code .= "\n";

            // doc comment
            if ($docComment = $method->getDocComment()) {
                $code .= $docComment."\n";
            }

            // isFinal
            $isFinal = $method->getIsFinal() ? 'final ' : '';

            // isStatic
            $isStatic = $method->getIsStatic() ? 'static ' : '';

            // abstract
            if ($method->getIsAbstract()) {
                $code .= <<<EOF
    abstract $isStatic{$method->getVisibility()} function {$method->getName()}({$method->getArguments()});
EOF;
            } else {
                $methodCode = trim($method->getCode());
                if ($methodCode) {
                    $methodCode = '    '.$methodCode."\n    ";
                }
                $code .= <<<EOF
    $isFinal$isStatic{$method->getVisibility()} function {$method->getName()}({$method->getArguments()})
    {
    $methodCode}
EOF;
            }

            $code .= "\n";
        }

        return $code;
    }

    protected function endClass()
    {
        $code = '';

        if (!$this->definition->getProperties() && !$this->definition->getMethods()) {
            $code .= "\n";
        }

        $code .= <<<EOF
}
EOF;

        return $code;
    }
}

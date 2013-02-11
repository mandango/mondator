<?php

/*
 * This file is part of Mandango.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mandango\Mondator\Tests;

use Mandango\Mondator\Extension;
use Mandango\Mondator\Mondator;

class MondatorTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigClasses()
    {
        $mondator = new Mondator();
        $mondator->setConfigClass('Article', $article = array(
            'title'   => 'string',
            'content' => 'string',
        ));
        $mondator->setConfigClass('Comment', $comment = array(
            'name' => 'string',
            'text' => 'string',
        ));

        $this->assertTrue($mondator->hasConfigClass('Article'));
        $this->assertFalse($mondator->hasConfigClass('Category'));

        $this->assertSame($article, $mondator->getConfigClass('Article'));
        $this->assertSame($comment, $mondator->getConfigClass('Comment'));

        $this->assertSame(array('Article' => $article, 'Comment' => $comment), $mondator->getConfigClasses());

        $mondator->setConfigClasses($classes = array(
            'Category' => array('name' => 'string'),
            'Post'     => array('message' => 'string'),
        ));
        $this->assertSame($classes, $mondator->getConfigClasses());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetConfigClassNotExists()
    {
        $mondator = new Mondator();
        $mondator->getConfigClass('Article');
    }

    public function testExtensions()
    {
        $extension1 = new ExtensionTesting(array('required' => 'value'));
        $extension2 = new ExtensionTesting(array('required' => 'value'));
        $extension3 = new ExtensionTesting(array('required' => 'value'));
        $extension4 = new ExtensionTesting(array('required' => 'value'));

        $mondator = new Mondator();

        $mondator->addExtension($extension1);
        $mondator->addExtension($extension2);
        $this->assertSame(array($extension1, $extension2), $mondator->getExtensions());

        $mondator->setExtensions($extensions = array($extension3, $extension4));
        $this->assertSame($extensions, $mondator->getExtensions());
    }

    public function testGenerateContainers()
    {
        $mondator = new Mondator();
        $mondator->setConfigClasses(array(
            'Article' => array(
                'name' => 'foo',
            ),
            'Category' => array(
                'name' => 'bar',
            ),
        ));
        $mondator->setExtensions(array(
            new \Mandango\Mondator\Tests\Fixtures\Extension\Name(),
            new \Mandango\Mondator\Tests\Fixtures\Extension\InitDefinition(array(
                'definition_name' => 'myclass',
                'class_name'      => 'MiClase',
            )),
            new \Mandango\Mondator\Tests\Fixtures\Extension\AddProperty(array(
                'definition' => 'myclass',
                'visibility' => 'public',
                'name'       => 'MiPropiedad',
                'value'      => 'foobar',
            )),
        ));

        $containers = $mondator->generateContainers();

        $this->assertSame(3, count($containers));
        $this->assertTrue(isset($containers['_global']));
        $this->assertTrue(isset($containers['Article']));
        $this->assertTrue(isset($containers['Category']));
        $this->assertInstanceOf('Mandango\Mondator\Container', $containers['Article']);
        $this->assertInstanceOf('Mandango\Mondator\Container', $containers['Category']);

        $definitions = $containers['Article'];
        $this->assertSame(2, count($definitions->getDefinitions()));
        $this->assertTrue(isset($definitions['name']));
        $this->assertTrue(isset($definitions['myclass']));
        $this->assertSame('foo', $definitions['name']->getClassName());

        $definitions = $containers['Category'];
        $this->assertSame(2, count($definitions->getDefinitions()));
        $this->assertTrue(isset($definitions['name']));
        $this->assertTrue(isset($definitions['myclass']));
        $this->assertSame('bar', $definitions['name']->getClassName());
    }

    public function testGenerateContainersNewConfigClasses()
    {
        $mondator = new Mondator();
        $mondator->setConfigClasses(array(
            'Article' => array(
                'name' => 'MyArticle',
                'extensions' => array(
                    array(
                        'class'   => 'Mandango\Mondator\Tests\Fixtures\Extension\NewConfigClass',
                        'options' => array(
                            'suffix'   => 'Translation',
                            'name'     => 'translation',
                            'multiple' => true,
                            'multiple_suffix' => 'Multiple',
                            'multiple_name'   => 'multiplex',
                        ),
                    ),
                ),
            ),
            'Category' => array(
                'name' => 'MyCategory',
            ),
        ));
        $mondator->setExtensions(array(
            new \Mandango\Mondator\Tests\Fixtures\Extension\Name(),
            new \Mandango\Mondator\Tests\Fixtures\Extension\ProcessOthersFromArray(),
        ));

        $containers = $mondator->generateContainers();

        $this->assertSame(5, count($containers));
        $this->assertTrue(isset($containers['_global']));
        $this->assertTrue(isset($containers['Article']));
        $this->assertTrue(isset($containers['ArticleTranslation']));
        $this->assertTrue(isset($containers['ArticleTranslationMultiple']));
        $this->assertTrue(isset($containers['Category']));
    }

    public function testProcessUsesNamespaceSeparatorForNestingClassFilesInDirectories()
    {
        $tmpDir = sys_get_temp_dir();
        $expectedFile = $tmpDir.'/MiClase/Test.php';

        if (file_exists($expectedFile)) {
            unlink($expectedFile);
        }

        $mondator = new Mondator();
        $mondator->setConfigClass('Foo', array());
        $mondator->setExtensions(array(
            new \Mandango\Mondator\Tests\Fixtures\Extension\InitDefinition(array(
                'definition_name' => 'myclass',
                'class_name'      => 'MiClase\Test',
                'output_dir'      => $tmpDir
            )),
            new \Mandango\Mondator\Extension\NamespaceSeparatorOutputFixerExtension(),
        ));
        $mondator->process();

        $this->assertFileExists($expectedFile);
    }
}

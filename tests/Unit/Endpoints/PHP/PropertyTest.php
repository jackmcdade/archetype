<?php

namespace PHPFileManipulator\Tests\Unit\Endpoints;

use PHPFileManipulator\Tests\FileTestCase;
use PhpParser\BuilderFactory;

use PHPFile;
use LaravelFile;

class PropertyTest extends FileTestCase
{
    /** @test */
    public function it_can_get_a_class_property()
    {
        $property = PHPFile::load('app/Providers/RouteServiceProvider.php')->property('namespace');

        $this->assertEquals(
            "App\Http\Controllers",
            $property
        );
    }

    /** @test */
    public function it_can_update_existing_class_properties()
    {
        $newValue = 'Reset fillable to a single string!';
        $property = PHPFile::load('app/User.php')
            ->property('fillable', $newValue)
            ->property('fillable');

        $this->assertEquals(
            $property,
            $newValue
        );
    }

    /** @test */
    public function it_can_create_a_new_class_property()
    {
        $property = PHPFile::load('app/User.php')
            ->property('master', 'yoda')
            ->property('master');

        $this->assertEquals(
            $property,
            'yoda'
        );
    }
    
    /** @test */
    public function it_can_create_a_new_class_property_when_empty()
    {
        $property = PHPFile::load(__DIR__ . '../../../../samples/EmptyClass.php')        
            ->property('master', 'yoda')
            ->property('master');

        $this->assertEquals(
            $property,
            'yoda'
        );
    }
    
    /** @test */
    public function it_can_set_empty_property_by_using_explicit_set_method()
    {
        $property = PHPFile::load(__DIR__ . '../../../../samples/EmptyClass.php')        
            ->setProperty('empty')
            ->property('empty');

        $this->assertEquals(
            $property,
            null
        );
    }

    /** @test */
    public function it_can_set_visibility_using_directives()
    {
        $output = PHPFile::load(__DIR__ . '../../../../samples/EmptyClass.php')
            ->private()->setProperty('parts')
            ->render();

        $this->assertStringContainsString(
            'private $parts;',
            $output,
        );
    }
    
    /** @test */
    public function it_can_remove_properties()
    {
        $output = LaravelFile::load('app/User.php')
            ->remove()->property('fillable')
            ->fillable();

        $this->assertNull($output);
    }
    
    /** @test */
    public function it_can_clear_properties()
    {
        $output = LaravelFile::load('app/User.php')
            ->clear()->property('fillable')
            ->fillable();

        $this->assertNull($output);
    }

    /** @test */
    public function it_can_empty_properties()
    {
        $output = LaravelFile::load('app/User.php')
            ->empty()->property('fillable')
            ->property('fillable');

            $this->assertEquals($output, []);
    }
    
    /** @test */
    public function it_can_empty_string_properties()
    {
        $output = LaravelFile::load('app/User.php')
            ->property('someString', 'hiya')
            ->empty()->property('someString')
            ->property('someString');

        $this->assertEquals($output, '');
    }

    /** @test */
    public function it_can_empty_non_array_or_string_properties_into_a_default_of_null()
    {
        $output = LaravelFile::load('app/User.php')
            ->property('someNonArrayOrStringType', 123)
            ->empty()->property('someNonArrayOrStringType')
            ->property('someNonArrayOrStringType');

        $this->assertNull($output);
    }    
}
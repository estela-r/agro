<?php
declare(strict_types=1);

namespace Tillage\Validator;


use Zend\Filter\StringTrim;
use Zend\Filter\ToFloat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

class TillageInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'tractor_id',
            'required' => true,
            'validators' => [
                [
                    'name' => GreaterThan::class,
                    'options' => ['min' => 0],
                ]
            ]
        ]);

        $this->add([
            'name' => 'plot_id',
            'required' => true,
            'validators' => [
                [
                    'name' => GreaterThan::class,
                    'options' => ['min' => 0],
                ]
            ]
        ]);
        
        $this->add([
            'name' => 'area',
            'required' => true,
            'filters' => [
                ['name' => ToFloat::class],
            ],
            'validators' => [
                [
                    'name' => GreaterThan::class,
                    'options' => ['min' => 0],
                ]
            ]
        ]);

    }
}
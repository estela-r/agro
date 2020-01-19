<?php
declare(strict_types=1);

namespace Plots\Validator;


use Zend\Filter\StringTrim;
use Zend\Filter\ToFloat;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\StringLength;

class PlotInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'name',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class]
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => ['min' => 3],
                ]
            ]
        ]);
        $this->add([
            'name' => 'crop',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
            ],
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
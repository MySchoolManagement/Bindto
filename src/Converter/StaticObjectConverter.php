<?php
namespace Bindto\Converter;

use Bindto\Binder;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticObjectConverter extends AbstractConverter
{
    /**
     * {@inheritdoc}
     */
    public function apply($value, $propertyName, array $options, $from, array $metadata)
    {
        if ($value instanceof $options['class']) {
            return $value;
        }

        $options = $this->resolveOptions($options);

        return call_user_func_array([$options['class'], $options['method']], [$value]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => null,
            'method' => null,
        ]);
        $resolver->addAllowedTypes('class', ['string']);
        $resolver->addAllowedTypes('method', ['string']);
    }
}

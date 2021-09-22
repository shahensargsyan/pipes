<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\ReviewRequest;
use Botble\Ecommerce\Models\Review;

class ReviewForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    public function buildForm()
    {

        $this
            ->setupModel(new Review)
            ->setValidatorClass(ReviewRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('plugins/ecommerce::review.customer_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::review.customer_name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('star', 'number', [
                'label'      => trans('plugins/ecommerce::review.star'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::review.star'),
                    'data-counter' => 120,
                ],
            ])
            ->add('comment', 'text', [
                'label'      => trans('plugins/ecommerce::review.comment'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/ecommerce::review.comment'),
                    'data-counter' => 120,
                ],
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('plugins/ecommerce::review.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('created_at', 'text', [
                'label'         => __('End date'),
                'label_attr'    => ['class' => 'control-label required'],
                'attr'          => [
                    'class'            => 'form-control datepicker',
                    'data-date-format' => 'yyyy/mm/dd',
                ],
                'default_value' => now()->addDay()->format('Y/m/d H:i:s'),
            ])
//            ->setBreakFieldPoint('created_at')
        ;
    }
}

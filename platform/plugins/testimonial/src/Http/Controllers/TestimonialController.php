<?php

namespace Botble\Testimonial\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Testimonial\Forms\TestimonialForm;
use Botble\Testimonial\Http\Requests\TestimonialRequest;
use Botble\Testimonial\Models\Testimonial;
use Botble\Testimonial\Tables\TestimonialTable;
use Exception;
use Illuminate\Http\Request;

class TestimonialController extends BaseController
{
    public function index(TestimonialTable $table)
    {
        PageTitle::setTitle(trans('plugins/testimonial::testimonial.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/testimonial::testimonial.create'));

        return $formBuilder->create(TestimonialForm::class)->renderForm();
    }

    public function store(TestimonialRequest $request, BaseHttpResponse $response)
    {
        $testimonial = Testimonial::query()->create($request->input());

        event(new CreatedContentEvent(TESTIMONIAL_MODULE_SCREEN_NAME, $request, $testimonial));

        return $response
            ->setPreviousUrl(route('testimonial.index'))
            ->setNextUrl(route('testimonial.edit', $testimonial->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Testimonial $testimonial, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $testimonial->name]));

        return $formBuilder->create(TestimonialForm::class, ['model' => $testimonial])->renderForm();
    }

    public function update(Testimonial $testimonial, TestimonialRequest $request, BaseHttpResponse $response)
    {
        $testimonial->fill($request->input());
        $testimonial->save();

        event(new UpdatedContentEvent(TESTIMONIAL_MODULE_SCREEN_NAME, $request, $testimonial));

        return $response
            ->setPreviousUrl(route('testimonial.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Testimonial $testimonial, Request $request, BaseHttpResponse $response)
    {
        try {
            $testimonial->delete();

            event(new DeletedContentEvent(TESTIMONIAL_MODULE_SCREEN_NAME, $request, $testimonial));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
}

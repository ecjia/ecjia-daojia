<?php

namespace Royalcms\Component\Foundation\Validation;

use Royalcms\Component\Http\Request;
use Royalcms\Component\Http\JsonResponse;
use Royalcms\Component\Routing\UrlGenerator;
use Royalcms\Component\Contracts\Validation\Factory;
use Royalcms\Component\Contracts\Validation\Validator;
use Royalcms\Component\Http\Exception\HttpResponseException;

trait ValidatesRequests
{
    /**
     * The default error bag.
     *
     * @var string
     */
    protected $validatesRequestErrorBag;

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     *
     * @throws \Royalcms\Component\Http\Exception\HttpResponseException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
    }

    /**
     * Validate the given request with the given rules.
     *
     * @param  string  $errorBag
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     *
     * @throws \Royalcms\Component\Http\Exception\HttpResponseException
     */
    public function validateWithBag($errorBag, Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $this->withErrorBag($errorBag, function () use ($request, $rules, $messages, $customAttributes) {
            $this->validate($request, $rules, $messages, $customAttributes);
        });
    }

    /**
     * Throw the failed validation exception.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  \Royalcms\Component\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Royalcms\Component\Http\Exception\HttpResponseException
     */
    protected function throwValidationException(Request $request, $validator)
    {
        throw new HttpResponseException($this->buildFailedValidationResponse(
            $request, $this->formatValidationErrors($validator)
        ));
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Royalcms\Component\Http\Request  $request
     * @param  array  $errors
     * @return \Royalcms\Component\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input())
                        ->withErrors($errors, $this->errorBag());
    }

    /**
     * Format the validation errors to be returned.
     *
     * @param  \Royalcms\Component\Contracts\Validation\Validator  $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

    /**
     * Get the URL we should redirect to.
     *
     * @return string
     */
    protected function getRedirectUrl()
    {
        return royalcms(UrlGenerator::class)->previous();
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Royalcms\Component\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return royalcms(Factory::class);
    }

    /**
     * Execute a Closure within with a given error bag set as the default bag.
     *
     * @param  string  $errorBag
     * @param  callable  $callback
     * @return void
     */
    protected function withErrorBag($errorBag, callable $callback)
    {
        $this->validatesRequestErrorBag = $errorBag;

        call_user_func($callback);

        $this->validatesRequestErrorBag = null;
    }

    /**
     * Get the key to be used for the view error bag.
     *
     * @return string
     */
    protected function errorBag()
    {
        return $this->validatesRequestErrorBag ?: 'default';
    }
}

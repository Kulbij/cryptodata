<?php namespace Sebastian\Forms\Components;

use Mail;
use Flash;
use Exception;
use ValidationException;
use Cms\Classes\ComponentBase;
use Sebastian\Forms\Models\Application as ApplicationModel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Sebastian\Forms\Models\ApplicationSetting;

class Application extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'Application Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [
            'mail_recipient' => [
                'title' => 'Recipient',
                'description' => 'Specify email recipient (If no recipient is specified, email message will be send the default email address)',
                'type' => 'string',
                'group' => 'Recipient',
                'showExternalParam' => false
            ],
            'rules' => [
                'title' => 'Rules',
                'description' => 'Set your own rules using Laravel validation',
                'type' => 'dictionary',
                'group' => 'Form Validation',
                'showExternalParam' => false,
            ],
            'rules_messages' => [
                'title' => 'Rules Messages',
                'description' => 'Use your own rules messages using Laravel validation',
                'type' => 'dictionary',
                'group' => 'Form Validation',
                'showExternalParam' => false,
            ],
            'mail_template' => [
                'title' => 'Mail Template',
                'description' => 'Use custom mail template. Specify template code like "sebastian.forms::mail.franchise" (found on Settings, Mail templates). Leave empty to use default.',
                'type' => 'string',
                'group' => 'Notifications Settings',
                'showExternalParam' => false
            ],
            'success_message' => [
                'title' => 'Success Message',
                'description' => 'You can add flash messages.',
                'type' => 'string',
                'group' => 'Flash messages',
                'showExternalParam' => false
            ],
        ];
    }

    public function onSendForm()
    {
        /**
         * @var array
         */
        $rules = $this->getRules();

        try {

            /**
             * Validate submited code
             */
            $validation = Validator::make(request()->all(), $rules, $this->getCustomRulesMessages());

            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            /**
             * @var \Sebastian\Forms\Models\Application
             */
            $application = new ApplicationModel();

            $application->fill(request()->all());
            $application->text = !empty(request()->get('message')) ? request()->get('message') : post('message');
            $application->ip = request()->ip();
            $application->user_agent = request()->userAgent();
            $application->url = request()->url();
            $application->save();

            $this->sendMail($application);
        } catch (Exception $ex) {
            $this->getExceptionMassage($ex);
        }

        Flash::success('Mesajul a fost trimis cu succes');
    }

    public function sendMail(ApplicationModel $application)
    {
        if (!ApplicationSetting::get('to_email')) {
            return null;
        }

        if (!ApplicationSetting::get('tempalte_cde')) {
            return null;
        }

        Mail::send($this->getMailTemplate(), [
            'order' => $application->toArray()
        ], function($message) use ($application) {
            $message->replyTo(
                $application->email,
                $application->name
            );
            $message->sender(
                $application->email,
                $application->name
            );
            $message->from(
                $application->email,
                $application->name
            );

            $message->to($this->getRecipient());
            $message->cc(
                $application->email,
                $application->name
            );
            $message->subject(ApplicationSetting::get('subject'));
        });
    }

    /**
     * @return array
     */
    private function getRules(): array
    {
        if ($this->property('rules')) {

            /**
             * @var array
             */
            return $this->property('rules');
        }

        /**
         * @var array
         */
        return [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ];
    }

    /**
     * @return array
     */
    private function getCustomRulesMessages(): array
    {
        if ($this->property('rules_messages')) {

            /**
             * @var array
             */
            return $this->property('rules_messages');
        }

        /**
         * @var array
         */
        return [
            'name.required' => 'Numele este invalid',
            'phone.required' => 'Numărul de telefon este invalid',
            'email.required' => 'Adresa de email este invalidă',
            'email.email' => 'Adresa de email este invalidă',
            'message.required' => 'Mesajul este invalid',
        ];
    }

    /**
     * @return string
     */
    private function getMailTemplate(): string
    {
        if ($this->property('mail_template')) {

            /**
             * @var string
             */
            return $this->property('mail_template');
        }

        /**
         * @var string
         */
        return ApplicationSetting::get('tempalte_cde');
    }

    /**
     * @return string
     */
    private function getRecipient(): ?string
    {
        if ($this->property('mail_recipient')) {
            return $this->property('mail_recipient');
        }

        return ApplicationSetting::get('to_email');
    }

    /**
     * Get exception message
     *
     * @param \Exception $ex
     * @throws \Exception
     */
    private function getExceptionMassage(Exception $ex)
    {
        if (Request::ajax()) {
            throw $ex;
        }

        Flash::error($ex->getMessage());
    }
}

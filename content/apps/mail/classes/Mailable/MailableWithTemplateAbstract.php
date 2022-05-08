<?php

namespace Ecjia\App\Mail\Mailable;

use Ecjia\App\Mail\Models\MailTemplateModel;

abstract class MailableWithTemplateAbstract extends MailableAbstract
{
    /**
     * @var string
     */
    protected $eventCode;

    /**
     * @var MailTemplateModel
     */
    protected $templateModel;


    public function __construct()
    {
        $this->templateModel = (new MailTemplateModel())->getTemplateByCode($this->eventCode);

    }

    public function build()
    {
        parent::build();

        if (empty($this->templateModel)) {
            throw new \InvalidArgumentException(__('邮件模板不存在', 'mail'));
        }
    }

    /**
     * @return MailTemplateModel
     */
    public function getTemplateModel(): ?MailTemplateModel
    {
        return $this->templateModel;
    }

    /**
     * @param MailTemplateModel $templateModel
     * @return MailableAbstract
     */
    public function setTemplateModel(MailTemplateModel $templateModel): MailableAbstract
    {
        $this->templateModel = $templateModel;
        return $this;
    }


}
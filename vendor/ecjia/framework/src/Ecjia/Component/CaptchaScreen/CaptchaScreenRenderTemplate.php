<?php


namespace Ecjia\Component\CaptchaScreen;


use Ecjia\Component\CaptchaScreen\Contracts\CaptchaScreenRenderInterface;

class CaptchaScreenRenderTemplate implements CaptchaScreenRenderInterface
{
    /**
     * @var CaptchaScreenManager
     */
    protected $manager;

    public function __construct(CaptchaScreenManager $manager)
    {
        $this->manager = $manager;
    }

    public function render($value = null)
    {
        return collect($this->manager->getScreens())->map(function (CaptchaScreen $item) use ($value) {
            $item->checkSelected($value);
            return $this->renderTemplate($item);
        })->implode("\n");
    }

    /**
     * @param CaptchaScreen $screen
     * @return string
     */
    protected function renderTemplate(CaptchaScreen $screen)
    {
        $name = $screen->getName();
        $value = $screen->getValue();
        $label = $screen->getLabel();
        if ($screen->isSelected()) {
            $selected = 'checked="checked"';
        } else {
            $selected = '';
        }

        return <<<TEMPLATE
<input type="checkbox" name="{$name}" value="{$value}" {$selected} /><span>{$label}</span>
TEMPLATE;

    }

}
<?php
namespace backend\modules\settings;

use Aabc;
use aabc\base\Action;

class SettingsAction extends Action
{
    /**
     * @var string class name of the model which will be used to validate the attributes.
     * The class should have a scenario matching the `scenario` variable.
     * The model class must implement [[Model]].
     * This property must be set.
     */
    public $modelClass;

    /**
     * @var string The scenario this model should use to make validation
     */
    public $scenario;

    /**
     * @var string the name of the view to generate the form. Defaults to 'settings'.
     */
    public $viewName = 'settings';

    /**
     * Render the settings form.
     */
    public function run()
    {
        /* @var $model \aabc\db\ActiveRecord */
        $model = new $this->modelClass();
        if ($this->scenario) {
            $model->setScenario($this->scenario);
        }
        if ($model->load(Aabc::$app->request->post()) && $model->validate()) {
            foreach ($model->toArray() as $key => $value) {
                Aabc::$app->settings->set($key, $value, $model->formName());
            }
            Aabc::$app->getSession()->addFlash('success',
                Module::t('settings', 'Successfully saved settings on {section}',
                    ['section' => $model->formName()]
                )
            );
        }
        foreach ($model->attributes() as $key) {
            $model->{$key} = Aabc::$app->settings->get($key, $model->formName());
        }
        return $this->controller->render($this->viewName, ['model' => $model]);
    }
}

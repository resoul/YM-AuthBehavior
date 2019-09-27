<?php
namespace getin\behaviors;

use yii\base\Behavior;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

/**
 * AuthBehavior is the auth class for access to website.
 *
 * ```php
 * 'as AuthBehavior' => [
 *     'class' => AuthBehavior::class,
 *     'debug' => YII_DEBUG,
 *     'whiteList' => [
 *          'modules' => ['moduleName', 'moduleName2'],
 *          'controllers' => ['controllerName'],
 *          'actions' => ['actionName'],
 *          'controllerName/actionName',
 *          'moduleName/controllerName/actionName'
 *     ],
 * ]
 * ```
 *
 * @author ReSoul <roberts.mark1985@gmail.com>
 * @version  1.0
 */
class AuthBehavior extends Behavior
{
    /**
     * @var array white list of actions.
     */
    public $whiteList = [];

    /**
     * @var array if access is denied, redirect to this URL.
     */
    public $redirect = ['/site/index'];

    /**
     * @var array white list of actions
     */
    public $debug = false;

    /**
     * Declare event handler to access for controller.
     * @return array
     */
    public function events() : array
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'checkAccess'
        ];
    }

    /**
     * This method checks if user have access to this action.
     * @return $this the response object itself.
     */
    public function checkAccess()
    {
        if (Yii::$app->user->isGuest && !$this->canGo()) {
            Yii::$app->response->redirect(Url::to($this->redirect));
        }
    }

    /**
     * This method checks if the URL exists in the whitelist.
     * @return boolean if url exists, then true will be returned, or if it does not exist, false will be returned.
     */
    protected function canGo() : bool
    {
        if ($this->debug && (Yii::$app->controller->module->id == 'debug')) {
            return true;
        }

        $controllers = [
            Yii::$app->controller->module->id,
            Yii::$app->controller->id,
            Yii::$app->controller->action->id
        ];

        $request = implode('/', $controllers);

        foreach ($this->whiteList as $value) {
            if (!is_array($value) && ($strlen = (int) strlen($value) + 1) && ($value == substr($request, -$strlen))) {
                return true;
            }
        }

        if (!empty($this->whiteList['controllers']) && in_array(Yii::$app->controller->id, $this->whiteList['controllers'])) {
            return true;
        }

        if (!empty($this->whiteList['actions']) && in_array(Yii::$app->controller->action->id, $this->whiteList['actions'])) {
            return true;
        }

        if (!empty($this->whiteList['modules']) && in_array(Yii::$app->controller->module->id, $this->whiteList['modules'])) {
            return true;
        }

        return false;
    }
}

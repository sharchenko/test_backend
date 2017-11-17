<?php


namespace app\components\group;


use app\models\Group;
use app\models\GroupUser;
use yii\base\Component;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class GroupComponent extends Component
{
    /**
     * @return Group
     */
    public function create()
    {
        $group = new Group();
        $group->save();
        return $group;
    }

    /**
     * @param $id
     * @return false|int
     * @throws ForbiddenHttpException
     */
    public function remove($id)
    {
        $group = $this->findGroup($id);

        if ($group->admin->id === \Yii::$app->user->id) {
            return $group->delete();
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $id
     * @return GroupUser
     */
    public function joinRequest($id)
    {
        $group = $this->findGroup($id);

        return GroupUser::create($group);
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return GroupUser
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function joinUser($group_id, $user_id)
    {
        $group = $this->findGroup($group_id);

        if ($group->admin->id === \Yii::$app->user->id) {
            $groupUser = GroupUser::findOne([
                'group_id' => $group_id,
                'user_id' => $user_id,
            ]);
            if (!$groupUser) throw new NotFoundHttpException();
            $groupUser->status = GroupUser::STATUS_APPROVED;
            return $groupUser;
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $group_id
     * @param $user_id
     * @return false|int
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function removeUser($group_id, $user_id)
    {
        $group = $this->findGroup($group_id);

        if ($group->admin->id === \Yii::$app->user->id) {
            $groupUser = GroupUser::findOne([
                'group_id' => $group_id,
                'user_id' => $user_id,
            ]);
            if (!$groupUser) throw new NotFoundHttpException();
            return $groupUser->delete();
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * @param $id
     * @return Group
     * @throws NotFoundHttpException
     */
    public function findGroup($id)
    {
        $group = Group::findOne($id);
        if (!$group) throw new NotFoundHttpException();
        return $group;
    }
}
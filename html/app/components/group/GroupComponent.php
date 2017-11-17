<?php


namespace app\components\group;


use app\models\Group;
use app\models\GroupUser;
use common\models\User;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class GroupComponent extends Component
{
    /**
     * @param $name
     * @return Group
     */
    public function create($name)
    {
        $group = new Group([
            'name' => $name
        ]);
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
     * @return boolean
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
            return $groupUser->save();
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
        $notAdmin = $group->admin->id !== $user_id;

        if ($notAdmin) {
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

    public function inGroup(Group $group, User $user)
    {
        return in_array($user->id, ArrayHelper::getColumn($group->groupUsers, 'user_id'));
    }

    public function isAdmin(Group $group, User $user)
    {
        return $group->created_by === $user->id;
    }

    public function hasAccess(Group $group, User $user)
    {
        return in_array($user->id, ArrayHelper::getColumn($group->groupUsersApproved, 'user_id'));
    }

    public function canEditOrError(Group $group, User $user)
    {
        if (!$this->isAdmin($group, $user)) throw new ForbiddenHttpException();
    }
}
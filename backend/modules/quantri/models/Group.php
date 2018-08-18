<?php

namespace backend\modules\quantri\models;

use Yii;

/**
 * This is the model class for table "tbl_group".
 *
 * @property int $id
 * @property string $groupsName
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupsName', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['groupsName'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupsName' => 'Groups Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getAllGroups()
    {
        return Group::find()->where(['status' => 1])->orderBy('groupsName')->all();
    }

    public static function dropdown()
    {
        // get and cache data
        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->all();
            foreach ($models as $value) {
                $dropdown[$value->id] = $value->groupsName;
            }
        }

        return $dropdown;
    }
}

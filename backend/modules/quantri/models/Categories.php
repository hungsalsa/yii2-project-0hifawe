<?php

namespace backend\modules\quantri\models;

use Yii;

/**
 * This is the model class for table "tbl_categories".
 *
 * @property int $id
 * @property string $cateName
 * @property int $groupId
 * @property int $parent_id
 * @property string $link
 * @property string $images
 * @property int $sort
 * @property string $title
 * @property string $keyword
 * @property string $descriptions
 * @property int $status
 * @property string $created_at
 * @property string $updated_at
 * @property int $userAdd
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cateName', 'groupId', 'status', 'created_at', 'updated_at', 'userAdd'], 'required','message'=>'{attribute} không được để trống'],
            [['groupId', 'parent_id', 'sort', 'created_at', 'updated_at', 'userAdd'], 'integer','message'=>'{attribute} không phải là số'],
            [['descriptions'], 'string'],
            [['cateName', 'link', 'images', 'title', 'keyword'], 'string', 'max' => 255,'message'=>'{attribute} dài nhất 255 ký tự'],
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
            'cateName' => 'Tên danh mục',
            'groupId' => 'Nhóm danh mục',
            'parent_id' => 'Danh mục cha',
            'link' => 'Liên kết',
            'images' => 'Ảnh',
            'sort' => 'Thứ tự',
            'title' => 'Tiêu đề',
            'keyword' => 'Từ khóa',
            'descriptions' => 'Descriptions',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày update',
            'userAdd' => 'Người tạo',
        ];
    }

    public static function dropdown()
    {
        // get and cache data
        static $dropdown;
        if ($dropdown === null) {
            // get all records from database and generate
            $models = static::find()->all();
            foreach ($models as $value) {
                $dropdown[$value->id] = $value->cateName;
            }
        }

        return $dropdown;
    }

    public $data;
    public function getCategoryParent($parent = 0, $level =""){
        $result = Categories::find()->asArray()->where('parent_id=:parent',['parent'=>$parent])->all();
        // Tim tat ca cac 
        $level .=" --| ";
        foreach ($result as $key => $value) {
            if($parent == 0){
                $level = "";
            }
            $this->data[$value["id"]] = $level.$value["cateName"];
            self::getCategoryParent($value['id'],$level);
        }
        return $this->data;
    }
}

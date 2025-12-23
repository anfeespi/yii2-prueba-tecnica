<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $project_id
 * @property string $title
 * @property string|null $description
 * @property string $status
 * @property int $priority 1 to 5
 * @property string|null $due_date
 * @property int $created_by
 * @property int|null $assigned_to
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $assignedTo
 * @property User $createdBy
 * @property Project $project
 */
class Task extends \yii\db\ActiveRecord
{

    const STATUS_TODO = 'todo';
    const STATUS_DOING = 'doing';
    const STATUS_DONE = 'done';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'due_date', 'assigned_to'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'todo'],
            [['priority'], 'default', 'value' => 1],
            [['project_id', 'title'], 'required'],
            [['project_id', 'priority', 'created_by', 'assigned_to', 'created_at', 'updated_at'], 'integer'],
            [['description', 'status'], 'string'],
            [['due_date'], 'safe'],
            [['title'], 'string', 'max' => 255],
            ['status', 'in', 'range' => array_keys(self::optsStatus())],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['assigned_to' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'priority' => 'Priority',
            'due_date' => 'Due Date',
            'created_by' => 'Created By',
            'assigned_to' => 'Assigned To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[AssignedTo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(User::class, ['id' => 'assigned_to']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }


    /**
     * column status ENUM value labels
     * @return string[]
     */
    public static function optsStatus()
    {
        return [
            self::STATUS_TODO => 'todo',
            self::STATUS_DOING => 'doing',
            self::STATUS_DONE => 'done',
        ];
    }

    /**
     * @return string
     */
    public function displayStatus()
    {
        return self::optsStatus()[$this->status];
    }

    /**
     * @return bool
     */
    public function isStatusTodo()
    {
        return $this->status === self::STATUS_TODO;
    }

    public function setStatusToTodo()
    {
        $this->status = self::STATUS_TODO;
    }

    /**
     * @return bool
     */
    public function isStatusDoing()
    {
        return $this->status === self::STATUS_DOING;
    }

    public function setStatusToDoing()
    {
        $this->status = self::STATUS_DOING;
    }

    /**
     * @return bool
     */
    public function isStatusDone()
    {
        return $this->status === self::STATUS_DONE;
    }

    public function setStatusToDone()
    {
        $this->status = self::STATUS_DONE;
    }
}

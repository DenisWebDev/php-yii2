<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31.03.2019
 * Time: 14:14
 */

namespace app\components;


use app\models\Activity;
use Faker\Factory;
use yii\base\Component;
use yii\caching\DbDependency;
use yii\caching\ExpressionDependency;
use yii\caching\TagDependency;
use yii\db\Query;

class DaoComponent extends Component
{
    private function db() {
        return \Yii::$app->db;
    }

    public function getActivities($options = [])
    {
        $query = (new Query())->select('a.*, u.email AS user_email')
            ->from('activity AS a')
            ->leftJoin('user AS u', 'u.id = a.user_id');

        if (isset($options['user_id'])) {
            $query->andWhere(['a.user_id' => $options['user_id']]);
        }

        if (isset($options['user_email'])) {
            $query->andWhere(['like', 'u.email', $options['user_email']]);
        }

        return $query->cache('7',new DbDependency(['sql' => 'select max(id) from activity']))->all();
    }

    public function addRandomData()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $this->db()->createCommand()->upsert('user', [
                'email' => $faker->email,
                'password_hash' => uniqid(),
                'auth_key' => uniqid(),
            ], false)->execute();
        }

        $repeat_type_ids = array_keys((new Activity())->getRepeatTypes());

        $user_ids = (new Query())->select('id')->from('user')->column();

        $data = [];
        for ($i = 0; $i < 50; $i++) {

            $date = (new \DateTime());
            $date->add(new \DateInterval('P'.mt_rand(1, 20).'D'));
            $date_start = $date->format('Y-m-d');

            $date_end = null;
            if (mt_rand(0, 2) or 1) {
                $date->add(new \DateInterval('P'.mt_rand(1, 20).'D'));
                $date_end = $date->format('Y-m-d');
            }

            $use_notification = mt_rand(0, 1);
            if ($use_notification) {
                $email = $faker->email;
            } else {
                $email = null;
            }


            $data[] = [
                'title' => $faker->text(mt_rand(50, 150)),
                'description' => $faker->text(mt_rand(200, 500)),
                'date_start' => $date_start,
                'date_end' => $date_end,
                'repeat_type_id' => $repeat_type_ids[array_rand($repeat_type_ids)],
                'is_blocked' => mt_rand(0, 1),
                'use_notification' => $use_notification,
                'email' => $email,
                'user_id' => $user_ids[array_rand($user_ids)],
            ];
        }

        $this->db()->createCommand()->batchInsert('activity',
            array_keys($data[0]),
            $data
        )->execute();



    }

    public function clear() {
        $this->db()->createCommand()->truncateTable('activity')->execute();

        $this->db()->createCommand('DELETE FROM user WHERE id <> 1')->execute();

        $this->db()->createCommand('ALTER TABLE user AUTO_INCREMENT = 2')->execute();
    }

    public function getRandActivityUserId()
    {
//        TagDependency::invalidate(\Yii::$app->cache,'tag1');
        return (new Query())->from('activity')
            ->select('user_id')
            ->orderBy('RAND()')
            ->limit(1)
            ->cache(10,new TagDependency(['tags' => 'tag1']))
            ->scalar();
    }

    public function getRandActivityUserEmail()
    {
        return (new Query())->from('activity AS a')
            ->leftJoin('user AS u', 'u.id = a.user_id')
            ->select('u.email')
            ->orderBy('RAND()')
            ->limit(1)
            ->cache(10)
            ->scalar();
    }

}
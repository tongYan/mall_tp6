<?php


namespace app\common\business;


use think\Exception;

class Category
{
    public $model;
    public function __construct()
    {
        $this->model = new \app\model\Category();
    }

    /**
     * 新增分类
     * @param $data
     * @return bool
     * @throws Exception
     */
    public function save($data)
    {
        //判断分类名称是否已存在
        $exist = $this->model->getCategoryByName($data['name']);
        if ($exist){
            throw new Exception('category name exist');
        }

        $data['status'] = config('status.mysql.table_normal');
        $res = $this->model->save($data);
        if ($res){
            return true;
        }
        return false;

    }

    /**
     * 获取分类
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategory()
    {
        $categorys =  $this->model->where(['status'=>config('status.mysql.table_normal')])
            ->order(['listorder'=>'desc','id'=>'desc'])
            ->field('id,pid,name')
            ->select();
        return empty($categorys) ? [] : $categorys->toArray();

    }

    public function getNormalCategoryByPid($pid = 0,$field='id,name')
    {
        try {
            $categorys =  $this->model->getNormalCategoryByPid($pid,$field);
        } catch (Exception $e)
        {
            return [];
        }
        return $categorys->toArray();

    }

    public function getList($pid)
    {
        return $this->model->getCategoryByPid($pid);
    }

    public function getCategoryById($id)
    {
        $res = $this->model->where(['id'=>$id])->find();
        return $res ? $res->toArray() : [];
    }

    /**
     * 修改分类排序
     * @param $id
     * @param $list_order
     * @return \app\model\Category
     * @throws Exception
     */
    public function editListOrder($id,$listorder)
    {
        //判断分类是否存在
        $category = $this->getCategoryById($id);
        if (!$category){
            throw new Exception('category not exist');
        }
        return $this->model->updateById($id,['listorder'=>$listorder]);

    }

    public function editStatus($id,$status)
    {
        //判断分类是否存在
        $category = $this->getCategoryById($id);
        if (!$category){
            throw new Exception('category not exist');
        }
        if ($status == $category['status']){
            throw new Exception('status equal');
        }
        return $this->model->updateById($id,['status'=>$status]);

    }

    /**
     * 分类树，支持无限极分类
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function tree()
    {
        $categorys = $this->getNormalCategory();
        $items = [];
        foreach ($categorys as $v)
        {
            $v['category_id'] = $v['id'];
            unset($v['id']);
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $key=>$val){
            if (isset($items[$val['pid']])){
                $items[$val['pid']]['list'][] = &$items[$key];
            } else {
                $tree[] = &$items[$key];
            }

        }
        return $tree;
    }

    public function getSliceTree($first_count=5,$second_count=3,$third_count=3)
    {
        $tree = $this->tree();
        $tree = array_slice($tree,0,$first_count);
        foreach ($tree as $k1=>$v1){
            if (isset($tree[$k1]['list'])){
                $tree[$k1]['list'] = array_slice($v1['list'],0,$second_count);
                foreach ($tree[$k1]['list'] as $k2=>&$v2){
                    if (isset($v2['list'])){
//                        $tree[$k1]['list'][$k1]['list'] = array_slice($v1['list'],0,$third_count);
                        $v2['list'] = array_slice($v2['list'],0,$third_count);
                    }
                }
            }
        }
//        halt($tree);

        return $tree;

    }

    /**
     * 获取多个分类及其子分类的信息
     * @param $pids
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getChildByPids($pids)
    {
        $category = $this->model->getNormalInIds($pids);
        $where = [
            ['pid','in',$pids],
            ['status','=',1]
        ];
        $childen = $this->model->getByCondition([$where]);
        $data = [];
        foreach ($category as $val){
            $data[$val['id']] = [
                'category_id' => $val['id'],
                'name' => $val['name'],
                'icon' => '',
            ];
        }
        foreach ($childen as $v){
            $data[$v['pid']]['list'][] = [
                'category_id' => $v['id'],
                'name' => $v['name'],
            ];
        }
        return array_values($data);
    }


    /**
     * 商城前端分页搜索
     * @param $id
     * @return array
     */
    public function getIndexCategoryById($id)
    {
        
        $category = $this->getCategoryById($id);
        if ($category['pid']==0){ // 此时是一级分类，获取二级分类
            $childs = $this->getNormalCategoryByPid($id,'id,name');
            if (empty($childs)){
                return [];
            }
            $res = [
                'name' => $category['name'],
                'focus_ids' => [],
                'list' => [$childs],
            ];

        } else {
            $parent = $this->getCategoryById($category['pid']);
            if ($parent['pid']==0) { // 此时是二级分类
                $category2 = $this->getNormalCategoryByPid($parent['id'],'id,name');
                $category3 = $this->getNormalCategoryByPid($category['id'],'id,name');
                $res = [
                    'name' => $category['name'],
                    'focus_ids' => [$category['id']],
                    'list' => [$category2,$category3],
                ];
            }else{  //三级分类
                $category1 = $this->getCategoryById($parent['pid']);
                $category2 = $this->getNormalCategoryByPid($category1['id'],'id,name');
                $category3 = $this->getNormalCategoryByPid($parent['id'],'id,name');
                $res = [
                    'name' => $category1['name'],
                    'focus_ids' => [$parent['id'],$id],
                    'list' => [$category2,$category3],
                ];
            }
        }

        return $res;



    }

}
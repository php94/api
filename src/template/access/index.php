{include common/header@php94/admin}
<div class="my-4">
    <div class="h1">授权管理</div>
</div>

<div class="bg-light p-3 border">
    <div class="my-4">
        <form class="row gy-2 gx-3 align-items-center" action="{echo $router->build('/php94/api/access/index')}" method="GET">
            <input type="hidden" name="token_id" value="{$token.id}">
            <div class="col-auto">
                <label class="visually-hidden">搜索</label>
                <input type="search" class="form-control" name="q" value="{:$request->get('q')}" placeholder="接口搜索:" onchange="this.form.submit();">
            </div>
        </form>
    </div>

    <div class="table-responsive my-4">
        <table class="table table-bordered table-striped d-table-cell">
            <thead>
                <tr>
                    <th class="text-nowrap">接口</th>
                    <th class="text-nowrap">标题</th>
                    <th class="text-nowrap">简介</th>
                    <th class="text-nowrap">管理</th>
                </tr>
            </thead>
            <tbody>
                {foreach $apis as $vo}
                <tr>
                    <td>{$vo.path}</td>
                    <td>{$vo.title}</td>
                    <td>{$vo.description}</td>
                    <td>
                        <a href="{echo $router->build('/php94/api/access/create', ['api_id'=>$vo['id'],'token_id'=>$token['id']])}">授权</a>
                    </td>
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>

<div class="text-danger fw-bold my-3">已授权接口:</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped d-table-cell">
        <thead>
            <tr>
                <th class="text-nowrap">接口路径</th>
                <th class="text-nowrap">接口标题</th>
                <th class="text-nowrap">授权方法</th>
                <th class="text-nowrap">管理</th>
            </tr>
        </thead>
        <tbody>
            {foreach $datas as $vo}
            <tr>
                <td>{$vo['api']['path']}</td>
                <td>{$vo['api']['title']}</td>
                <td>{$vo['methods']}</td>
                <td>
                    <a href="{echo $router->build('/php94/api/access/update', ['id'=>$vo['id']])}">编辑</a>
                    <a href="{echo $router->build('/php94/api/access/delete', ['id'=>$vo['id']])}" onclick="return confirm('确定删除吗？删除后不可恢复！');">删除</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
{include common/footer@php94/admin}